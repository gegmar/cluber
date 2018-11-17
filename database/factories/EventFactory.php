<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    $dateTime = new DateTime();
    return [
        'start_date' => $dateTime->add(new DateInterval('PT' . random_int(0, 525600) . 'M')), // 525600 = Sum of minutes of a year
        'end_date' => $dateTime->add(new DateInterval('PT' . random_int(0, 525600) . 'M')),
        'second_name' => $faker->sentence,
        'project_id' => factory(App\Project::class)->make()->id,
        'location_id' => factory(App\Location::class)->make()->id,
        'seat_map_id' => factory(App\SeatMap::class)->make()->id,
        'price_list_id' => factory(App\PriceList::class)->make()->id
    ];
});