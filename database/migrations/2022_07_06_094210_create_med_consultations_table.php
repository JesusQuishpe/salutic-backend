<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedConsultationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('med_consultations', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id')->nullable();
      $table->foreign('user_id')->references('id')->on('users');
      $table->unsignedBigInteger('nur_id')->nullable()->default(null); //Establecemos null por el anterior backup
      $table->foreign('nur_id')->references('id')->on('nursing_area');
      $table->string('date', 12)->nullable();
      $table->string('hour', 10)->nullable();
      $table->string('consultation_type', 50)->nullable();
      $table->string('reason_consultation', 500);
      $table->string('symptoms', 500);
      $table->string('apparatus_and_systems', 500);
      $table->string('physical_exploration', 500);
      $table->string('laboratory_studies', 500);
      $table->string('diagnostics', 500);
      $table->string('treatments', 500);
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
    Schema::dropIfExists('med_consultations');
  }
}
