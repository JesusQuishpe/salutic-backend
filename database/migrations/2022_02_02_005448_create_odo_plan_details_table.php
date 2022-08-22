<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdoPlanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odo_plan_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diag_plan_id');
            $table->foreign('diag_plan_id')->references('id')->on('odo_diagnostic_plans');
            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('odo_plans');
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
        Schema::dropIfExists('odo_plan_details');
    }
}
