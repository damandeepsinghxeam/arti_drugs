<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PtRateSalaryRanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pt_rate_salary_ranges', function (Blueprint $table){
            $table->bigIncrements('id');

            $table->unsignedBigInteger('pt_rate_id');
            $table->foreign('pt_rate_id')->references('id')->on('pt_rates')->onDelete('cascade');

            $table->decimal('min_salary', 24,2);
            $table->decimal('max_salary', 24, 2);
            $table->decimal('pt_rate', 24, 2);
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
        //
    }
}
