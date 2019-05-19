<?php

use Faker\Generator as Faker;

$factory->define(App\PriceList::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->afterCreating(App\PriceList::class, function ($priceList, $faker) {
    $priceCategories = factory(App\PriceCategory::class, random_int(1, 5))->create();
    $priceList->categories()->saveMany($priceCategories);
});
