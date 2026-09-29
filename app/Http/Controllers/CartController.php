<?php

namespace App\Http\Controllers;

use App\Models\Smartphone;
use App\Facades\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request)
    {
        return view('layout/cart/cart');
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
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:smartphones,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // name, price and stock are taken from the database, never from the form
        $smartphone = Smartphone::findOrFail($request->id);
        $quantity = min($request->quantity, $smartphone->quantity - Cart::quantityOf($smartphone->id));

        if ($quantity < 1) {
            return redirect()->route('cart')->withErrors(['quantity' => __('No more :name in stock.', ['name' => $smartphone->name])]);
        }

        Cart::add($smartphone, $quantity);

        return redirect()->route('cart')->with('success_message', __('Product was added to cart!'));
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, $rowId)
    {
        $request->validate(['product_quantity' => 'required|integer|min:0']);

        $item = Cart::get($rowId);
        if ($item !== null) {
            Cart::update($rowId, min($request->product_quantity, $item->maxQuantity));
        }
        return redirect()->route('cart');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        Cart::remove($id);
        return back()->with('success_message', __('Product was removed from cart!'));
    }
}
