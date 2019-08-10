<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function get()
    {
        return view('profile');
    }

    public function update(UpdateProfile $request)
    {
        $validated = $request->validated();
        $user = Auth::user();
        if ($validated['name']) {
            $user->name = $validated['name'];
            Log::info('User#' . $user->id . ' changed its name to ' . $validated['name']);
        }
        if ($validated['password']) {
            $user->password = Hash::make($validated['password']);
            Log::info('User#' . $user->id . ' changed its password');
        }
        $user->save();
        return redirect()->route('profile.show')->with('status', 'Updated profile successfully!');
    }
}
