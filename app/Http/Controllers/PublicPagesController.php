<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicPagesController extends Controller
{
    public function impress()
    {
        return view('errors.tbd');
    }

    public function termsAndConditions()
    {
        return view('errors.tbd');
    }

    public function privacyStatement()
    {
        return view('errors.tbd');
    }
}