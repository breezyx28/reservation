<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('hospital', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('state');
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('lat');
            $table->string('lng');
            $table->integer('role')->default(1);
            $table->integer('companyEarns')->default(20);
            $table->boolean('activity')->default(1);
            $table->boolean('verified')->default(0);
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
        Schema::dropIfExists('hospital');
    }
}
