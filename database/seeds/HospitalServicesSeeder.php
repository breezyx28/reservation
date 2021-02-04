<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HospitalServicesSeeder extends Seeder
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

            DB::table('hospital_services')->insert([
                'servicesID' => $faker->randomElement(\App\Services::all()->pluck('id')->toArray()),
                'hospitalID' => $faker->randomElement(\App\hospital::all()->pluck('id')->toArray()),
            ]);
        }
    }
}
