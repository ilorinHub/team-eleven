<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class ProductController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $products = \App\Models\Product::with('priceable', 'categories');

        return new \App\Http\Resources\ProductCollection($products->simplePaginate(16));
    }
}
