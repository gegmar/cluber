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

        factory(App\Project::class, 3)->create()->each(function ($project) use ($location, $priceList) {
            $project->events()->saveMany(factory(App\Event::class, 6)->create([
                'project_id' => $project->id,
                'location_id' => $location->id,
                'price_list_id' => $priceList->id,
                'seat_map_id' => null
            ]));
        });
    }
}