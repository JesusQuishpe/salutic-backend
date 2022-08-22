<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdoStomatognathicDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odo_stomatognathic_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sto_test_id');
            $table->foreign('sto_test_id')->references('id')->on('odo_stomatognathic_tests');
            $table->unsignedBigInteger('pat_id');
            $table->foreign('pat_id')->references('id')->on('odo_pathologies');
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
        Schema::dropIfExists('odo_stomatognathic_details');
    }
}
