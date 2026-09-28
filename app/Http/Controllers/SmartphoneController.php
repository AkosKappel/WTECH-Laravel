<?php

namespace App\Http\Controllers;


use App\Models\Brand;
use App\Models\Color;
use App\Models\Image;
use App\Models\Smartphone;
use App\Support\CatalogFilters;
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
        $filters = CatalogFilters::fromRequest($request);

        // one clean URL per set of filters; old links (?Apple=Apple&min-price=…) redirect permanently
        if ((string) $request->server('QUERY_STRING') !== $filters->canonicalQueryString()) {
            return redirect()->to($filters->url([], true), $filters->legacy ? 301 : 302);
        }

        $smartphones = $filters->applySort($filters->apply(Smartphone::query()))
            ->with(['images', 'brand', 'color'])
            ->paginate(12)
            ->withPath($filters->url());

        $data = [
            'smartphones' => $smartphones,
            'filters' => $filters,
            'facets' => $filters->facets(),
            'priceBounds' => CatalogFilters::priceBounds(),
        ];

        // filter changes from catalog-filters.js: only the parts of the page that change
        if ($request->header('X-Catalog-Partial') === '1') {
            return response()->json([
                'title' => $filters->pageTitle(),
                'status' => trans_choice(':count phone|:count phones', $smartphones->total(), ['count' => $smartphones->total()]),
                'filters' => view('layout.products.partials.filters', $data)->render(),
                'results' => view('layout.products.partials.results', $data)->render(),
            ])->header('Vary', 'X-Catalog-Partial')->header('Cache-Control', 'no-store, private');
        }

        return response()->view('layout.products.smartphones', $data)->header('Vary', 'X-Catalog-Partial');
    }

    /**
     * Search suggestions for the header search box.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function suggest(Request $request)
    {
        $filters = CatalogFilters::fromRequest($request);
        if (mb_strlen($filters->q) < 2) {
            return response()->json(['results' => [], 'total' => 0]);
        }

        $query = $filters->apply(Smartphone::query());
        $total = (clone $query)->count();
        $results = $filters->applySort($query)->with(['images', 'brand'])->limit(6)->get()
            ->map(function (Smartphone $smartphone) {
                $image = $smartphone->images->first();

                return [
                    'name' => $smartphone->name,
                    'price' => formattedPrice($smartphone->price),
                    'in_stock' => $smartphone->quantity > 0,
                    'image' => $image ? url('wtech/' . ltrim($image->source, '/')) : null,
                    'url' => route('details', $smartphone),
                ];
            });

        return response()->json([
            'results' => $results,
            'total' => $total,
            'all_url' => $filters->url(),
        ]);
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
        $colors = Color::all()->pluck('name_en')->toArray();
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
        $request->validate($this->rules());

        if ($request->color != null) {
            $color_id = Color::firstWhere('name_en', $request->color)->id;
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
            'description_translations' => $this->descriptionTranslations($request),
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
                    'name' => $smartphone->name,
                    'source' => '/images/' . $imageName,
                    'smartphone_id' => $smartphone->id,
                ]);
            }
        }

        $request->session()->flash('message', __('Product :name was successfully added!', ['name' => $request->name]));
        return redirect()->route('admin')->with('success_message', __('Product :name was successfully added!', ['name' => $request->name]));
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
        $colors = Color::all()->pluck('name_en')->toArray();
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
        $request->validate($this->rules());

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
                    'name' => $smartphone->name,
                    'source' => '/images/' . $imageName,
                    'smartphone_id' => $smartphone->id,
                ]);
            }
        }

        if ($request->color != null) {
            $color_id = Color::firstWhere('name_en', $request->color)->id;
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
            'description_translations' => $this->descriptionTranslations($request),
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
        return redirect()->route('admin')->with('success_message', __('Product :name was successfully updated!', ['name' => $smartphone->name]));
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
        return back()->with('success_message', __('Product :name was successfully deleted!', ['name' => $smartphone->name]));
    }

    /**
     * Non-English descriptions from the form, e.g. description_de → ['de' => ...].
     *
     * @param Request $request
     * @return array
     */
    private function descriptionTranslations(Request $request)
    {
        $translations = [];
        foreach (array_keys(config('app.locales')) as $locale) {
            if ($locale !== 'en' && filled($request->input("description_$locale"))) {
                $translations[$locale] = $request->input("description_$locale");
            }
        }

        return $translations;
    }

    /**
     * Validation rules shared by the create and edit forms.
     *
     * @return array
     */
    private function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'description_de' => 'nullable|string',
            'description_sk' => 'nullable|string',
            'ram' => 'nullable|integer|min:0',
            'operating_system' => 'nullable|string|max:255',
            'os_version' => 'nullable|integer|min:0',
            'display_size' => 'nullable|numeric|min:0',
            'resolution' => 'nullable|string|max:255',
            'height' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'thickness' => 'nullable|numeric|min:0',
            'color' => 'nullable|exists:colors,name_en',
            'brand' => 'nullable|exists:brands,name',
            // only real images, so nothing executable ends up in public/images
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:10240',
        ];
    }
}
