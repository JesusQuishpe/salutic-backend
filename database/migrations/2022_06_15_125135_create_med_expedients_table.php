<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedExpedientsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('med_expedients', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('patient_id');
      $table->foreign('patient_id')->references('id')->on('patients');
      $table->string('date', 12);
      $table->string('hour', 10);
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
    Schema::dropIfExists('med_expedients');
  }
}
