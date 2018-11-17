<?php

use Faker\Generator as Faker;

$factory->define(App\PriceList::class, function (Faker $faker) {

    $size = random_int(1, 10);
    $prices = [];
    for ($i = 0; $i < $size; $i++) {
        $prices[$faker->word] = $faker->numberBetween(0, 500);
    }

    return [
        'name' => $faker->word,
        'prices' => json_encode($prices)
    ];
});