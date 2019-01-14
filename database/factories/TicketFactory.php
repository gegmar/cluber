<?php

use Faker\Generator as Faker;

$factory->define(App\Ticket::class, function (Faker $faker) {
    return [
        'random_id' => str_random(32),
        'seat_number' => random_int(0, 80), // Strongly advised to overwrite this value for automated tests
        'purchase_id' => factory(App\Purchase::class)->make()->id,
        'event_id' => factory(App\Event::class)->make()->id
    ];
});