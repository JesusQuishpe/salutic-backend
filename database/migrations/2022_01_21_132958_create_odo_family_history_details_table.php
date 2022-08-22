<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdoFamilyHistoryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odo_family_history_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fam_id');
            $table->foreign('fam_id')->references('id')->on('odo_family_histories');
            $table->unsignedBigInteger('disease_id');
            $table->foreign('disease_id')->references('id')->on('odo_disease_list');
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
        Schema::dropIfExists('odo_family_history_details');
    }
}
