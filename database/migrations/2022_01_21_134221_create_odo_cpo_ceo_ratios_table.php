<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdoCpoCeoRatiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odo_cpo_ceo_ratios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rec_id');
            $table->foreign('rec_id')->references('id')->on('odo_patient_records');
            $table->float('cd')->nullable();
            $table->float('pd')->nullable();
            $table->float('od')->nullable();
            $table->float('ce')->nullable();
            $table->float('ee')->nullable();
            $table->float('oe')->nullable();
            $table->float('cpo_total')->nullable();
            $table->float('ceo_total')->nullable();
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
        Schema::dropIfExists('odo_cpo_ceo_ratios');
    }
}
