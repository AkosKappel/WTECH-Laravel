<?php

namespace App\Http\Controllers;


use App\Models\Brand;
use App\Models\Color;
use App\Models\Image;
use App\Models\Smartphone;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as InterventionImage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SmartphoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
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
        array_push($sortParams, ['id' => 'asc', 'name' => 'Cheapest', 'status' => $request['sort'] == 'asc']);
        array_push($sortParams, ['id' => 'desc', 'name' => 'Most Expensive', 'status' => $request['sort'] == 'desc']);

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
        if ($sort != null) {
            $smartphones = $smartphones->orderBy('price', $sort);
        }

        $smartphones = $smartphones->paginate(12);

        return view('layout.products.smartphones',
            ['smartphones' => $smartphones],
            ['params' => $params],
        );
    }

    public function adminIndex(Request $request)
    {
        $smartphones = Smartphone::query()->orderBy('name');
        $smartphones = $smartphones->paginate(12);
        return view('layout.admin.admin',
            ['smartphones' => $smartphones]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $brands = Brand::all()->pluck('name')->toArray();
        $colors = Color::all()->pluck('name_sk')->toArray();
        return view('layout.admin.create', ['colors' => $colors, 'brands' => $brands]);
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        if ($request->color != null) {
            $color_id = Color::firstWhere('name_sk', $request->color)->id;
        } else {
            $color_id = null;
        }

        if ($request->brand != null) {
            $brand_id = Brand::firstWhere('name', $request->brand)->id;
        } else {
            $brand_id = null;
        }

        $smartphone = Smartphone::create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'operating_system' => $request->operating_system,
            'os_version' => $request->os_version,
            'display_size' => $request->display_size,
            'resolution' => $request->resolution,
            'height' => $request->height,
            'width' => $request->width,
            'thickness' => $request->thickness,
            'ram' => $request->ram,
            'color_id' => $color_id,
            'brand_id' => $brand_id
        ]);

        if ($request->images != null) {
            foreach ($request->images as $key => $image) {
                $extension = $image->extension();
                $imageName = 'smartphone-' . $smartphone->id . '-' . $key . '.' . $extension;
//                $image->move(public_path('images'), $imageName);

                $image_resize = InterventionImage::make($image->getRealPath());
//                $image_resize->resize(400, 600);
                $image_resize->save(public_path('/images/') . $imageName);

                Image::create([
                    'name' => 'Obrázok smartfónu',
                    'source' => '/images/' . $imageName,
                    'smartphone_id' => $smartphone->id,
                ]);
            }
        }

        $request->session()->flash('message', "Product {$request->name} was successfully added!");
        return redirect('admin')->with('success_message', "Product {$request->name} was successfully added!");
    }

    /**
     * Display the specified resource.
     *
     * @param Smartphone $smartphone
     * @return Application|Factory|View
     */
    public function show(Smartphone $smartphone)
    {
        return view('layout.products.details', ['smartphone' => $smartphone]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Smartphone $smartphone
     * @return Application|Factory|View|Response
     */
    public function edit(Smartphone $smartphone)
    {
        $brands = Brand::all()->pluck('name')->toArray();
        $colors = Color::all()->pluck('name_sk')->toArray();
        return view('layout.admin.edit', [
            'smartphone' => $smartphone,
            'brands' => $brands,
            'colors' => $colors,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Smartphone $smartphone
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, Smartphone $smartphone)
    {
        foreach ($smartphone->images()->get() as $image) {
            if ($request->has(str_replace('.', '_', $image->source))) {
                $image_model = Image::query()->firstWhere('source', $image->source);
                $image_model->delete();
                if (File::exists(public_path($image->source))) {
                    File::delete(public_path($image->source));
                }
            }
        }

        $count = DB::table('images')->max('id') + 1;
        if ($request->images != null) {
            foreach ($request->images as $key => $image) {
                $extension = $image->extension();
                $id = $count + $key;
                $imageName = 'smartphone-' . $smartphone->id . '-' . $id . '.' . $extension;
                $image->move(public_path('images'), $imageName);
                Image::create([
                    'name' => 'Obrázok smartfónu',
                    'source' => '/images/' . $imageName,
                    'smartphone_id' => $smartphone->id,
                ]);
            }
        }

        if ($request->color != null) {
            $color_id = Color::firstWhere('name_sk', $request->color)->id;
        } else {
            $color_id = null;
        }

        if ($request->brand != null) {
            $brand_id = Brand::firstWhere('name', $request->brand)->id;
        } else {
            $brand_id = null;
        }

        $smartphone->update([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'operating_system' => $request->operating_system,
            'os_version' => $request->os_version,
            'display_size' => $request->display_size,
            'resolution' => $request->resolution,
            'height' => $request->height,
            'width' => $request->width,
            'thickness' => $request->thickness,
            'ram' => $request->ram,
            'color_id' => $color_id,
            'brand_id' => $brand_id
        ]);
        return redirect('admin')->with('success_message', "Product {$smartphone->name} was successfully updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Smartphone $smartphone
     * @return RedirectResponse|Response
     */
    public function destroy(Request $request, Smartphone $smartphone)
    {
        foreach ($smartphone->images()->get() as $image) {
            if (File::exists(public_path($image->source))) {
                File::delete(public_path($image->source));
            }
        }
        $smartphone->delete();
        return back()->with('success_message', "Product {$smartphone->name} was successfully deleted!");
    }
}
