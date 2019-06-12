<?php

namespace Tests\Feature\HttpController\Ticketshop;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Event;
use App\PaymentProvider\Klarna;

class CheckOutControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * Test last overview before customer gets redirected to payment provider
     *
     * @return void
     */
    public function testPurchaseOverview()
    {
        $event = factory(Event::class)->create();
        // Refresh in order to convert date objects to strings
        $event->refresh();

        $customerData = [
            'email' => $this->faker->safeEmail,
            'name'  => $this->faker->name()
        ];

        $tickets = [];
        foreach($event->priceList->categories as $category)
        {
            $tickets[$category->id] = 1;
        }

        $response = $this->withSession([
            'customerData' => $customerData,
            'event' => $event,
            'tickets' => $tickets
        ])->get('/ts/overview');
        $response->assertStatus(200);
    }

    /**
     * Test redirect to payment providers
     * 
     * @return void
     */
    public function testCommitPurchase()
    {
        $event = factory(Event::class)->create();
        // Refresh in order to convert date objects to strings
        $event->refresh();

        $customerData = [
            'email' => $this->faker->safeEmail,
            'name'  => $this->faker->name()
        ];

        $tickets = [];
        foreach($event->priceList->categories as $category)
        {
            $tickets[$category->id] = 1;
        }

        $this->mock(Klarna::class, function ($mock) {
            $mock->shouldReceive('getPaymentUrl')
                ->once()
                ->andReturn('http://localhost/mockKlarna');
        });

        $response = $this->withSession([
            'customerData' => $customerData,
            'event' => $event,
            'tickets' => $tickets
        ])->post('/ts/pay', [
            'paymethod' => 'Klarna'
        ]);
        $response->assertRedirect();
    }
}
