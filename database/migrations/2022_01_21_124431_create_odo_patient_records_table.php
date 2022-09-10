<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdoPatientRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odo_patient_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('nur_id');
            $table->foreign('nur_id')->references('id')->on('nursing_area');
            $table->string('date',10);
            $table->string('hour',8);
            $table->string('age_range')->nullable();
            $table->string('reason_consultation',500);
            $table->string('current_disease_and_problems',500);
            $table->boolean('attended')->default(false);
            $table->string('odontogram_path')->nullable();
            $table->string('acta_path')->nullable();
            $table->string('odontogram_client_basename')->nullable();
            $table->string('acta_client_basename')->nullable();
            $table->float('value')->default(0);
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
        Schema::dropIfExists('odo_patient_records');
    }
}
