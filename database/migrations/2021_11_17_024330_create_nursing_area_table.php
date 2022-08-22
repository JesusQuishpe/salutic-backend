<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNursingAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nursing_area', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('appo_id');
            $table->foreign('appo_id')->references('id')->on('medical_appointments');
            $table->float('weight',10,2)->nullable();
            $table->float('stature',10,2)->nullable();
            $table->float('temperature',10,2)->nullable();
            $table->string('pressure',15)->default('');
            $table->float('imc',10,2)->nullable();
            $table->string('imc_diagnostic',50)->default('');
            $table->float('breathing_frequency',10,2)->nullable();
            $table->float('heart_frequency',10,2)->nullable();
            //$table->char('enfermeria',1)->default('');
            //$table->string('doctor',50)->default('');
            //$table->string('therapy',255)->default('');
            $table->float('disability',10,2)->nullable();
            //$table->string('inyection',15)->default('');
            //$table->string('healing',15)->default('');//curacion
            //$table->float('pregnancy',10,2)->default(0.00);
            //$table->string('nurse',50)->default('');
            //$table->string('cardiopathy',255)->default('');
            //$table->string('diabetes',255)->default('');
            //$table->string('hypertension',255)->default('');
            //$table->string('surgeries',255)->default('');//cirugías
            //$table->string('medicine_allergies',255)->default('');
            //$table->string('food_allergies',255)->default('');
            //$table->char('consulting_room',1)->default('');//consultorio
            $table->boolean('attended')->default(false);
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
        Schema::dropIfExists('nursing_area');
    }
}
