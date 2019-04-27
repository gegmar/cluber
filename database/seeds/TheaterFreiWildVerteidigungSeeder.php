<?php

use Illuminate\Database\Seeder;

class TheaterFreiWildVerteidigungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UserSeeder::class);

        // Creating the 2 seat maps: 1 for regular theatre and 1 for the additional jam session
        $seatMap = App\SeatMap::create([
            'seats' => 126,
            'name' => 'Atrium, NPZ (Verteidigung von Molln)',
            'description' => 'Standard-Tribüne mit 7 Reihen zu je 18 Sitzplätzen',
            'layout' => "'aaaaaaaaaaaaaaaaaa',
            'aaaaaaaaaaaaaaaaaa',
            'aaaaaaaaaaaaaaaaaa',
            'aaaaaaaaaaaaaaaaaa',
            'aaaaaaaaaaaaaaaaaa',
            'aaaaaaaaaaaaaaaaaa',
            'aaaaaaaaaaaaaaaaaa',"
        ]);

        $seatMapPreEventOnly = App\SeatMap::create([
            'seats' => 200,
            'name' => 'Atrium, NPZ (PreEvent zu Verteidigung von Molln)',
            'description' => 'Ungeordnete 200 Plätze',
            'layout' => null
        ]);

        // Create the location for all events
        $location = App\Location::create([
            'name' => 'Nationalparkzentrum Molln',
            'address' => 'Nationalparkallee 1, 4591 Molln'
        ]);

        // Create different priceLists for ...
        // 1. the regular theatre events,
        // 2. for the joint-event with jam-session and
        // 3. theatre and for only the jam session
        $defaultPriceList = App\PriceList::create([
            'name' => 'Standardpreise'
        ]);

        $theaterWithPreEventPriceList = App\PriceList::create([
            'name' => 'Standardpreise mit PreEvent'
        ]);

        $preEventOnlyPriceList = App\PriceList::create([
            'name' => 'Preise für PreEvent'
        ]);

        // Create according to the pricelists its categories
        $standardPrice = App\PriceCategory::create([
            'name' => 'Standard',
            'price' => 16
        ]);

        $standardPriceWithPreEvent = App\PriceCategory::create([
            'name' => 'Standard + Eintritt Jam-Session',
            'price' => 29
        ]);

        $preEventOnlyPrice = App\PriceCategory::create([
            'name' => 'Eintritt zur Jam-Session',
            'price' => 16
        ]);

        // Link pricelists and categories together
        $defaultPriceList->categories()->attach([$standardPrice->id]);
        $theaterWithPreEventPriceList->categories()->attach([$standardPrice->id, $standardPriceWithPreEvent->id]);
        $preEventOnlyPriceList->categories()->attach([$preEventOnlyPrice->id]);

        // Create both projects
        $project = App\Project::create([
            'name' => 'Die Verteidigung von Molln',
            'description' => 'Volksstück mit Musik von Thomas Arzt | Musik: Manfred Rußmann | Regie: Franz Strasser'
        ]);

        $preEvent = App\Project::create([
            'name' => 'Maultrommel-Jam-Session',
            'description' => 'Veranstaltung des österreichischen Maultrommelvereins'
        ]);

        // Create a single event for the jam-session project
        App\Event::create([
            'start_date' => '2019-06-21 15:00:00',
            'end_date' => '2019-06-21 18:00:00',
            'second_name' => 'Jam-Session',
            'project_id' => $preEvent->id,
            'location_id' => $location->id,
            'seat_map_id' => $seatMapPreEventOnly->id,
            'price_list_id' => $preEventOnlyPriceList->id
        ]);

        // List all normal dates of the theatre events (2. - 8. event)
        $dates = [
            '2019-06-07 20:00:00',
            '2019-06-08 20:00:00',
            '2019-06-09 20:00:00',
            '2019-06-10 20:00:00',
            '2019-06-14 20:00:00',
            '2019-06-15 20:00:00',
            '2019-06-20 20:00:00',
        ];
        $count = 2;

        // Create the very first event (special name)
        App\Event::create([
            'start_date' => '2019-06-01 20:00:00',
            'end_date' => '2019-06-01 22:30:00',
            'second_name' => 'Uraufführung',
            'project_id' => $project->id,
            'location_id' => $location->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $defaultPriceList->id
        ]);

        // Iterate over the list of all "normal" events 
        foreach ($dates as $date) {
            $endDate = new \DateTime($date);
            $endDate->add(new \DateInterval('PT150M'));
            App\Event::create([
                'start_date' => new \DateTime($date),
                'end_date' => $endDate,
                'second_name' => $count . '. Aufführung',
                'project_id' => $project->id,
                'location_id' => $location->id,
                'seat_map_id' => $seatMap->id,
                'price_list_id' => $defaultPriceList->id
            ]);
            $count++;
        }

        // Create the theatre event with the special prices because of the optional jam session
        App\Event::create([
            'start_date' => '2019-06-21 20:00:00',
            'end_date' => '2019-06-21 22:30:00',
            'second_name' => '9. Aufführung (mit Jam-Session)',
            'project_id' => $project->id,
            'location_id' => $location->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $theaterWithPreEventPriceList->id
        ]);

        // Create the last theatre event (special name)
        App\Event::create([
            'start_date' => '2019-06-22 20:00:00',
            'end_date' => '2019-06-22 22:30:00',
            'second_name' => 'Dernière',
            'project_id' => $project->id,
            'location_id' => $location->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $defaultPriceList->id
        ]);

        // Special requirement: We have to block some seats for technical equipment in the backrows
        // Add a dummy vendor to reference the blocked tickets
        $equipmentVendor = App\User::create([
            'name' => 'Technik',
            'email' => 'Technik@system.local',
            'email_verified_at' => null,
            'password' => '',
        ]);
        // Get all events with this seatmap
        $seatMap->events->each(function ($event) use ($standardPrice, $equipmentVendor) {
            $purchase = App\Purchase::create([
                'state' => 'free',
                'state_updated' => new \DateTime(),
                'random_id' => str_random(32),
                'payment_secret' => str_random(32),
                'vendor_id' => $equipmentVendor->id,
            ]);
            $techSeats = [98, 99, 100, 116, 117, 118];
            foreach ($techSeats as $seat) {
                App\Ticket::create([
                    'random_id' => str_random(32),
                    'seat_number' => $seat, // Strongly advised to overwrite this value for automated tests
                    'purchase_id' => $purchase->id,
                    'event_id' => $event->id,
                    'price_category_id' => $standardPrice->id
                ]);
            }
        });
    }
}
