<?php

use Faker\Generator as Faker;

$factory->define(App\PriceCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'price' => $faker->numberBetween(1, 1000),
    ];
});
