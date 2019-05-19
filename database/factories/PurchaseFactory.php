<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Purchase::class, function (Faker $faker) {
    return [
        'state' => 'blababla',
        'state_updated' => $faker->dateTime(),
        'random_id' => Str::random(32),
        'payment_secret' => Str::random(32),
        'vendor_id' => factory(App\User::class)->create()->id,
        'customer_id' => factory(App\User::class)->create()->id,
    ];
});
