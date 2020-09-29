<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJrfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jrfs', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id'); // assigned to 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('jrf_no');

            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');

            $table->unsignedBigInteger('interviewr_id');


            $table->unsignedBigInteger('designation_id');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');
            $table->string('send_back_remark')->nullable();
            $table->string('jrf_closure_timeline')->nullable();
            $table->string('date_remark')->nullable();
            $table->string('extended_date')->nullable();
            $table->enum('extended_date_status', ['0','1','2','3','4'])->default(0);
            $table->unsignedBigInteger('close_jrf_user_id')->nullable(); // assigned to 
            $table->unsignedBigInteger('closed_jrf')->nullable();
            $table->unsignedBigInteger('lvl_one_screen')->nullable();

            $table->unsignedBigInteger('role_id');
            $table->integer('number_of_positions');
            $table->integer('hired_candidate');
            $table->string('age_group');
            $table->enum('gender', ['Male','Female','Any of Them'])->nullable();
            $table->enum('final_status', ['0','1','2','3'])->nullable();
            $table->string('shift_timing_from')->nullable();;
            $table->string('shift_timing_to')->nullable();;

            $table->enum('job_posting_other_website', ['Yes','No'])->nullable();

            // when JRF Type Project //
            $table->enum('type', ['Xeam','Project']);
            $table->string('certification')->nullable();
            $table->string('benefits_perks')->nullable();
            $table->string('temp_or_perm')->nullable();
            $table->string('service_charges_fee')->nullable();
            $table->enum('closure_type', ['open','closed'])->default(open);
            $table->string('closure_date')->nullable();
            //  end

            $table->enum('closure_jrf_status', ['0','1'])->default(0);

            $table->binary('description');
            $table->string('additional_requirement')->nullable();
            $table->string('salary_range');
            $table->string('experience');
            $table->string('industry_type');
            $table->string('document');
            $table->string('close_jrf_date');
            $table->binary('rejection_reason')->nullable();
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
        Schema::dropIfExists('jrfs');
    }
}
