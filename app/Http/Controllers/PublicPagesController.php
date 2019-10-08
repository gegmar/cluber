<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Support\Facades\App;

class PublicPagesController extends Controller
{
    public function impress()
    {
        return redirect()->away(config('app.impress_url'));
    }

    public function termsAndConditions()
    {
        $terms = Setting::where('name', 'terms')->where('lang', App::getLocale())->first();
        $termsHtml = $terms ? $terms->value : view('components.default-texts.terms')->render();

        return view('public.terms', [
            'terms' => $termsHtml
        ]);
    }

    public function privacyStatement()
    {
        $privacy = Setting::where('name', 'privacy')->where('lang', App::getLocale())->first();
        $privHtml = $privacy ? $privacy->value : view('components.default-texts.privacy')->render();

        return view('public.privacy', [
            'privacy' => $privHtml
        ]);
    }
}