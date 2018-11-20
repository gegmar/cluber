<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    $dateTime = new DateTime();
    $startDate = clone $dateTime->add(new DateInterval('PT' . random_int(0, 525600) . 'M')); // 525600 = Sum of minutes of a year
    $endDate = $dateTime->add(new DateInterval('PT' . random_int(0, 525601) . 'M'));
    return [
        'start_date' => $startDate,
        'end_date' => $endDate,
        'second_name' => $faker->word,
        'project_id' => factory(App\Project::class)->make()->id,
        'location_id' => factory(App\Location::class)->make()->id,
        'seat_map_id' => factory(App\SeatMap::class)->make()->id,
        'price_list_id' => factory(App\PriceList::class)->make()->id
    ];
});