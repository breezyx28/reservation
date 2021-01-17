<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('lab_services', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('labID');

            $table->foreign('labID')
                ->references('id')
                ->on('lab')
                ->onDelete('cascade');

            $table->string('token')->unique();
            $table->string('name');
            $table->bigInteger('price');
            $table->text('note')->nullable();
            $table->boolean('activity');
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
        Schema::dropIfExists('lab_services');
    }
}
