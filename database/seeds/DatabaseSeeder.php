<?php

use App\LabDiagnosis;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            HospitalServicesSeeder::class,
        ]);
    }
}
