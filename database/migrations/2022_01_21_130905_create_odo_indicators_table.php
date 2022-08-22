<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdoIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odo_indicators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rec_id');
            $table->foreign('rec_id')->references('id')->on('odo_patient_records');
            $table->string('per_disease',50)->nullable();
            $table->string('bad_occlu',50)->nullable();
            $table->string('fluorosis',50)->nullable();
            $table->float('plaque_total')->nullable();
            $table->float('calc_total')->nullable();
            $table->float('gin_total')->nullable();
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
        Schema::dropIfExists('odo_indicators');
    }
}
