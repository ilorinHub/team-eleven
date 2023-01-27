<?php

namespace App\Providers;

use App\Contracts\PaymentInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\Payment\Gateways\FluxpayService;
use App\Services\Payment\Gateways\MonnifyService;
use App\Services\Payment\Gateways\PaystackService;
use App\Services\Payment\Gateways\FlutterwaveService;

class PaymentProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if (!config('payment.provider')) return;
        $provider = match(config('payment.provider')) {
            'flutterwave' => FlutterwaveService::class,
            'fluxpay' => FluxpayService::class,
            'monnify' => MonnifyService::class,
            'paystack' => PaystackService::class,
        };
        $this->app->bind(PaymentInterface::class, $provider);

        $this->app->bind(PaystackService::class, function ($app) {
            return new PaystackService(
                config('paystack.secret_key'),
                config('paystack.initialize_url')
            );
        });

        $this->app->bind(FluxpayService::class, function ($app) {
            return new FluxpayService(
                config('fluxpay.key'),
                config('fluxpay.secret'),
                config('fluxpay.auth_url'),
            );
        });

        $this->app->bind(FlutterwaveService::class, function ($app) {
            return new FlutterwaveService(
                config('flutterwave.secret_key'),
                config('flutterwave.standard_url')
            );
        });

        $this->app->bind(MonnifyService::class, function ($app) {
            return new MonnifyService(
                config('monnify.api_key'),
                config('monnify.secret_key'),
                config('monnify.auth_url'),
            );
        });
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
