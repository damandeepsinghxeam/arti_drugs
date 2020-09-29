<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJrfLevelOneScreeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jrf_level_one_screenings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');  
            $table->string('contact');
            $table->string('age');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('jrf_id');
            $table->foreign('jrf_id')->references('id')->on('jrfs')->onDelete('cascade');
            
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');

            $table->enum('mgmt_status_id',['0','1','2'])->default(1);
            $table->enum('appoint_id',['0','1'])->default(0);
            $table->enum('lvl_sec_id',['0','1'])->default(0);
            $table->enum('closed_id',['0','1'])->default(0);

            $table->unsignedBigInteger('recruitment_task_id');
            $table->foreign('recruitment_task_id')->references('id')->on('jrf_recruitment_tasks')->onDelete('cascade');

            $table->string('native_place');
            $table->string('total_experience'); 
            $table->string('relevant_experience');
            $table->string('current_designation');      
            $table->string('current_cih');
            $table->string('current_ctc');
            $table->string('exp_ctc');
            $table->string('image')->nullable();
            $table->string('resume');
            $table->string('interview_date')->nullable();
            $table->string('interview_time')->nullable();
            $table->string('interview_type')->nullable();
            $table->string('other_backoff_reason')->nullable();
            $table->string('other_rejected_reason')->nullable();
            $table->string('reason_for_job_change')->nullable();
            $table->string('current_company_profile')->nullable();
            $table->string('travel')->nullable()->comment('Can Travel within the region & to HO');
            $table->string('contract')->nullable()->comment('Commitment for 1 Year');

            $table->enum('notice_period',['Yes','No'])->nullable()->comment('Notice Period');

            $table->enum('personal_laptop',['Yes','No'])->nullable();

            $table->string('notice_period_duration')->nullable();

            $table->string('final_candidate_status')->comment('Rejected reason and backoff reason if available in dropdown')->nullable();

            $table->enum('candidate_status',['Rejected','On-hold','Shortlisted','Recommended-Level-2-interview','Backoff'])->nullable();

            $table->enum('status_before_appoint',['0','1'])->default(0);
            $table->string('joining_date')->nullable();
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
        Schema::dropIfExists('jrf_level_one_screenings');
    }

}