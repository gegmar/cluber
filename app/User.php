<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function permissions()
    {
        $permissions = collect([]);
        $this->roles->each(function ($role) use (&$permissions) {
            $role->permissions->each(function ($permission) use (&$permissions) {
                $permissions->push($permission);
            });
        });
        return $permissions;
        // This approach would require 1:n-relations between models, but those are n:m-relations
        // return $this->hasManyThrough('App\Permission', 'App\Role');
    }

    public function deleteWithRoles()
    {
        $this->roles()->detach();
        $this->delete();
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function purchases()
    {
        return $this->hasMany('App\Purchase', 'customer_id');
    }

    public function purchasesAsVendor()
    {
        return $this->hasMany('App\Purchase', 'vendor_id');
    }

    public function hasPermission($permission)
    {
        return $this->permissions()->containsStrict('name', $permission);
    }
}
