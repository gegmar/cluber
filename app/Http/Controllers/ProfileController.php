<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getProfile()
    {
        return view('profile');
    }

    public function update()
    {

    }
}
