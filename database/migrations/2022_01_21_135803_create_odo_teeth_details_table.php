<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdoTeethDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odo_teeth_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('odo_id');
            $table->foreign('odo_id')->references('id')->on('odo_odontogram');
            $table->unsignedBigInteger('tooth_id');
            $table->foreign('tooth_id')->references('id')->on('odo_teeth');
            $table->unsignedBigInteger('symbo_id')->nullable();
            $table->foreign('symbo_id')->references('id')->on('odo_symbologies');
            $table->string('left_side',50)->nullable();
            $table->string('top_side',50)->nullable();
            $table->string('right_side',50)->nullable();
            $table->string('bottom_side',50)->nullable();
            $table->string('center_side',50)->nullable();
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
        Schema::dropIfExists('odo_teeth_details');
    }
}
