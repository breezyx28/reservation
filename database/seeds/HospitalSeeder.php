<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i <= 5; $i++) {

            DB::table('hospital')->insert([
                'name' => $faker->company,
                'phone' => '09' . $faker->numberBetween(10000000, 99999999),
                'passowrd' => Hash::make('0000'),
                'state' => $faker->state,
                'city' => $faker->city,
                'address' => $faker->address,
                'email' => $faker->freeEmail,
                'lat' => $faker->latitude,
                'lng' => $faker->longitude,
            ]);
        }
    }
}
