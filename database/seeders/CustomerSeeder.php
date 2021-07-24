<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1,200) as $index) {
            DB::table('customers')->insert([
                'name' => $faker->name,
                'address' => $faker->address,
                'city' => $faker->city,
                'postal_code' => $faker->phoneNumber,
                'country' => $faker->country
            ]);
        }
        
    }
}
