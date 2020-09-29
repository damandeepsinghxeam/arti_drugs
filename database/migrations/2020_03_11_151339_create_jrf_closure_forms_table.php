<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJrfClosureFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jrf_closure_forms', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id'); // assigned to 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('jrf_id');
            $table->foreign('jrf_id')->references('id')->on('jrfs')->onDelete('cascade');
            $table->unsignedBigInteger('level_one_screening_id');
            $table->foreign('level_one_screening_id')->references('id')->on('jrf_level_one_screenings')->onDelete('cascade');
            $table->unsignedBigInteger('level_two_screening_id');
            $table->foreign('level_two_screening_id')->references('id')->on('jrf_level_two_screenings')->onDelete('cascade');
            $table->string('closure_date')->nullable()->comment('JRF Closure Date');
            $table->enum('quick_learner',['Excellent','Very-good','Good','Average'])->nullable()->comment('REPORTING MANAGER FEEDBACK');
            $table->enum('confidence_level',['Excellent','Very-good','Good','Average'])->nullable();
            $table->enum('attitude_behavior',['Excellent','Very-good','Good','Average'])->nullable();
            $table->enum('team_work',['Excellent','Very-good','Good','Average'])->nullable();
            $table->enum('execution_skills',['Excellent','Very-good','Good','Average'])->nullable();
            $table->enum('result_orientation',['Excellent','Very-good','Good','Average'])->nullable();
            $table->enum('attendance',['Regular','Not Regular'])->nullable();
            $table->enum('kra_assigned',['Yes','No'])->nullable();
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
        Schema::dropIfExists('jrf_closure_forms');
    }
}
