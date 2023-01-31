<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $stations = [
        'Alexandria',
        'Cairo',
        'El-Giza',
        'Damietta',
        'Damanhor',
        'El-Mansoura',
        'Al-Fayoum',
        'Menya',
        'Sohaj',
        'Qena',
        'Port-Said',
        'Asyut',
        'Luxor',
        'Aswan',
    ];

    public function run()
    {
        for($i = 0; $i < count($this->stations); $i++) {
            DB::table('stations')->insert([
                'station_name' => $this->stations[$i],
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
