<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SmartphoneResource;
use App\Models\Smartphone;
use App\Support\CatalogFilters;
use Illuminate\Http\Request;

/**
 * Read-only catalog API. The list takes the same parameters as the shop's catalog
 * (q, brand, color, price, ram, display, os, stock, sort, page).
 */
class SmartphoneController extends Controller
{
    public function index(Request $request)
    {
        $filters = CatalogFilters::fromRequest($request);

        $smartphones = $filters->applySort($filters->apply(Smartphone::query()))
            ->with(['images', 'brand', 'color'])
            ->paginate(12)
            ->withQueryString();

        return SmartphoneResource::collection($smartphones);
    }

    public function show(Smartphone $smartphone)
    {
        return new SmartphoneResource($smartphone->load(['images', 'brand', 'color']));
    }
}
