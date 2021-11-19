<?php

namespace App\Http\Controllers;


use App\Models\Image;
use App\Models\Smartphone;
use Illuminate\Http\Request;

class SmartphoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        dd($request->all());
        $ordering = $request->input('sort', 'desc');
//        echo $ordering;
        $smartphones = Smartphone::orderBy('price', $ordering)->paginate(12);

        return view('layout.products.smartphones', ['smartphones' => $smartphones]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Smartphone $smartphone
     * @return \Illuminate\Http\Response
     */
    public function show(Smartphone $smartphone)
    {
        return view('layout.products.details', ['smartphone' => $smartphone]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Smartphone $smartphone
     * @return \Illuminate\Http\Response
     */
    public function edit(Smartphone $smartphone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Smartphone $smartphone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Smartphone $smartphone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Smartphone $smartphone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Smartphone $smartphone)
    {
        //
    }
}
