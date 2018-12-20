<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'state' => 'blababla',
        'state_updated' => $faker->dateTime(),
        'random_id' => $faker->random_bytes(32),
        'payment_secret' => $faker->random_bytes(32),
        'vendor_id' => factory(App\User::class)->make()->id,
        'customer_id' => factory(App\User::class)->make()->id,
    ];
});