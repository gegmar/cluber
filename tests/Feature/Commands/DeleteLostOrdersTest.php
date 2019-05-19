<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Purchase;

class DeleteLostOrdersTest extends TestCase
{
    use DatabaseTransactions;

    public function testLostOrderDeletion()
    {
        // Edge-Case#1: 16min old --> to be deleted
        $date1 = new \DateTime();
        factory(Purchase::class)->create([
            'state' => 'in_payment',
            'state_updated' => $date1->sub(new \DateInterval('PT16M'))
        ]);

        // Edge-Case#2: 10min old --> should stay
        $date2 = new \DateTime();
        factory(Purchase::class)->create([
            'state' => 'in_payment',
            'state_updated' => $date2->sub(new \DateInterval('PT10M'))
        ]);

        // Very old purchase --> to be deleted
        $date3 = new \DateTime();
        factory(Purchase::class)->create([
            'state' => 'in_payment',
            'state_updated' => $date3->sub(new \DateInterval('PT1000M'))
        ]);

        // Very new purchase --> should stay
        $date4 = new \DateTime();
        factory(Purchase::class)->create([
            'state' => 'in_payment',
            'state_updated' => $date4->sub(new \DateInterval('PT1M'))
        ]);

        $this->artisan('app:deleteLostOrders')->assertExitCode(0);

        // Check if the command deleted the overdue purchases
        $remaindPurchases = Purchase::where('state', 'deleted')->get();
        $this->assertEquals(2, $remaindPurchases->count());
    }
}
