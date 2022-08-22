<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('path')->nullable();
            $table->boolean('enable')->default(false);
            $table->boolean('canDelete')->default(false);
            $table->string('url')->nullable();
            $table->timestamps();
        });
        //Para hacer una referencia a si mismo
        Schema::table('system_modules', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('system_modules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_modules');
    }
}
