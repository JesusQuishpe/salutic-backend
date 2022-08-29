<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedPhysicalActivityTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('med_physical_activity', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('record_id');
      $table->foreign('record_id')->references('id')->on('med_expedients');
      $table->boolean('do_exercise')->default(0);
      $table->integer('min_per_day')->default(0);
      $table->boolean('do_sport')->default(0);
      $table->string('sport_description', 200)->default('');
      $table->string('sport_frequency', 200)->default('');
      $table->boolean('sleep')->default(0);
      $table->integer('sleep_hours')->default(0);
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
    Schema::dropIfExists('med_physical_activity');
  }
}
