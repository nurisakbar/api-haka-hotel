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
            ['name'=>'Air Conditioner','image'=>'ac.png'],
            ['name'=>'Free Wifi','image'=>'wifi.png'],
            ['name'=>'TV Satelite','image'=>'tv.png']
        ];

        Facility::insert($facilities);
    }
}
