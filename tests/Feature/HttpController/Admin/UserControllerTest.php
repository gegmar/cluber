<?php

namespace Tests\Feature\HttpController\Admin;

use App\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * Create an administrative account to access the protected routes
     */
    protected function createAdminAccount(): User
    {
        $admin = factory(User::class)->create([
            'email_verified_at' => new \DateTime()
        ]);
        $adminRole = Role::where('name', 'Administrator')->first();
        $admin->roles()->attach($adminRole);
        return $admin;
    }

    /**
     * Check if all necessary users are displayed
     *
     * @return void
     */
    public function testOverview()
    {
        $admin = $this->createAdminAccount();
        $userToSee = factory(User::class)->create([
            'email_verified_at' => new \DateTime()
        ]);
        $userNotToSee = factory(User::class)->create();

        $response = $this->actingAs($admin)->get('/admin/iam');
        $response->assertStatus(200);
        $response->assertSee($userToSee->email);
        $response->assertDontSee($userNotToSee->email);
    }

    /**
     * Check if displaying a single user works
     */
    public function testDisplaySingleUser()
    {
        $admin = $this->createAdminAccount();
        $response = $this->actingAs($admin)->get('/admin/iam/user/' . $admin->id);
        $response->assertStatus(200);
        $response->assertSee('Administrator');
        $response->assertSee($admin->email);
    }

    public function testUpdateUser()
    {
        $admin = $this->createAdminAccount();


        $user = factory(User::class)->create([
            'email_verified_at' => new \DateTime()
        ]);
        $requestUrl = 'admin/iam/user/' . $user->id . '/update';

        $roles = factory(Role::class, 2)->create();

        // Positive testing
        $response = $this->actingAs($admin)->post($requestUrl, [
            'name' => 'Charlie Moa',
            'email' => 'charlie@moa.eu',
            'roles' => $roles->pluck('id')->all()
        ]);

        $response->assertStatus(302); // Redirect to user overview to display the newly set data
        $user->refresh();
        $this->assertTrue(2 === $user->roles->count());
        $this->assertTrue($user->name === 'Charlie Moa');

        // Test validation --> Should return redirect because request is incomplete
        $response = $this->actingAs($admin)->post($requestUrl, [
            'name' => 'Something_irrelevant'
        ]);
        $response->assertStatus(302);
        $user->refresh();
        $this->assertFalse($user->name === 'Something_irrelevant');
    }
}
