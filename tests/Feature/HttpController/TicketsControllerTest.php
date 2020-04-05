<?php

namespace Tests\Feature\HttpController;

use Tests\TestCase;
use App\Ticket;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Purchase;
use App\Event;

class TicketsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testShowTicket()
    {
        $ticket = factory(Ticket::class)->create();
        $response = $this->get("/ticket/$ticket->random_id");

        $response->assertStatus(200);
        $response->assertSee($ticket->purchase->total());
    }

    public function testShowAndDownloadPurchase()
    {
        $purchase = factory(Purchase::class)->create();
        $event = factory(Event::class)->create();
        for ($i = random_int(0, 10); $i < 11; $i++) {
            factory(Ticket::class)->create([
                'purchase_id' => $purchase->id,
                'event_id' => $event->id
            ]);
        }

        $soldStates = ['paid', 'free', 'reserved'];

        $response = $this->get("/ticket/$purchase->random_id/all");
        $response->assertStatus(200);
        $response->assertDontSee("/ticket/$purchase->random_id/download");

        $response = $this->get("/ticket/$purchase->random_id/download");
        $response->assertRedirect('/ts');

        foreach ($soldStates as $state) {
            $purchase->state = $state;
            $purchase->save();
            $response = $this->get("/ticket/$purchase->random_id/all");
            $response->assertStatus(200);
            $response->assertSee($purchase->total());
        }
    }
}
