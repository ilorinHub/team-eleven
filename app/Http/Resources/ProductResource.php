<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public static $wrap = 'product';

    public function toArray($request)
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'slug' => $this->slug,
            'priceable_type' => $this->priceable_type,
            'cost_per_unit' => toCurrenyUnit($this->priceable->cost_per_unit),
            'minimum' => $this->priceable->minimum,
            'categories' => $this->categories->map(fn($category) => [
              'name' => $category->name,
              'slug' => $category->slug
            ]),
              'photo_url' => $this->photo_url
          ];
    }
}
