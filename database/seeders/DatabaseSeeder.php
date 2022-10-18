<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();

        $this->call([ 
            RoleAndPermissionSeeder::class,
            UserSeeder::class,
            RoomSeeder::class,
            ServiceSeeder::class,
            DoctorSeeder::class,
            NurseSeeder::class,
            PatientSeeder::class,
            WardSeeder::class,
           
        ]);
    }
}
