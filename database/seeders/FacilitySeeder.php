<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facilities = [
            ['name'=>'Air Conditioner'],
            ['name'=>'Free Wifi'],
            ['name'=>'TV Satelite']
        ];
    }
}
