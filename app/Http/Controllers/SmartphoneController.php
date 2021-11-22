<?php

namespace App\Http\Controllers;


use App\Models\Brand;
use App\Models\Color;
use App\Models\Smartphone;
use Illuminate\Http\Request;

class SmartphoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $brands = Brand::all()->pluck('name')->toArray();
        $colors = Color::all()->pluck('name_sk', 'name_en')->toArray();

        // JSON styled container for saving applied filters
        $params = [];

        // save applied prices to JSON
        $params['min-price'] = $request['min-price'];
        $params['max-price'] = $request['max-price'];

        // save applied brands to JSON
        $brandParams = [];
        foreach ($brands as $brand) {
            if ($request[$brand]) {
                array_push($brandParams, ['name' => $brand, 'status' => true]);
            } else {
                array_push($brandParams, ['name' => $brand, 'status' => false]);
            }
        }
        $params['brands'] = $brandParams;

        // save applied colors to JSON
        $colorParams = [];
        foreach ($colors as $color_en => $color_sk) {
            if ($request[$color_en]) {
                array_push($colorParams, ['name-en' => $color_en, 'name-sk' => $color_sk, 'status' => true]);
            } else {
                array_push($colorParams, ['name-en' => $color_en, 'name-sk' => $color_sk, 'status' => false]);
            }
        }
        $params['colors'] = $colorParams;
        $sortParams = [];
        array_push($sortParams, ['id' => 'asc', 'name' => 'Najlacnejších', 'status' => $request['sort'] == 'asc']);
        array_push($sortParams, ['id' => 'desc', 'name' => 'Najdrahších', 'status' => $request['sort'] == 'desc']);

        $params['sort'] = $sortParams;

        // creating query with filters, pagination and ordering
        $smartphones = Smartphone::query();


        // apply search query
        if ($request['search']) {
            $searchQuery = '%' . $request['search'] . '%';
            $smartphones = $smartphones
                ->where('name', 'ILIKE', $searchQuery)
                ->orWhere('description', 'ILIKE', $searchQuery)
                ->orWhere('operating_system', 'ILIKE', $searchQuery);
        }

        // filter by min and max price
        if ($request['min-price']) {
            $smartphones = $smartphones->minPrice($request['min-price']);
        }
        if ($request['max-price']) {
            $smartphones = $smartphones->maxPrice($request['max-price']);
        }

        // filter by brands
        $selectedBrands = [];
        foreach ($request->all() as $brand) {
            if (in_array($brand, $brands)) {
                array_push($selectedBrands, $brand);
            }
        }

        if (!empty($selectedBrands)) {
            $smartphones = $smartphones->ofBrand($selectedBrands);
        }

        // filter by colors
        $selectedColors = [];
        foreach ($request->all() as $color) {
            if (in_array($color, array_keys($colors))) {
                array_push($selectedColors, $color);
            }
        }

        if (!empty($selectedColors)) {
            $smartphones = $smartphones->ofColor($selectedColors);
        }

        // ordering and pagination
        $sort = $request['sort'] ? $request['sort'] : null;
        if($sort != null) {
            $smartphones = $smartphones->orderBy('price', $sort);
        }

        $smartphones = $smartphones->paginate(12);

        return view('layout.products.smartphones',
            ['smartphones' => $smartphones],
            ['params' => $params],
        );
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
