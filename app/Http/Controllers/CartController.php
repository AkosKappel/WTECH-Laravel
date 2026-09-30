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

        // cart.js updates the page in place from this instead of reloading it
        if ($request->expectsJson()) {
            $item = Cart::get($rowId);
            abort_if($item === null, 404);

            return response()->json([
                'qty' => $item->qty,
                'itemTotal' => formattedPrice($item->total()),
                'total' => formattedPrice(Cart::total()),
                'count' => Cart::count(),
            ]);
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
