<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Ticket::class, function (Faker $faker) {
    return [
        'random_id' => Str::random(32),
        'purchase_id' => function () {
            return factory(App\Purchase::class)->create()->id;
        },
        'event_id' => function () {
            return factory(App\Event::class)->create()->id;
        },
        'price_category_id' => function (array $ticket) {
            $event = App\Event::find($ticket['event_id']);
            $priceCategories = $event->priceList->categories;
            return $priceCategories[random_int(0, $priceCategories->count() - 1)];
        },
        'seat_number' => function (array $ticket) {
            $event = App\Event::find($ticket['event_id']);
            $seatMap = $event->seatMap;
            return random_int(1, $seatMap->seats);
        },
    ];
});
