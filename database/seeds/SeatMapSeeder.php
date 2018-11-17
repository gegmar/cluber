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
            'seats' => '300',
            'name' => '2019_jog',
            'description' => 'Tribüne NPZ für Jugend ohne Gott'
        ]);
    }
}