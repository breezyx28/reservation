<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
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

            DB::table('doctor')->insert([
                'fullName' => $faker->name,
                'gender' => $faker->randomElement(['ذكر', 'انثى']),
                'phone' => '09' . $faker->numberBetween(10000000, 99999999),
                'email' => $faker->freeEmail,
            ]);
        }
    }
}
