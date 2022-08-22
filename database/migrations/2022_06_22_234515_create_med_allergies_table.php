<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedAllergiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('med_allergies', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('record_id');
      $table->foreign('record_id')->references('id')->on('med_expedients');
      $table->string('description', 500);
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
    Schema::dropIfExists('med_allergies');
  }
}
