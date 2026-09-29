<?php

namespace App\Http\Controllers;

use App\Models\Smartphone;
use App\Models\User;
use App\Models\Order;
use App\Facades\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    const DELIVERY_METHODS = ['Courier Delivery', 'Personal Pickup', 'Post Office Delivery', 'Parcel Locker'];
    const PAYMENT_METHODS = ['Cash on Delivery', 'Bank Transfer', 'Credit Card', 'Apple Pay', 'Google Pay'];

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
        if (Auth::check()) {
            $emailValidation = ['required', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())];
        } else {
            // a guest may reuse the e-mail of an earlier guest order, but not of a registered account
            $emailValidation = ['required', 'email', 'max:255', Rule::unique('users')->whereNotNull('password')];
        }
        $request->session()->put('showCreateAccount', !Auth::check());

        $request->validate([
            'first_name' => 'required|string|max:255|',
            'last_name' => 'required|string|max:255|',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email' => $emailValidation,
            'street' => 'required|string|max:255|nullable',
            'descriptive_number' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ], [
            'email.unique' => Auth::check()
                ? __('This e-mail is already used by another account.')
                : __('An account with this e-mail already exists. Please log in to order with it.'),
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

        return redirect()->route('delivery');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function deliveryStore(Request $request)
    {
        $request->validate(['transport' => ['required', Rule::in(self::DELIVERY_METHODS)]]);
        $request->session()->put('delivery', $request->transport);
        return redirect()->route('payment');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function paymentStore(Request $request)
    {
        $request->validate(['payment' => ['required', Rule::in(self::PAYMENT_METHODS)]]);

        // the earlier checkout steps must be completed first
        if (Cart::count() == 0) {
            return redirect()->route('cart')->withErrors(['cart' => __('Your cart is empty.')]);
        }
        if (!Auth::check() && !$request->session()->has('email')) {
            return redirect()->route('address');
        }
        if (!$request->session()->has('delivery')) {
            return redirect()->route('delivery');
        }

        // quantities per product, since the same phone can be in the cart more than once
        $counts = [];
        foreach (Cart::content() as $cartSmartphone) {
            $id = intval($cartSmartphone->id);
            $counts[$id] = ($counts[$id] ?? 0) + intval($cartSmartphone->qty);
        }

        $stockError = null;
        $order = DB::transaction(function () use ($request, $counts, &$stockError) {
            // lock the rows so two orders can't sell the same last piece
            $smartphones = Smartphone::whereIn('id', array_keys($counts))->lockForUpdate()->get()->keyBy('id');

            $total = 0;
            foreach ($counts as $id => $count) {
                $smartphone = $smartphones->get($id);
                if (is_null($smartphone)) {
                    $stockError = __('A product in your cart is no longer available. Please remove it.');
                    return null;
                }
                if ($smartphone->quantity < $count) {
                    $stockError = __('Only :count × :name left in stock. Please update your cart.', ['count' => (int) $smartphone->quantity, 'name' => $smartphone->name]);
                    return null;
                }
                $total += $smartphone->price * $count;
            }

            if (Auth::check()) {
                $user = Auth::user();
            } else {
                $details = $request->session()->only([
                    'email', 'first_name', 'last_name', 'phone_number',
                    'street', 'descriptive_number', 'city', 'country',
                ]);
                // an earlier guest order with this e-mail gets the new details, so a later
                // account created from it never exposes the previous customer's address
                $user = User::whereNull('password')->firstWhere('email', $details['email']);
                if (is_null($user)) {
                    $user = User::create($details);
                } else {
                    $user->update($details);
                }
            }

            $order = Order::create([
                'total_price' => round($total, 2),
                'delivery_method' => $request->session()->get('delivery'),
                'payment_method' => $request->payment,
                'user_id' => $user->id,
            ]);

            foreach ($counts as $id => $count) {
                $smartphone = $smartphones->get($id);
                $order->smartphones()->attach($smartphone->id, ['count' => $count, 'price' => $smartphone->price]);
                $smartphone->decrement('quantity', $count);
            }

            return $order;
        });

        if (!is_null($stockError)) {
            return redirect()->route('cart')->withErrors(['cart' => $stockError]);
        }

        Cart::destroy();
        $request->session()->forget(['showCreateAccount', 'finishRegisterUserId']);

        // the confirmation page is tied to this session, so nobody can open other orders by ID
        $request->session()->put('lastOrderId', $order->id);

        // only the password-less guest who just ordered may set a password afterwards
        if (!Auth::check() && $request->create_account && is_null($order->user->password)) {
            $request->session()->put('finishRegisterUserId', $order->user_id);
        }
        return redirect()->route('order.complete');
    }

    /**
     * Show the confirmation of the order placed in this session.
     *
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function complete(Request $request)
    {
        $order = Order::with(['smartphones', 'user'])->find($request->session()->get('lastOrderId'));
        if (is_null($order)) {
            return redirect()->route('home');
        }

        return view('layout/order/complete', [
            'order' => $order,
            'canCreateAccount' => $request->session()->get('finishRegisterUserId') === $order->user_id
                && is_null($order->user->password),
        ]);
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
