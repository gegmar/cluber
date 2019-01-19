<?php

use Faker\Generator as Faker;

$factory->define(App\PriceList::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});