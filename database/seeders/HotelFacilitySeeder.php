<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\Facility;
use App\Models\HotelFacility;

class HotelFacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Hotel::all() as $hotel) {
            $facilities = Facility::get();
            foreach ($facilities as $facility) {
                HotelFacility::create(['hotel_id'=>$hotel->id,'facility_id'=>$facility->id]);
            }
        }
    }
}
