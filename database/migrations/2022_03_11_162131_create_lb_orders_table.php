<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appo_id');
            $table->foreign('appo_id')->references('id')->on('medical_appointments');
            $table->string('date',12);
            $table->string('hour',8);
            $table->integer('test_items');
            $table->boolean('is_pending')->default(true);
            $table->float('total');
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
        Schema::dropIfExists('lb_orders');
    }
}
