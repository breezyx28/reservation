<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HospitalInfoSeeder extends Seeder
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

            DB::table('hospital_info')->insert([
                'docID' => $faker->numberBetween(1, 6),
                'docInfoID' => $faker->numberBetween(1, 6),
                'docSchedulelID' => $faker->numberBetween(1, 6),
                'hospitalID' => $faker->numberBetween(1, 6),
            ]);
        }
    }
}
