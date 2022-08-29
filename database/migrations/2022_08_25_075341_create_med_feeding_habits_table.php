<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedFeedingHabitsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('med_feeding_habits', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('record_id');
      $table->foreign('record_id')->references('id')->on('med_expedients');
      $table->boolean('breakfast')->default(0);
      $table->integer('meals_per_day')->default(0);
      $table->boolean('drink_coffe')->default(0);
      $table->integer('cups_per_day')->default(0);
      $table->boolean('drink_soda')->default(0);
      $table->boolean('do_diet')->default(0);
      $table->string('diet_description', 200)->default('');
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
    Schema::dropIfExists('med_feeding_habits');
  }
}
