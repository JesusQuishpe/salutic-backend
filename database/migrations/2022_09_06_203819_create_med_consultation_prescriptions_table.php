<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedConsultationPrescriptionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('med_consultation_prescriptions', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('consultation_id');
      $table->foreign('consultation_id')->references('id')->on('med_consultations');
      $table->unsignedBigInteger('medicine_id');
      $table->foreign('medicine_id')->references('id')->on('medicines');
      $table->string('dosification',150);
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
    Schema::dropIfExists('med_consultation_prescriptions');
  }
}
