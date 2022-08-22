<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdoIndicatorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odo_indicator_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ind');
            $table->foreign('id_ind')->references('id')->on('odo_indicators');
            $table->string('selected_pieces');
            $table->integer('plaque')->nullable();
            $table->integer('calc')->nullable();
            $table->integer('gin')->nullable();
            $table->integer('row_pos')->nullable();
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
        Schema::dropIfExists('odo_indicator_details');
    }
}
