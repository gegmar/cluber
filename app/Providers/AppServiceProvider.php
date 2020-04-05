<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\PaymentProvider\Klarna;
use App\PaymentProvider\Mollie;
use App\PaymentProvider\PayPal;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('time', function ($expression) {
            return "<?php echo strftime('%H:%M', date_create($expression)->getTimestamp()); ?>";
        });
        Blade::directive('datetime', function ($expression) {
            return "<?php echo strftime('%A, %d.%m.%Y', date_create($expression)->getTimestamp()); ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\PaymentProvider\Klarna', function() {
            return new Klarna( config('paymentprovider.sofortConfigKey') );
        });

        $this->app->bind('App\PaymentProvider\PayPal', function() {
            return new PayPal(
                config('paymentprovider.payPalClientId'),     // ClientID
                config('paymentprovider.payPalClientSecret')  // ClientSecret
            );
        });

        $this->app->bind('App\PaymentProvider\Mollie', function() {
            return new Mollie( config('paymentprovider.mollieApiKey') );
        });
    }
}
