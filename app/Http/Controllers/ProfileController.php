<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        }
        if ($validated['password']) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();
        return redirect()->route('profile.show')->with('status', 'Updated profile successfully!');
    }
}
