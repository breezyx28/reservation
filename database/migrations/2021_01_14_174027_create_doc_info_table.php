<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('doc_info', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('specialization')->nullable();
            $table->bigInteger('interviewPrice')->default(0);

            $table->unsignedBigInteger('docID');

            $table->foreign('docID')
                ->references('id')
                ->on('doctor')
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
        Schema::dropIfExists('doc_info');
    }
}
