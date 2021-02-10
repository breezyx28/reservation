<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('hospital_info', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('docID');
            $table->unsignedBigInteger('docInfoID');
            $table->unsignedBigInteger('docScheduleID');
            $table->unsignedBigInteger('hospitalID');

            $table->foreign('docID')
                ->references('id')
                ->on('doctor')
                ->onDelete('cascade');

            $table->foreign('docInfoID')
                ->references('id')
                ->on('doc_info')
                ->onDelete('cascade');

            $table->foreign('docScheduleID')
                ->references('id')
                ->on('doc_schedule')
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
        Schema::dropIfExists('hospital_info');
    }
}
