<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUser;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $activeUsers = User::whereNotNull('email_verified_at')->get();
        return view('admin.iam.users-and-roles', [
            'users' => $activeUsers,
            'roles' => Role::orderBy('name', 'ASC')->get()
        ]);
    }

    public function displayUser(User $user)
    {
        return view('admin.iam.manage-user', [
            'user' => $user,
            'roles' => Role::orderBy('name', 'ASC')->get()
        ]);
    }

    /**
     * Update the user with the given email address, name and roles
     */
    public function updateUser(User $user, UpdateUser $request)
    {
        $validated = $request->validated();

        // Set the new submitted (direct) user properties
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        // Detach all roles from the user
        $user->roles()->detach();

        // Attach only the given roles to the user
        Log::info('Updating user#' . $user->id . ' with role-ids ' . implode('|', $validated['roles']));
        $user->roles()->attach($validated['roles']);

        // On successfull update redirect the browser to the user overview
        return redirect()
            ->route('admin.iam.user.manage', $user)
            ->with('status', 'Update successfull!');
    }
}
