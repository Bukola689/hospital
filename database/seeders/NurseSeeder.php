<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NurseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Nurse::factory(5)->create();
    }
}
