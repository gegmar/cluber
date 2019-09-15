<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttachUsers;
use App\Http\Requests\CreateRole;
use App\Http\Requests\UpdateRole;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function displayRole(Role $role)
    {
        return view('admin.iam.manage-role', [
            'role' => $role,
            'users' => User::whereNotNull('email_verified_at')->orderBy('name', 'ASC')->get(),
            'permissions' => Permission::orderBy('name', 'ASC')->get()
        ]);
    }

    public function updateRole(Role $role, UpdateRole $request)
    {
        $validated = $request->validated();

        // Set the new submitted (direct) role properties
        $role->name = $validated['name'];
        $role->save();

        // Detach all roles from the role
        $role->permissions()->detach();

        // Attach only the given roles to the role
        Log::info('Attached permission-ids ' . implode('|', $validated['permissions']) . ' to role#' . $role->id);
        $role->permissions()->attach($validated['permissions']);

        // On successfull update redirect the browser to the role overview
        return redirect()
            ->route('admin.iam.role.manage', $role)
            ->with('status', 'Update successfull!');
    }

    public function createRole(CreateRole $request)
    {
        $validated = $request->validated();
        $role = Role::create([
            'name' => $validated['name']
        ]);
        // On successfull creation redirect the browser to the role overview
        return redirect()
            ->route('admin.iam.role.manage', $role)
            ->with('status', 'Update successfull!');
    }

    public function deleteRole(Role $role)
    {
        Log::info('Deleting role#' . $role->id . ' (' . $role->name . ') with attached user-ids ' . $role->users->implode('id', '|') . ' and attached permission-ids ' . $role->permissions->implode('id', '|'));

        $role->users()->detach();
        $role->permissions()->detach();
        $role->delete();

        // On successfull deletion redirect the browser to the overview
        return redirect()
            ->route('admin.iam.dashboard')
            ->with('status', 'Deleted role successfull!');
    }

    public function attachUsers(Role $role, AttachUsers $request)
    {
        $validated = $request->validated();

        Log::info('Attaching role#' . $role->id . ' to users with ids' . implode('|', $validated['id']));
        $role->users()->attach($validated['id']);

        return redirect()
            ->route('admin.iam.role.manage', $role)
            ->with('status', 'Users added to role successfully!');
    }

    public function detachUser(Role $role, User $user)
    {
        Log::info('Detaching role#' . $role->id . ' from user#' . $user->id);
        $role->users()->detach($user);
        return redirect()
            ->route('admin.iam.role.manage', $role)
            ->with('status', 'User ' . $user->name . ' removed from role successfully!');
    }
}
