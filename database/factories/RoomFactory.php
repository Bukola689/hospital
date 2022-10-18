<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $room_no = $this->faker->numberBetween($min = 1, $max=20);

        return [
            'room_no' => $room_no
        ];
    }
}
