<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedOthersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('med_others', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('record_id');
      $table->foreign('record_id')->references('id')->on('med_expedients');
      $table->boolean('work_authonomy')->default(0); //Autonomia en el trabajo
      $table->string('work_shift', 200)->default(''); //Turno en el trabajo
      $table->string('hobbies', 300)->default(''); //Actividades que realiza en tiempos libres
      $table->string('other_situations', 300)->default('');
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
    Schema::dropIfExists('med_others');
  }
}
