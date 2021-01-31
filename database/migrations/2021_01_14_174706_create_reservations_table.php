<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::defaultStringLength(191);
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('hospitalInofID');
            $table->string('servicesArray')->nullable();

            $table->foreign('userID')
                ->references('userID')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('hospitalInofID')
                ->references('id')
                ->on('hospital_info')
                ->onDelete('cascade');

            $table->string('token')->unique();
            $table->string('statue');
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
        Schema::dropIfExists('reservations');
    }
}
