<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedLifestylesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('med_lifestyles', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('record_id');
      $table->foreign('record_id')->references('id')->on('med_expedients');
      //Actividad Fisica ---------------------------
      $table->boolean('do_exercise')->default(0);
      $table->integer('min_per_day')->default(0);
      $table->boolean('do_sport')->default(0);
      $table->string('sport_description', 200)->default('');
      $table->string('sport_frequency', 200)->default('');
      $table->boolean('sleep')->default(0);
      $table->integer('sleep_hours')->default(0);
      //Tabaquismo
      $table->boolean('smoke')->default(0);
      $table->integer('start_smoking_age')->default(0);
      $table->boolean('former_smoker')->default(0);
      $table->integer('cigars_per_day')->default(0);
      $table->boolean('passive_smoker')->default(0);
      $table->integer('stop_smoking_age')->default(0);
      //Habitos alimenticios
      $table->boolean('breakfast')->default(0);
      $table->integer('meals_per_day')->default(0);
      $table->boolean('drink_coffe')->default(0);
      $table->integer('cups_per_day')->default(0);
      $table->boolean('drink_soda')->default(0);
      $table->boolean('do_diet')->default(0);
      $table->string('diet_description', 200)->default('');
      //Otros
      $table->boolean('work_authonomy')->default(0); //Autonomia en el trabajo
      $table->string('work_shift', 200)->default(''); //Turno en el trabajo
      $table->string('hobbies', 300)->default(''); //Actividades que realiza en tiempos libres
      $table->string('other_situations', 300)->default('');
      //Consumo de drogas
      $table->boolean('take_drugs')->default(0); //Consume drogas
      $table->boolean('former_addict')->default(0);
      $table->integer('start_age_consume')->default(0);
      $table->integer('stop_age_consume')->default(0);
      $table->boolean('iv_drugs')->default(0); //Droga intravenosa
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
    Schema::dropIfExists('med_lifestyles');
  }
}
