<?php

namespace Tests\Feature\HttpController\Ticketshop;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Event;
use App\PriceCategory;

class SeatMapControllerTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSelectingCategories()
    {
        $event = factory(Event::class)->create();
        $standaloneCategory = factory(PriceCategory::class)->create();

        // Positiv test when category and amount of tickets is right
        $response = $this->post("/ts/$event->id/seatmap", [
            'tickets' => [$event->priceList->categories()->first()->id => 4]
        ]);
        $response->assertRedirect(route('ts.customerData'));

        // Negativ test when category is right, but amount is too high
        $response = $this->post("/ts/$event->id/seatmap", [
            'tickets' => [$event->priceList->categories()->first()->id => 9]
        ]);
        $response->assertRedirect('/');

        // Negativ test when category is right, but amount is too low
        $response = $this->post("/ts/$event->id/seatmap", [
            'tickets' => [$event->priceList->categories()->first()->id => 0]
        ]);
        $response->assertRedirect('/');

        // Negativ test when a not linked category is selected along with a right one
        $response = $this->post("/ts/$event->id/seatmap", [
            'tickets' => [
                $event->priceList->categories()->first()->id => 4,
                $standaloneCategory->id => 2
            ]
        ]);
        $response->assertRedirect('/');

        // Negativ test when only a not linked category is selected
        $response = $this->post("/ts/$event->id/seatmap", [
            'tickets' => [
                $standaloneCategory->id => 2
            ]
        ]);
        $response->assertRedirect('/');
    }
}
