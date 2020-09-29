<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJrfLevelTwoScreeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jrf_level_two_screenings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id'); // assigned to 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('jrf_id');
            $table->foreign('jrf_id')->references('id')->on('jrfs')->onDelete('cascade');

            $table->unsignedBigInteger('jrf_level_one_screening_id');
            $table->foreign('jrf_level_one_screening_id')->references('id')->on('jrf_level_one_screenings')->onDelete('cascade');

            $table->unsignedBigInteger('department_id');    // HOD Department Id   //
            $table->unsignedBigInteger('designation_id');   // HOD Designation Id //

            $table->string('rating')->nullable();
            $table->longText('interview_remarks');
            $table->enum('video_recording_seen',['Yes','No','N/A'])->nullable();
            $table->enum('qualify',['Yes','No'])->nullable()->comment('Check qualify for Next Round');
            $table->string('level')->nullable()->comment('Next level on phone or F2F (at location or HO)');
            $table->string('interaction_date')->nullable()->comment('Date of Interaction with Management'); 
            $table->enum('final_result',['Rejected','Selected','On-hold'])->nullable();
            $table->enum('status',['0','1'])->default(0);
            $table->string('reject_reason ')->nullable();
            $table->enum('mgmt_status',['0','1','2'])->default(0);
            $table->string('mgmt_date');
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
        Schema::dropIfExists('jrf_level_two_screenings');
    }
}