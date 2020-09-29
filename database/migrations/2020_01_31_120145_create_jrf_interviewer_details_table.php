<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJrfInterviewerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jrf_interviewer_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->unsignedBigInteger('jrf_level_one_screening_id');
            $table->foreign('jrf_level_one_screening_id')->references('id')->on('jrf_level_one_screenings')->onDelete('cascade');

            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            
            $table->unsignedBigInteger('jrf_id');
            $table->foreign('jrf_id')->references('id')->on('jrfs')->onDelete('cascade');

            $table->unsignedBigInteger('recruitment_task_id');
            $table->foreign('recruitment_task_id')->references('id')->on('jrf_recruitment_tasks')->onDelete('cascade');          
            
            $table->string('assigned_by');
            $table->string('candidate_name');
            $table->string('interview_date')->nullable();
            $table->string('interview_time')->nullable();
            $table->enum('interview_status', ['backoff','selected','rejected'])->nullable();
            $table->string('other_backoff_reason')->nullable();
            $table->string('other_rejected_reason')->nullable();
            $table->string('interview_type')->nullable();
            $table->string('final_status')->nullable();
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
        Schema::dropIfExists('jrf_interviewer_details');
    }
}