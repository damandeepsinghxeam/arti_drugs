<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryEarningSalaryStructureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_earning_salary_structure', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('salary_structure_id');
            $table->foreign('salary_structure_id')->references('id')->on('salary_structures')->onDelete('cascade');

            $table->unsignedBigInteger('salary_earning_id');
            $table->foreign('salary_earning_id')->references('id')->on('salary_earnings')->onDelete('cascade');

            $table->boolean('isactive')->default(1);

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
        Schema::dropIfExists('salary_earning_salary_structure');
    }
}
