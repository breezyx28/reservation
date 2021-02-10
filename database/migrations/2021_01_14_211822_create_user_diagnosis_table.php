<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDiagnosisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('user_diagnosis', function (Blueprint $table) { // This only for lab
            $table->bigIncrements('id');

            $table->string('attendToken');
            $table->string('service')->nullable();

            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('labID');
            $table->unsignedBigInteger('labDiagnosisID');

            $table->text('note')->nullable();

            $table->foreign('userID')
                ->references('userID')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('labID')
                ->references('id')
                ->on('lab')
                ->onDelete('cascade');

            $table->foreign('labDiagnosisID')
                ->references('id')
                ->on('lab_diagnosis')
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
        Schema::dropIfExists('user_diagnosis');
    }
}
