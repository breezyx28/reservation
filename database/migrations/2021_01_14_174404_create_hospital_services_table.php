<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('hospital_services', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('servicesID');
            $table->unsignedBigInteger('hospitalID');

            $table->foreign('servicesID')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');

            $table->foreign('hospitalID')
                ->references('id')
                ->on('hospital')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hospital_services');
    }
}
