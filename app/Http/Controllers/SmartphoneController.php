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
        $params = $request->all();
        echo json_encode($params, JSON_PRETTY_PRINT);

//        if (array_key_exists('min_price', $params))
//            $query->where("price", ">", $params['min_price']);
//
//        if (array_key_exists('max_price', $params))
//            $query->where("price", "<", $params['max_price']);
//
////        if ()
////            $query->where("type", Input::get("type"))->get();
////
////        if (Input::get("category"))
////            $query->where("category", Input::get("category"))->get();
//
////        $smartphones = $query->get()->orderBy('price', $sort)->paginate(12);
//        $smartphones = $query->get();


        $smartphones = Smartphone::query()->with('brand');

        if (array_key_exists('min-price', $params)) {
            $smartphones = $smartphones->minPrice($params['min-price']);
        }
        if (array_key_exists('max-price', $params)) {
            $smartphones = $smartphones->maxPrice($params['max-price']);
        }

        $brands = [];
        foreach ($params as $key => $value) {
            if ($value == 'on') {
                array_push($brands, $key);
            }
        }

        if (!empty($brands)) {
            $smartphones = $smartphones->ofBrand($brands);
        }

        $sort = array_key_exists('sort', $params) ? $params['sort'] : 'desc';
        $smartphones = $smartphones->orderBy('price', $sort)->paginate(3);

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
