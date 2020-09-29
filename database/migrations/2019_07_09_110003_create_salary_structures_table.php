<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_structures', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->unsignedBigInteger('salary_cycle_id');
            $table->foreign('salary_cycle_id')->references('id')->on('salary_cycles')->onDelete('cascade');
            $table->unsignedBigInteger('salary_head_id');
            $table->foreign('salary_head_id')->references('id')->on('salary_heads')->onDelete('cascade');
            $table->enum('calculation_type', ['earning', 'deduction'])->comment('earning or deductions');
            $table->boolean('isactive')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('salary_structures');
    }
}
