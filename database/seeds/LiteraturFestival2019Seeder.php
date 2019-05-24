<?php

use Illuminate\Database\Seeder;

class LiteraturFestival2019Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add default roles, permissions and users
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UserSeeder::class);

        // Project OÖ Literaturfestival
        $project = App\Project::create([
            'name' => '4553 - OÖ Literaturfestival',
            'description' => '4. Literaturfestival der Literarischen Nahversorger'
        ]);

        // Prices for full day tickets
        $festivalPass = App\PriceCategory::create([
            'name' => 'FESTIVALPASS 29.8. - 1.9.',
            'price' => 80,
            'description' => 'Eintritt für alle Veranstaltungen'
        ]);

        $day1Pass = App\PriceCategory::create([
            'name' => 'TAGESPASS 30.8.',
            'price' => 45,
            'description' => 'Eintritt für alle Veranstaltungen am 30.8.'
        ]);

        $day2Pass = App\PriceCategory::create([
            'name' => 'TAGESPASS 31.8.',
            'price' => 55,
            'description' => 'Eintritt für alle Veranstaltungen am 31.8.'
        ]);

        $passList = App\PriceList::create([
            'name' => 'Tages- und Festivalpässe'
        ]);
        $passList->categories()->attach([
            $festivalPass->id,
            $day1Pass->id,
            $day2Pass->id
        ]);

        // PriceCategories and lists with different values
        $price30 = App\PriceCategory::create([
            'name' => 'Eintrittspreis',
            'price' => 30
        ]);
        $priceList30 = App\PriceList::create(['name' => '30€-Einzel']);
        $priceList30->categories()->attach($price30->id);

        $price15 = App\PriceCategory::create([
            'name' => 'Eintrittspreis',
            'price' => 15
        ]);
        $priceList15 = App\PriceList::create(['name' => '15€-Einzel']);
        $priceList15->categories()->attach($price15->id);

        $price10 = App\PriceCategory::create([
            'name' => 'Eintrittspreis',
            'price' => 10
        ]);
        $priceList10 = App\PriceList::create(['name' => '10€-Einzel']);
        $priceList10->categories()->attach($price10->id);

        $price5 = App\PriceCategory::create([
            'name' => 'Eintrittspreis',
            'price' => 5
        ]);
        $priceList5 = App\PriceList::create(['name' => '5€-Einzel']);
        $priceList5->categories()->attach($price5->id);


        // Add a dummy seatmap until final review of board
        $seatMap = App\SeatMap::create([
            'seats' => 100,
            'name' => 'Dummy-SeatMap',
            'description' => 'SeatMap für Demo-Zwecke',
            'layout' => null
        ]);

        // Event locations
        $festivalBueroForVS = App\Location::create([
            'name' => 'Volksschule / Treffpunkt: Festivalbüro',
            'address' => 'Klosterstraße 1, 4553 Schlierbach'
        ]);

        $festivalBuero = App\Location::create([
            'name' => 'Treffpunkt: Festivalbüro',
            'address' => 'Klosterstraße 1, 4553 Schlierbach'
        ]);

        $spesSeminarraum = App\Location::create([
            'name' => 'SPES Seminarraum',
            'address' => 'Panoramaweg 1, 4553 Schlierbach'
        ]);

        $spesMeditationsraum = App\Location::create([
            'name' => 'SPES Meditationsraum',
            'address' => 'Panoramaweg 1, 4553 Schlierbach'
        ]);

        $spesDunkelgenussraum = App\Location::create([
            'name' => 'SPES Dunkelgenussraum',
            'address' => 'Panoramaweg 1, 4553 Schlierbach'
        ]);

        $theaterSaal = App\Location::create([
            'name' => 'Theatersaal Schlierbach',
            'address' => 'Klosterstraße 4, 4553 Schlierbach'
        ]);

        $galerie = App\Location::create([
            'name' => 'Margret-Bilger-Galerie',
            'address' => '4553 Schlierbach'
        ]);

        $panoramaCafe = App\Location::create([
            'name' => 'Panorama Café - Stift Schlierbach',
            'address' => 'Klosterstraße 1, 4553 Schlierbach'
        ]);

        $bernardiSaal = App\Location::create([
            'name' => 'Bernardi Saal',
            'address' => 'Klosterstraße 1, 4553 Schlierbach'
        ]);

        $bibliothek = App\Location::create([
            'name' => 'Bibliothek',
            'address' => 'Klosterstraße 1, 4553 Schlierbach'
        ]);

        $waldschenkeZeisl = App\Location::create([
            'name' => 'Waldschenke Zeisl',
            'address' => 'Am Weinberg 12, 4553 Schlierbach'
        ]);

        // EventPasses
        App\Event::create([
            'start_date' => '2019-08-29 00:00:00',
            'end_date' => '2019-09-01 23:59:00',
            'second_name' => 'Festival- und Tagespässe',
            'project_id' => $project->id,
            'location_id' => $festivalBuero->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $passList->id
        ]);

        // Events 29.8.
        App\Event::create([
            'start_date' => '2019-08-29 10:00:00',
            'end_date' => '2019-08-29 13:00:00',
            'second_name' => 'Schreibwerkstatt mit Tex Rubinowitz',
            'project_id' => $project->id,
            'location_id' => $festivalBuero->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList30->id
        ]);

        App\Event::create([
            'start_date' => '2019-08-29 10:00:00',
            'end_date' => '2019-08-29 13:00:00',
            'second_name' => 'KINDER, KINDER Magdalena Brandstötter',
            'project_id' => $project->id,
            'location_id' => $spesSeminarraum->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList5->id
        ]);

        App\Event::create([
            'start_date' => '2019-08-29 20:00:00',
            'end_date' => '2019-08-29 23:00:00',
            'second_name' => 'LESUNG Ilija Trojanow',
            'project_id' => $project->id,
            'location_id' => $theaterSaal->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList15->id
        ]);

        // Events 30.8.
        App\Event::create([
            'start_date' => '2019-08-30 10:00:00',
            'end_date' => '2019-08-30 13:00:00',
            'second_name' => 'KINDER, KINDER Thomas Mauz',
            'project_id' => $project->id,
            'location_id' => $festivalBueroForVS->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList5->id
        ]);

        App\Event::create([
            'start_date' => '2019-08-30 10:00:00',
            'end_date' => '2019-08-30 13:00:00',
            'second_name' => 'BUCHPRÄSENTATION + GESPRÄCH Daniela Strigl',
            'project_id' => $project->id,
            'location_id' => $galerie->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList10->id
        ]);

        App\Event::create([
            'start_date' => '2019-08-30 14:00:00',
            'end_date' => '2019-08-30 17:00:00',
            'second_name' => 'LESUNG + MUSIK Barbara Zeman',
            'project_id' => $project->id,
            'location_id' => $panoramaCafe->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList10->id
        ]);

        App\Event::create([
            'start_date' => '2019-08-30 16:00:00',
            'end_date' => '2019-08-30 19:00:00',
            'second_name' => 'LESUNG Judith W. Taschler',
            'project_id' => $project->id,
            'location_id' => $theaterSaal->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList10->id
        ]);

        App\Event::create([
            'start_date' => '2019-08-30 18:00:00',
            'end_date' => '2019-08-30 21:00:00',
            'second_name' => 'LESUNG + GESPRÄCH Olga Flor',
            'project_id' => $project->id,
            'location_id' => $bernardiSaal->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList10->id
        ]);

        App\Event::create([
            'start_date' => '2019-08-30 20:00:00',
            'end_date' => '2019-08-30 23:00:00',
            'second_name' => 'LESUNG Vea Kaiser',
            'project_id' => $project->id,
            'location_id' => $theaterSaal->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList15->id
        ]);

        // Events 31.8.
        App\Event::create([
            'start_date' => '2019-08-31 10:00:00',
            'end_date' => '2019-08-31 13:00:00',
            'second_name' => 'KINDER, KINDER Uly Paya',
            'project_id' => $project->id,
            'location_id' => $spesMeditationsraum->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList5->id
        ]);

        App\Event::create([
            'start_date' => '2019-08-31 10:00:00',
            'end_date' => '2019-08-31 13:00:00',
            'second_name' => 'LESUNG + GESPRÄCH Hans Eichhorn',
            'project_id' => $project->id,
            'location_id' => $galerie->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList10->id
        ]);

        App\Event::create([
            'start_date' => '2019-08-31 14:00:00',
            'end_date' => '2019-08-31 17:00:00',
            'second_name' => 'THEATER Puppentheater Guglhupf (ab 16 Jahre)',
            'project_id' => $project->id,
            'location_id' => $theaterSaal->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList10->id
        ]);

        App\Event::create([
            'start_date' => '2019-08-31 16:00:00',
            'end_date' => '2019-08-31 19:00:00',
            'second_name' => 'LESUNG Thomas Sautner',
            'project_id' => $project->id,
            'location_id' => $bernardiSaal->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList10->id
        ]);

        App\Event::create([
            'start_date' => '2019-08-31 18:00:00',
            'end_date' => '2019-08-31 21:00:00',
            'second_name' => 'LESUNG Philipp Weiss',
            'project_id' => $project->id,
            'location_id' => $bibliothek->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList10->id
        ]);

        App\Event::create([
            'start_date' => '2019-08-31 20:00:00',
            'end_date' => '2019-08-31 23:00:00',
            'second_name' => 'LESUNG Wladimir Kaminer',
            'project_id' => $project->id,
            'location_id' => $bernardiSaal->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList15->id
        ]);

        App\Event::create([
            'start_date' => '2019-08-31 22:00:00',
            'end_date' => '2019-08-31 23:55:00',
            'second_name' => 'KONZERT Felix Kramer + Band',
            'project_id' => $project->id,
            'location_id' => $theaterSaal->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList10->id
        ]);

        // Events 1.9.
        App\Event::create([
            'start_date' => '2019-09-01 10:00:00',
            'end_date' => '2019-09-01 13:00:00',
            'second_name' => 'KINDER, KINDER Märchen m. Rosa Teutsch',
            'project_id' => $project->id,
            'location_id' => $festivalBueroForVS->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList5->id
        ]);

        App\Event::create([
            'start_date' => '2019-09-01 12:00:00',
            'end_date' => '2019-09-01 15:00:00',
            'second_name' => 'LITERATUR & MUSIK E. Einzinger + D. Strigl',
            'project_id' => $project->id,
            'location_id' => $waldschenkeZeisl->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList10->id
        ]);

        App\Event::create([
            'start_date' => '2019-09-01 15:00:00',
            'end_date' => '2019-09-01 18:00:00',
            'second_name' => 'LESUNG IM DUNKELN Eva Felbauer',
            'project_id' => $project->id,
            'location_id' => $spesDunkelgenussraum->id,
            'seat_map_id' => $seatMap->id,
            'price_list_id' => $priceList15->id
        ]);
    }
}
