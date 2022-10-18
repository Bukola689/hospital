<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $phone = $this->faker->numberBetween($min = 100000000, $max=999999999);

        return [
            'user_id' => User::all()->random()->id,
            'first_name' => $this->faker->name,
            'last_name' => $this->faker->name,  
            'd_o_b' => '2000-12-17',
            'phone' => $phone,
            'image' => $this->faker->imageUrl($width = 140, $height=300),
            'address' => $this->faker->sentence(),
        ];
    }
}
