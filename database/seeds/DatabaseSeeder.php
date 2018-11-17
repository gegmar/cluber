<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Load all existing seatmaps into database
        $this->call(SeatMapSeeder::class);
    }
}