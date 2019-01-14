<?php

use Faker\Generator as Faker;

$factory->define(App\Purchase::class, function (Faker $faker) {
    return [
        'state' => 'blababla',
        'state_updated' => $faker->dateTime(),
        'random_id' => str_random(32),
        'payment_secret' => str_random(32),
        'vendor_id' => factory(App\User::class)->make()->id,
        'customer_id' => factory(App\User::class)->make()->id,
    ];
});