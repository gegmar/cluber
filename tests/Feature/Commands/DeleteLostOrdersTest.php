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
        $purchase16min = factory(Purchase::class)->create([
            'state' => 'in_payment',
            'state_updated' => $date1->sub(new \DateInterval('PT16M'))
        ]); 

        // Edge-Case#2: 10min old --> should stay
        $date2 = new \DateTime();
        $purchase10min = factory(Purchase::class)->create([
            'state' => 'in_payment',
            'state_updated' => $date2->sub(new \DateInterval('PT10M'))
        ]);

        // Very old purchase --> to be deleted
        $date3 = new \DateTime();
        $purchase1000min = factory(Purchase::class)->create([
            'state' => 'in_payment',
            'state_updated' => $date3->sub(new \DateInterval('PT1000M'))
        ]);

        // Very new purchase --> should stay
        $date4 = new \DateTime();
        $purchase1min = factory(Purchase::class)->create([
            'state' => 'in_payment',
            'state_updated' => $date4->sub(new \DateInterval('PT1M'))
        ]);

        $this->artisan('app:deleteLostOrders')->assertExitCode(0);

        // Check if the command deleted the overdue purchases and kept the new purchases
        $purchase1min->refresh();
        $this->assertEquals('in_payment', $purchase1min->state);

        $purchase10min->refresh();
        $this->assertEquals('in_payment', $purchase10min->state);

        $purchase1000min->refresh();
        $this->assertEquals('deleted', $purchase1000min->state);

        $purchase16min->refresh();
        $this->assertEquals('deleted', $purchase16min->state);
    }
}
