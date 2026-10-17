<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * A phone in the public catalog API. Prices are numbers in euros; descriptions are the
 * English original plus the translations.
 */
class SmartphoneResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'brand' => $this->brand?->name,
            'color' => $this->color?->name_en,
            'price' => round((float) $this->price, 2),
            'currency' => 'EUR',
            'in_stock' => $this->quantity > 0,
            'stock' => (int) $this->quantity,
            'specs' => [
                'ram_gb' => $this->ram,
                'operating_system' => $this->operating_system,
                'os_version' => $this->os_version,
                'display_inches' => $this->display_size,
                'resolution' => $this->resolution,
                'dimensions_mm' => ['height' => $this->height, 'width' => $this->width, 'thickness' => $this->thickness],
            ],
            'description' => $this->description,
            'description_translations' => $this->description_translations ?? (object) [],
            'images' => $this->images->map->url,
            'url' => route('details', $this->resource),
        ];
    }
}
