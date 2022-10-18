<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(5)->create();

        User::factory()->count(1)->create()->each(
            function($user) {
                $user->assignRole('doctor');
            }
        );

        User::factory()->count(2)->create()->each(
            function($user) {
                $user->assignRole('nurse');
            }
        );

        User::factory()->count(4)->create()->each(
            function($user) {
                $user->assignRole('patient');
            }
        );

        User::factory()->count(1)->create()->each(
            function($user) {
                $user->hasAnyPermission('doctor');
            }
        );

        User::factory()->count(2)->create()->each(
            function($user) {
                $user->hasAnyPermission('nurse');
            }
        );

        User::factory()->count(4)->create()->each(
            function($user) {
                $user->hasAnyPermission('patient');
            }
        );
    }
}
