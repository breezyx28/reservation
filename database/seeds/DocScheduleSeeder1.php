<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocScheduleController extends Seeder
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
                'docID' => $faker->numberBetween(1, 6),
                'saturday' => $faker->randomElement(['0', '1']),
                'sunday' => $faker->randomElement(['0', '1']),
                'monday' => $faker->randomElement(['0', '1']),
                'tuesday' => $faker->randomElement(['0', '1']),
                'wednesday' => $faker->randomElement(['0', '1']),
                'thursday' => $faker->randomElement(['0', '1']),
                'friday' => $faker->randomElement(['0', '1']),
                'off' => '1',
            ]);
        }
    }
}
