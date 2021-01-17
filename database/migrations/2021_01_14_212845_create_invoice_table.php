<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('invoice', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('invoiceToken')->unique();
            $table->string('userAttendToken')->unique();

            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('userDiagnosisID');

            $table->foreign('userID')
                ->references('userID')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('userDiagnosisID')
                ->references('id')
                ->on('user_diagnosis')
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
        Schema::dropIfExists('invoice');
    }
}
