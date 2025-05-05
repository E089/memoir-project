<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            DB::table('users')->insert([
                'username' => $faker->unique()->userName,
                'email' => $faker->unique()->safeEmail, // <- Add this line
                'password' => bcrypt('password123'),
            ]);
        }
    }
}
