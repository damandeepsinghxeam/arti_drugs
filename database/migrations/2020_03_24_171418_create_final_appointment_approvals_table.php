<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinalAppointmentApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_appointment_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('jrf_level_one_screening_id');
            $table->foreign('jrf_level_one_screening_id')->references('id')->on('jrf_level_one_screenings')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('jrf_id');
            $table->foreign('jrf_id')->references('id')->on('jrfs')->onDelete('cascade');

            $table->enum('appointed_status',['0','1'])->default(0);

            $table->unsignedBigInteger('ctc');
            $table->unsignedBigInteger('cih')

            $table->enum('incentives',['Yes','No'])->nullable();
            $table->enum('offer_letter',['Yes','No'])->nullable();
            $table->enum('id_card',['Yes','No'])->nullable();

            $table->enum('esi_gpa_ghi',['Yes','No'])->nullable();
            $table->enum('epf',['Yes','No'])->nullable();
            $table->enum('erp_login',['Yes','No'])->nullable();
            
            $table->unsignedBigInteger('department_id');    // HOD Department Id   //
            $table->unsignedBigInteger('designation_id');   // HOD Designation Id //

            $table->enum('addition_in_company_group',['Yes','No'])->nullable();

            $table->enum('security',['Yes','No'])->nullable();
            $table->enum('security_amount',['Yes','No'])->nullable();
            $table->enum('security_cheque',['Yes','No'])->nullable();

            $table->string('training_period')->nullable();
            $table->string('probation_period')->nullable();
            $table->string('security_cheque_number')->nullable();
            $table->string('bank_name')->nullable();

            $table->string('leave_module')->nullable();
            $table->enum('sim_card',['Yes','Not-Applicable'])->nullable();
            
            $table->enum('laptop_or_pc',['Laptop','PC','Not-Applicable'])->nullable();
            $table->enum('mail_id',['XEAM','GMAIL','Not-Applicable'])->nullable();
            $table->enum('visiting_card',['Yes','Not-Applicable'])->nullable();
            $table->enum('uniform',['Yes','Not-Applicable'])->nullable();

            $table->enum('joining_status',['0','1'])->default('0');
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
        Schema::dropIfExists('final_appointment_approvals');
    }
}
