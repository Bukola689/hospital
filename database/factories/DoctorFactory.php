<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $phone = $this->faker->numberBetween($min = 100000000, $max=999999999);
        $room_no = $this->faker->numberBetween($min = 1, $max=100);

        return [
            'user_id' => User::all()->random()->id,
            'first_name' => $this->faker->name,
            'last_name' => $this->faker->name, 
            'd_o_b' => '2000-12-17',
            'phone' => $phone,
            'image' => $this->faker->imageUrl($width = 140, $height=300),
            'room_id' => Room::all()->random()->id,
             'service_id' => Service::all()->random()->id,
             'address' => $this->faker->sentence(),
        ];
    }
}
