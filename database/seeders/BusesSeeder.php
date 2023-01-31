<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class BusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i = 0; $i < 10; $i++) {
            DB::table('buses')->insert([
                'driver_name' => $faker->name,
                'driver_rating' => rand(1,5),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
