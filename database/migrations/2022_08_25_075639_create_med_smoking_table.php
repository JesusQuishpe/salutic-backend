<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedSmokingTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('med_smoking', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('record_id');
      $table->foreign('record_id')->references('id')->on('med_expedients');
      $table->boolean('smoke')->default(0);
      $table->integer('start_smoking_age')->default(0);
      $table->boolean('former_smoker')->default(0);
      $table->integer('cigars_per_day')->default(0);
      $table->boolean('passive_smoker')->default(0);
      $table->integer('stop_smoking_age')->default(0);
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
    Schema::dropIfExists('med_smoking');
  }
}
