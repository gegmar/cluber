<?php

use Faker\Generator as Faker;

$factory->define(App\Setting::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'lang' => $faker->languageCode,
        'value' => $faker->sentences(),
    ];
});