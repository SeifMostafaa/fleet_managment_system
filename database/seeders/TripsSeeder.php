<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TripsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

     // array of trips, each trip defined by an array of stations (station id)
    private $stations_btn_start_end_station = [
        [
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10
        ],
        [
            2,4,6,8,10,12
        ],
        [
            1,3,5,7,9,11,13
        ],
        [
            2,3,4,5,6,7,8,9,10,11,12,13
        ],
        [
            1,3,4,5,6
        ],
        [
            1,13
        ]
    ];


    public function run()
    {
        $this->fill_trip_table();
        $this->fill_crossover_table();
    }

    // using stations_btn_start_end_station create function to fill crossover table
    public function fill_crossover_table()
    {
        $available_seets = 0;
        for($i = 0; $i < count($this->stations_btn_start_end_station); $i++) {
            for($j = 0; $j < count($this->stations_btn_start_end_station[$i])-1; $j++) {
                if($i == 1) {
                    $available_seets = 12;
                }
                    DB::table('cross_over_stations')->insert([
                        'trip_id' => $i+1,
                        'start_station_id' => $this->stations_btn_start_end_station[$i][$j],
                        'end_station_id' => $this->stations_btn_start_end_station[$i][$j+1],
                        'station_order' => $j+1,
                        'available_seats' => $available_seets,
                        'created_at' => date('Y-m-d H:i:s'),
                        ]);
                }
            }
        }

    public function fill_trip_table(){
        for($i = 0; $i < count($this->stations_btn_start_end_station); $i++) {
            DB::table('trips')->insert([
                'start_station_id' => $this->stations_btn_start_end_station[$i][0],
                'end_station_id' => $this->stations_btn_start_end_station[$i][count($this->stations_btn_start_end_station[$i])-1],
                'bus_id' => rand(1,10),
                'trip_date' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                ]);
        }
    }

}
