<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StartController extends Controller
{
    /**
     * Redirect the browser to the appropriate shop site
     */
    public function index()
    {
        if (Auth::user() != null && Auth::user()->hasPermission('SELL_TICKETS')) {
            return redirect()->route('retail.sell.events');
        }

        return redirect()->route('ts.events');
    }

    /**
     * Change the current locale to the given value
     */
    public function changeLocale($locale)
    {
        session(['locale' => $locale]);
        return redirect()->back();
    }

    /**
     * Return the currently stored logo
     */
    public function getLogo()
    {
        $logo = Setting::where('name', 'logo')->first();
        if( $logo ) {
            return response()->file(Storage::path($logo->value));
        } else {
            return redirect(asset('img/logos/fa-ticket.png'));
        }
    }
}
