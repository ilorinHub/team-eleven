<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\TransactionReferenceInterface;
use App\Services\Payment\Utilities\TransactionReferenceService;

class TransactionReferenceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TransactionReferenceInterface::class, TransactionReferenceService::class);
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
