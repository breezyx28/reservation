<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('setting', function (Blueprint $table) {
            $table->id();
            $table->integer('companyPercentage')->nullable();
            $table->integer('companyValue')->nullable();

            $table->unsignedBigInteger('adminID');

            $table->foreign('adminID')
                ->references('id')
                ->on('admin')
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
        Schema::dropIfExists('setting');
    }
}
