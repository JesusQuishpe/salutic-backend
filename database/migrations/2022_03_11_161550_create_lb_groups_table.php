<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')->on('lb_areas');
            $table->string('code',20)->unique();
            $table->string('name',100)->unique();
            $table->boolean('show_at_print')->default(false);
            $table->float('price')->default(0);
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
        Schema::dropIfExists('lb_groups');
    }
}
