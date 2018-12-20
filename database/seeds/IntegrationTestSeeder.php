<?php

use Illuminate\Database\Seeder;

class IntegrationTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRole = App\Role::create(['name' => 'vendor']);
        $adminRole = App\Role::create(['name' => 'admin']);

        $location = factory(App\Location::class)->create();
        $priceList = factory(App\PriceList::class)->create();
        // SeatMap with a fixed chart
        $kdfSeatMap = App\SeatMap::create([
            'seats' => 70,
            'name' => 'theater_in_der_werkstatt_kdf',
            'description' => 'Standardtribüne im Theater in der Werkstatt (Kirchdorf)'
        ]);
        // SeatMap without a chart -> sells amounts of tickets instead of fixed seats
        $pseudoSeatMap = factory(App\SeatMap::class)->create();

        // Generate two projects with a different event count
        factory(App\Project::class)->create()->each(function ($project) use ($location, $priceList, $kdfSeatMap) {
            $project->events()->saveMany(factory(App\Event::class, 6)->create([
                'project_id' => $project->id,
                'location_id' => $location->id,
                'price_list_id' => $priceList->id,
                'seat_map_id' => $kdfSeatMap->id
            ]));
        });

        factory(App\Project::class)->create()->each(function ($project) use ($location, $priceList, $pseudoSeatMap) {
            $project->events()->saveMany(factory(App\Event::class, 5)->create([
                'project_id' => $project->id,
                'location_id' => $location->id,
                'price_list_id' => $priceList->id,
                'seat_map_id' => $pseudoSeatMap->id
            ]));
        });

        $allEvents = App\Event::all();

        // NEXT
    }
}