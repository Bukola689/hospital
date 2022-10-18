<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $ward = $this->faker->numberBetween($min = 1, $max=20);

        return [
            'ward_no' => $ward
        ];
    }
}
