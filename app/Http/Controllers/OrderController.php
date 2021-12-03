<?php

namespace App\Http\Controllers;

use App\Models\Smartphone;
use App\Models\User;
use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function addressIndex()
    {
        return view('layout/order/address');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function deliveryIndex()
    {
        return view('layout/order/delivery');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function paymentIndex()
    {
        return view('layout/order/payment');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function addressStore(Request $request)
    {
        $emailValidation = Auth()->user() ? 'required|email|max:255' : 'required|email|max:255|unique:users';

        $potentialUser = User::firstWhere('email', $request->email);
        $showCreateAccount = true;

        if (!is_null($potentialUser)) {
            $emailValidation = 'required|email|max:255';
            if (!is_null($potentialUser->password)) {
                $showCreateAccount = false;
            }
        }
        $request->session()->put('showCreateAccount', $showCreateAccount);

        $request->validate([
            'first_name' => 'required|string|max:255|',
            'last_name' => 'required|string|max:255|',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email' => $emailValidation,
            'street' => 'required|string|max:255|nullable',
            'descriptive_number' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        // Ak je používateľ prihlásený
        if (Auth::check()) {
            User::find(Auth()->user()->id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'street' => $request->street,
                'descriptive_number' => $request->descriptive_number,
                'city' => $request->city,
                'country' => $request->country,
            ]);
        } else {
            $request->session()->put([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'street' => $request->street,
                'descriptive_number' => $request->descriptive_number,
                'city' => $request->city,
                'country' => $request->country,
            ]);
        }

        return redirect('delivery');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function deliveryStore(Request $request)
    {
        $request->validate(['transport' => 'required']);
        $request->session()->put('delivery', $request->transport);
        return redirect('payment');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function paymentStore(Request $request)
    {
        $request->validate(['payment' => 'required']);

        $user = null;
        if (!Auth::check()) {
            $user = User::firstWhere('email', $request->session()->get('email'));
            if ($user == null) {
                $user = User::create([
                    'email' => $request->session()->get('email'),
                    'first_name' => $request->session()->get('first_name'),
                    'last_name' => $request->session()->get('last_name'),
                    'phone_number' => $request->session()->get('phone_number'),
                    'street' => $request->session()->get('street'),
                    'descriptive_number' => $request->session()->get('descriptive_number'),
                    'city' => $request->session()->get('city'),
                    'country' => $request->session()->get('country'),
                ]);
            }
        } else {
            $user = Auth::user();
        }

        $order = Order::create([
            'total_price' => floatval(str_replace(',', '.', str_replace(' ', '', Cart::total()))),
            'delivery_method' => $request->session()->get('delivery'),
            'payment_method' => $request->payment,
            'user_id' => $user->id,
        ]);

        foreach (Cart::content() as $cartSmartphone) {
            $smartphone = Smartphone::find(intval($cartSmartphone->id));
            $count = intval($cartSmartphone->qty);
            $order->smartphones()->save($smartphone, ['count' => $count]);
            $smartphone->quantity -= $count;
            $smartphone->save();
        }

        Cart::destroy();
        $request->session()->forget('showCreateAccount');

        if (!Auth::check() && $request->create_account) {
            return redirect('/finishRegister');
        }
        return redirect('/');
    }

    /** Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
