<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicineAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine_area', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('nur_id')->nullable()->default(null);//Establecemos null por el anterior backup
            $table->foreign('nur_id')->references('id')->on('nursing_area');
            //$table->tinyText('tipo');//INYTEXT: 255 characters - 255 B.
            //$table->tinyText('valor');
            $table->string('symptom1');//sintoma
            $table->string('symptom2')->default('');
            $table->string('symptom3')->default('');
            $table->string('presumptive1');
            $table->string('presumptive2')->default('');
            $table->string('presumptive3')->default('');
            $table->string('definitive1');
            $table->string('definitive2')->default('');
            $table->string('definitive3')->default('');
            $table->string('medicine1');//medicamento
            $table->string('medicine2')->default('');
            $table->string('medicine3')->default('');
            $table->string('medicine4')->default('');
            $table->string('medicine5')->default('');
            $table->string('medicine6')->default('');
            $table->string('dosage1');//dosificacion
            $table->string('dosage2')->default('');
            $table->string('dosage3')->default('');
            $table->string('dosage4')->default('');
            $table->string('dosage5')->default('');
            $table->string('dosage6')->default('');
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
        Schema::dropIfExists('medicine_area');
    }
}
