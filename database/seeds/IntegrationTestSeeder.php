<?php

use Illuminate\Database\Seeder;
use phpseclib\Crypt\Random;

class IntegrationTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberOfCategories = random_int(2, 6);
        $location = factory(App\Location::class)->create();
        $priceList = factory(App\PriceList::class)->create();
        $categories = factory(App\PriceCategory::class, $numberOfCategories)->create();
        $priceList->categories()->attach($categories);
        // SeatMap without a chart
        $kdfSeatMap = App\SeatMap::create([
            'seats' => 70,
            'name' => 'Theater in der Werkstatt (Standard)',
            'description' => 'Standardtribüne im Theater in der Werkstatt (Kirchdorf)',
            'layout' => null
        ]);

        $randomSeatMap = factory(App\SeatMap::class)->create([
            'seats' => 4000
        ]);

        // Generate two projects with a different event count and different seatmaps
        $project1 = factory(App\Project::class)->create();
        $project1->events()->saveMany(factory(App\Event::class, 6)->create([
            'project_id' => $project1->id,
            'location_id' => $location->id,
            'price_list_id' => $priceList->id,
            'seat_map_id' => $kdfSeatMap->id
        ]));

        $project2 = factory(App\Project::class)->create();
        $project2->events()->saveMany(factory(App\Event::class, 5)->create([
            'project_id' => $project2->id,
            'location_id' => $location->id,
            'price_list_id' => $priceList->id,
            'seat_map_id' => $randomSeatMap->id
        ]));

        // Fill the events with a few tickets/purchases
        $allEvents = App\Event::all();
        $states = [
            'paid',
            'in_payment',
        ];
        $vendors = factory(App\User::class, 3)->create();

        foreach ($allEvents as $event) {
            factory(App\Purchase::class, random_int(1, 10))->create([
                'state' => $states[random_int(0, 1)],
                'vendor_id' => $vendors[random_int(0, 2)]->id,
                'customer_id' => factory(App\User::class)->create()->id,
            ])->each(function ($purchase) use ($event, $numberOfCategories, $categories) {
                factory(App\Ticket::class, random_int(1, 8))->create([
                    'purchase_id' => $purchase->id,
                    'event_id' => $event->id,
                    'price_category_id' => $categories[random_int(0, $numberOfCategories - 1)]->id,
                ]);
            });
        }

        // fill first event to check if sold-out-feature works
        $lastEvent = App\Event::first();
        $fillingPurchase = factory(App\Purchase::class)->create([
            'state' => 'paid',
            'vendor_id' => $vendors[0]->id,
            'customer_id' => factory(App\User::class)->create()->id,
        ]);

        $lastEvent->tickets()->saveMany(factory(App\Ticket::class, $lastEvent->freeTickets())->create([
            'purchase_id' => $fillingPurchase->id,
            'event_id' => $lastEvent->id,
            'price_category_id' => $categories[random_int(0, $numberOfCategories - 1)]->id,
        ]));
    }
}