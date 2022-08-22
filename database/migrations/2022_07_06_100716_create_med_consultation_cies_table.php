<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedConsultationCiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('med_consultation_cies', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('consultation_id');
      $table->foreign('consultation_id')->references('id')->on('med_consultations');
      $table->unsignedBigInteger('cie_id');
      $table->foreign('cie_id')->references('id')->on('cies');
      $table->string('disease_state')->nullable();
      $table->string('severity')->default("")->nullable();
      $table->boolean('active_disease')->default(false)->nullable();
      $table->boolean('infectious_disease')->default(false)->nullable();
      $table->string('diagnostic_date', 10)->nullable();
      $table->string('observations', 500)->nullable();
      $table->integer('diagnostic_age')->nullable();
      $table->string('cured', 12)->nullable(); //Es fecha
      $table->boolean('allergic_disease')->default(false)->nullable();
      $table->string('allergy_type', 50)->nullable();
      $table->boolean('warnings_during_pregnancy')->default(false)->nullable();
      $table->integer('week_contracted')->nullable();
      $table->boolean('currently_in_treatment')->default(false)->nullable();
      $table->string('aditional_information', 500)->nullable();
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
    Schema::dropIfExists('med_consultation_cies');
  }
}
