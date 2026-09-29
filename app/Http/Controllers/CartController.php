<?php

namespace App\Http\Controllers;

use App\Models\Smartphone;
use Gloudemans\Shoppingcart\Facades\Cart;
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
        $image = $smartphone->images()->first();
        $inCart = Cart::search(function ($item) use ($smartphone) {
            return $item->id == $smartphone->id;
        })->sum('qty');
        $quantity = min($request->quantity, $smartphone->quantity - $inCart);

        if ($quantity < 1) {
            return redirect()->route('cart')->withErrors(['quantity' => __('No more :name in stock.', ['name' => $smartphone->name])]);
        }

        Cart::add($smartphone->id, $smartphone->name, $quantity, $smartphone->price, [
                'image_source' => $image ? $image->source : 'images/no_img_available.jpg',
                'image_name' => $image ? $image->name : 'No image available',
                'max_quantity' => $smartphone->quantity
            ]
        )->associate(Smartphone::class);

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
        $quantity = min($request->product_quantity, $item->options->max_quantity);
        Cart::update($rowId, $quantity);
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
