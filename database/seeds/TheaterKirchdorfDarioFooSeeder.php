<?php

use Illuminate\Database\Seeder;

class TheaterKirchdorfDarioFooSeeder extends Seeder
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

        $seatMap = App\SeatMap::create([
            'seats' => 68,
            'name' => 'Theater in der Werkstatt (Verzeihung, wer ist hier der Boss?)',
            'description' => 'Keine Sitzplatzkarten. Klavier blockiert erste Sitzreihe.',
            'layout' => null
        ]);

        $location = App\Location::create([
            'name' => 'Theater in der Werkstatt',
            'address' => 'Hauergasse 5, 4560 Kirchdorf an der Krems'
        ]);

        $priceList = App\PriceList::create([
            'name' => 'Standardpreise'
        ]);

        $standardPrice = App\PriceCategory::create([
            'name' => 'Standard',
            'price' => 14
        ]);

        $reducedPrice = App\PriceCategory::create([
            'name' => 'Ermäßigt',
            'price' => 8,
            'description' => 'Kinder, Lehrlinge und Studenten'
        ]);

        $priceList->categories()->attach([$standardPrice->id, $reducedPrice->id]);

        $project = App\Project::create([
            'name' => 'Verzeihung, wer ist hier der Boss?',
            'description' => 'Komödie von Dario Fo | Regie: Elisabeth Neubacher'
        ]);

        $dates = [
            '2019-04-27 20:00:00',
            '2019-04-30 20:00:00',
            '2019-05-01 18:00:00',
            '2019-05-16 20:00:00',
            '2019-05-17 20:00:00',
            '2019-05-18 20:00:00',
            '2019-05-23 20:00:00',
            '2019-05-24 20:00:00',
            '2019-05-25 20:00:00',
            '2019-05-30 18:00:00',
            '2019-05-31 20:00:00',
            '2019-06-01 20:00:00'
        ];
        $count = 2;

        App\Event::create([
            'start_date' => '2019-04-26 20:00:00',
            'end_date' => '2019-04-26 22:30:00',
            'second_name' => 'Premiere',
            'project_id' => $project->id,
            'location_id' => $location->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList->id
        ]);

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
                'price_list_id' => $priceList->id
            ]);
            $count++;
        }
    }
}
