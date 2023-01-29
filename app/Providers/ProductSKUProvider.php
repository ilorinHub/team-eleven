<?php

namespace App\Providers;

use App\Contracts\ProductSkuInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\Product\Utilities\ProductSkuService;

class ProductSKUProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProductSkuInterface::class, ProductSkuService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
