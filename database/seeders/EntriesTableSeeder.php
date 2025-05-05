<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EntriesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $userIds = DB::table('users')->pluck('id')->toArray();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        foreach (range(1, 50) as $i) {
            DB::table('entries')->insert([
                'user_id' => $faker->randomElement($userIds),
                'category_id' => $faker->optional()->randomElement($categoryIds),
                'title' => $faker->sentence,
                'body' => $faker->paragraphs(3, true),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
