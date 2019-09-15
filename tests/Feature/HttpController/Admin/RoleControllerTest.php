<?php

namespace Tests\Feature\HttpController\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Role;
use App\User;

class RoleController extends TestCase
{

    /**
     * Create an administrative account to access the protected routes
     */
    protected function createAdminAccount() : User
    {
        $admin = factory(User::class)->create([
            'email_verified_at' => new \DateTime()
        ]);
        $adminRole = Role::where('name', 'Administrator')->first();
        $admin->roles()->attach($adminRole);
        return $admin;
    }


    /**
     * Test adding a new role.
     *
     * @return void
     */
    public function testRoleCreation()
    {
        $admin = $this->createAdminAccount();
        $response = $this->actingAs($admin)->post('/admin/iam/role/add', [
            'name' => 'New ROLE'
        ]); 

        $response->assertStatus(302);
        $newRolesCount = Role::where('name', 'New ROLE')->get()->count();
        $this->assertTrue($newRolesCount > 0);
    }
}
