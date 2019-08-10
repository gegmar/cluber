<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!auth()->user()->hasPermission($permission)) {
            Log::warning('User#' . auth()->user()->id . ' tried to access ' . $request->url() . ' without the required permission "' . $permission . '".');
            return redirect()->route('ts.events')->with('status', 'Permission denied!');
        }
        return $next($request);
    }
}
