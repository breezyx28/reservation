<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ServicesSeeder extends Seeder
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

            DB::table('services')->insert([
                'name' => $faker->name,
                'price' => $faker->numberBetween(10000, 9999),
                'note' => $faker->text,
                'activity' => 1,
            ]);
        }
    }
}
