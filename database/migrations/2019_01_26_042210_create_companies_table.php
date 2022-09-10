<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('long_name',100);
            $table->string('short_name',20);
            $table->string('address',150);
            $table->string('phone',50);
            $table->string('email',320);
            $table->string('logo_path',150)->nullable()->default(null);
            $table->string('start_hour',8)->nullable();
            $table->string('end_hour',8)->nullable();
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
        Schema::dropIfExists('companies');
    }
}
