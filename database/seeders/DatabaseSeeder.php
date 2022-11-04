<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Airline;
use App\Models\City;
use App\Models\Flight;
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
        City::factory()->count(10)->create();
        Airline::factory()->count(10)->create()->each(function ($airline) {
            $airline->cities()->attach(City::all()->random(3));
        });
        for ($i=0; $i < 10; $i++) {
            Flight::factory()->count(10)->create([
                'airline_id' => Airline::all()->random()->id,
                'origin_id' => City::all()->random()->id,
                'destination_id' => City::all()->random()->id,
            ]);
        }

        // $flight->airline()->associate(Airline::all()->random());
        //     $flight->origin()->associate(City::all()->random());
        //     $flight->destination()->associate(City::all()->random());
        //     $flight->save();
    }
}
