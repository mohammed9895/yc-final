<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 300; $i++) {
            DB::table('events')->insert([
                'title' => $faker->sentence(3),
                'user_id' => $faker->randomElement(DB::table('users')->pluck('id')->toArray()),
                'hall_id' => $faker->randomElement(DB::table('halls')->pluck('id')->toArray()),
                'reasone' => $faker->sentence(10),
                'start' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d H:i:s'),
                'end' => $faker->dateTimeBetween('+1 month', '+2 months')->format('Y-m-d H:i:s'),
                'status' => $faker->numberBetween(0, 2),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
