<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdoMovilitiesRecessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odo_movilities_recessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('odo_id');
            $table->foreign('odo_id')->references('id')->on('odo_odontogram');
            $table->string('type',100);
            $table->string('value',1);
            $table->integer('pos');
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
        Schema::dropIfExists('odo_movilities_recessions');
    }
}
