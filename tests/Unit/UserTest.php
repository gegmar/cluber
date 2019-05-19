<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use App\Role;
use App\Permission;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testhasPermission()
    {
        $user = factory(User::class)->create();

        $role1 = factory(Role::class)->create();
        $pem1 = factory(Permission::class)->create();
        $pem2 = factory(Permission::class)->create();

        $role2 = factory(Role::class)->create();
        $pem3 = factory(Permission::class)->create();

        $role1->permissions()->attach([$pem1->id, $pem2->id]);
        $role2->permissions()->attach($pem3);

        // Test non existing permission
        $this->assertFalse($user->hasPermission('FANTASY_PERMISSION'));
        // Test permission not connected
        $this->assertFalse($user->hasPermission($pem1->name));

        $user->roles()->attach($role1->id);
        $user->refresh();
        // Test permission freshly connected
        $this->assertTrue($user->hasPermission($pem1->name));

        $user->roles()->attach($role2->id);
        $user->refresh();
        // Test old permission connected
        $this->assertTrue($user->hasPermission($pem2->name));
        // Test permission freshly connected
        $this->assertTrue($user->hasPermission($pem3->name));
    }
}
