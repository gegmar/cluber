<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StartControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testAnonRedirect()
    {
        $response = $this->get('/');
        $response->assertRedirect('/ts');
    }

    public function testAuthRedirect()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/');
        $response->assertRedirect('/ts');
    }

    public function testAuthorizedRedirect()
    {
        $user = factory(User::class)->create();
        $user->roles()->attach(1);

        $response = $this->actingAs($user)->get('/');
        $response->assertRedirect('/retail/sell');
    }
}
