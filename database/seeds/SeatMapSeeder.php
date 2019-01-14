<?php

use Illuminate\Database\Seeder;

class SeatMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\SeatMap::create([
            'seats' => 300,
            'name' => 'Tribüne NPZ für frei.wild 2019',
            'description' => 'Drei Blocks zu je 100 PAX',
            'layout' => null
        ]);

        App\SeatMap::create([
            'seats' => 80,
            'name' => 'Theater in der Werkstatt (Standard - ohne Sitzplätze)',
            'description' => 'Standardmäßig werden im Theater Kirchdorf keine Sitzplatzkarten verkauft.',
            'layout' => null
        ]);

        App\SeatMap::create([
            'seats' => 80,
            'name' => 'Theater in der Werkstatt (mit Sitzplätzen)',
            'description' => '8 Reihen zu je 2 Bänken mit jeweils 5 PAX',
            'layout' => null
        ]);
    }
}