<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        //
    }
}
