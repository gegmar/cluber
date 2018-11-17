<?php

use Faker\Generator as Faker;
use App\SeatMap;

/**
 * Use with caution --> Some tests will fail that also require a correct view
 */
$factory->define(SeatMap::class, function (Faker $faker) {
    return [
        'seats' => $faker->numberBetween(20, 5000),
        'name' => $faker->word,
        'description' => $faker->sentence()
    ];
});