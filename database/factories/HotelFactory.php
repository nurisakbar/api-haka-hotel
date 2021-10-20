<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;
use DB;

class HotelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hotel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $district   = DB::table('districts')->inRandomOrder()->first();
        $photos     = ['image1.jpg','images2.jpg','image4.jpg'];
        
        return [
            'name'          =>  'Hotel '.$this->faker->sentence($nbWords = 4, $variableNbWords = true),
            'address'       =>  $this->faker->address(),
            'address_tag'   =>  implode(',', $this->faker->words($nb = 3, $asText = false)),
            'district_id'   =>  $district->id,
            'photos'        =>  serialize($photos)
        ];
    }
}
