<?php

namespace Ddbaidya\LaravelPaypal;

use Illuminate\Support\ServiceProvider;

class PaypalServiceProvider extends ServiceProvider
{
    /**
     * Register paypal services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap paypal application services.
     */
    public function boot(): void
    {
        // Publish config files
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('paypal.php'),
        ]);
    }
}
