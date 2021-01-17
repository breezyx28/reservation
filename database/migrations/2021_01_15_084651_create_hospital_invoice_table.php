<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('hospital_invoice', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('invoiceToken')->unique();

            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('labID');
            $table->unsignedBigInteger('hospitalID');

            $table->string('service')->nullable();

            $table->foreign('userID')
                ->references('userID')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('labID')
                ->references('id')
                ->on('lab')
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
        Schema::dropIfExists('hospital_invoice');
    }
}
