<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocInfoController extends Seeder
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

            DB::table('doctor_info')->insert([
                'specialization' => $faker->jobTitle,
                'interviewPrice' => $faker->numberBetween(100, 9999),
                'docID' => $faker->unique()->numberBetween(1, 6),
            ]);
        }
    }
}
