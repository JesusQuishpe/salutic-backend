<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->references('id')->on('lb_groups');
            $table->unsignedBigInteger('measure_id')->nullable();
            $table->foreign('measure_id')->references('id')->on('lb_measurement');
            $table->string('code',20)->unique();
            $table->string('name',100)->unique();
            $table->string('ref_value',1)->default('');
            $table->float('of')->nullable()->default(0);
            $table->float('until')->nullable()->default(0);
            $table->string('operator_type',20)->nullable()->default('');
            $table->float('operator_value')->nullable()->default(0);
            $table->string('interpretation',100)->nullable()->default('');
            $table->float('male_of')->nullable()->default(0);
            $table->float('male_until')->nullable()->default(0);
            $table->string('male_interpretation',100)->nullable()->default('');
            $table->float('female_of')->nullable()->default(0);
            $table->float('female_until')->nullable()->default(0);
            $table->string('female_interpretation',100)->nullable()->default('');
            $table->string('qualitative_value',100)->nullable()->default('');
            $table->boolean('is_numeric')->default(false);
            $table->string('formula',100)->nullable()->default('');
            $table->string('operands',100)->nullable()->default('');
            $table->float('price')->default(0);
            $table->string('notes',300)->nullable()->default('');
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
        Schema::dropIfExists('lb_tests');
    }
}
