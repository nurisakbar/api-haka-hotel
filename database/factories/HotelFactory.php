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
        $regency   = DB::table('regencies')->inRandomOrder()->first();
        $photos     = ['image1.jpg','images2.jpg','image4.jpg'];

        return [
            'name'          =>  'Hotel '.$this->faker->sentence($nbWords = 4, $variableNbWords = true),
            'address'       =>  $this->faker->address(),
            'address_tag'   =>  implode(',', $this->faker->words($nb = 3, $asText = false)),
            'regency_id'    =>  $regency->id,
            'photos'        =>  serialize($photos)
        ];
    }
}
