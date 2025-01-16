<?php

namespace App\Http\Controllers;

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
        Cart::add($request->id, $request->name, $request->quantity, $request->price, [
                'image_source' => $request->image_source,
                'image_name' => $request->image_name,
                'max_quantity' => $request->max_quantity
            ]
        )->associate('App\Smartphone');

        return redirect('/wtech/cart')->with('success_message', 'Produkt bol úspešne pridaný do košíka!');
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
        Cart::update($rowId, $request->product_quantity);
        return redirect('wtech/cart');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        Cart::remove($id);
        return back()->with('success_message', 'Produkt bol úspešne odstránený z košíka!');
    }
}
