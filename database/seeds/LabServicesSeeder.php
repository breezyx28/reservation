<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Lab;

class LabServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $lab = new Lab();
        $labIDs = $lab::all('id')->pluck('id')->toArray();

        for ($i = 0; $i <= 5; $i++) {

            DB::table('lab_services')->insert([
                'labID' => $faker->randomElement($labIDs),
                'token' => $faker->unique()->uuid,
                'name' => $faker->name,
                'price' => $faker->numberBetween(100, 9999),
                'note' => $faker->realText(100),
                'activity' => 1
            ]);
        }
    }
}
