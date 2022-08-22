<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalAppointmentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('medical_appointments', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->foreign('user_id')->references('id')->on('users');
      $table->unsignedBigInteger('patient_id');
      $table->foreign('patient_id')->references('id')->on('patients');
      $table->string('date', 11);
      $table->string('hour', 8);
      //$table->string('appo_identification_number',10);
      $table->string('area', 25);
      $table->float('value');
      $table->float('initial_value');
      //$table->string('factura_cita',15)->nullable()->default(null);
      //$table->string('estado_cita',20)->nullable()->default(null);
      $table->boolean('attended')->default(false);
      $table->boolean('nur_attended')->default(false);
      $table->boolean('cancelled')->default(false);

      //$table->string('estadisticas',15)->nullable()->default(null);
      //$table->boolean('atendido')->default(false);
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
    Schema::dropIfExists('medical_appointments');
  }
}
