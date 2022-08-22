<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedInterrogationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('med_interrogations', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('record_id');
      $table->foreign('record_id')->references('id')->on('med_expedients');
      //Interrogatorio --------------------------
      $table->text('cardiovascular');
      $table->text('digestive');
      $table->text('endocrine');
      $table->text('hemolymphatic'); //hemolinfatico
      $table->text('mamas');
      $table->text('skeletal_muscle'); //musculo esqueletico
      $table->text('skin_and_annexes'); //Piel y anexos
      $table->text('reproductive'); //Reproductor
      $table->text('respiratory'); //respiratorio
      $table->text('nervous_system'); //sistema nervioso
      $table->text('general_systems'); //sistemas generales
      $table->text('urinary'); //urninario
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
    Schema::dropIfExists('med_interrogations');
  }
}
