<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicPagesController extends Controller
{
    public function impress()
    {
        return redirect()->away(config('app.impress_url'));
    }

    public function termsAndConditions()
    {
        return view('public.terms');
    }

    public function privacyStatement()
    {
        return view('public.privacy');
    }
}