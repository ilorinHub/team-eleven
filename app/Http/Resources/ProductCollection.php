<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public static $wrap = 'products';

    public function toArray($request)
    {
        return [
            'products' => $this->collection,
        ];
    }
}