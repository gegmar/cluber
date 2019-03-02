<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StartController extends Controller
{
    /**
     * Redirect the browser to the appropriate shop site
     */
    public function index(Request $request)
    {
        if (Auth::user() != null && Auth::user()->hasPermission('SELL_TICKETS')) {
            return redirect()->route('retail.sell.events');
        }

        return redirect()->route('ts.events');
    }
}
