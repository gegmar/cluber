<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->session()->get('locale', config('app.locale'));
        App::setLocale($locale);
        if(config('app.locale_time')) {
            setlocale(LC_TIME, config('app.locale_time'));
        } else {
            setlocale(LC_TIME, $locale);
        }
        return $next($request);
    }
}
