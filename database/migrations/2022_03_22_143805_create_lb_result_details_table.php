<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbResultDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_result_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('result_id');
            $table->foreign('result_id')->references('id')->on('lb_results');
            $table->unsignedBigInteger('test_id');
            $table->foreign('test_id')->references('id')->on('lb_tests');
            $table->string('string_result',100)->nullable();
            $table->float('numeric_result')->nullable();
            $table->string('remarks',300)->nullable();
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
        Schema::dropIfExists('lb_result_details');
    }
}
