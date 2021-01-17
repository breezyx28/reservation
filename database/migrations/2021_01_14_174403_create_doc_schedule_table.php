<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('doc_schedule', function (Blueprint $table) {
            $table->bigIncrements('id');

            // $table->unsignedBigInteger('hospitalInofID');
            $table->unsignedBigInteger('docID');

            // $table->foreign('hospitalInofID')
            //     ->references('id')
            //     ->on('hospital_info')
            //     ->onDelete('cascade');

            $table->foreign('docID')
                ->references('id')
                ->on('doctor')
                ->onDelete('cascade');

            $table->boolean('saturday')->default(1);
            $table->boolean('sunday')->default(1);
            $table->boolean('monday')->default(1);
            $table->boolean('tuesday')->default(1);
            $table->boolean('wednesday')->default(1);
            $table->boolean('thursday')->default(1);
            $table->boolean('friday')->default(1);

            $table->boolean('off');

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
        Schema::dropIfExists('doc_schedule');
    }
}
