<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('probation_period_id');
            $table->foreign('probation_period_id')->references('id')->on('probation_periods')->onDelete('cascade');

            $table->date('probation_end_date')->nullable();
            $table->date('probation_extended_date')->nullable();
            $table->date('probation_reduced_date')->nullable();
            $table->enum('probation_approval_status', ['0', '1'])->comment('0=Not Approved, 1=Approved');
            $table->enum('probation_hod_approval', ['0', '1'])->comment('0=Not Approved, 1=Approved');
            $table->enum('probation_hr_approval', ['0', '1'])->comment('0=Not Approved, 1=Approved');

            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');

            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');

            $table->unsignedBigInteger('shift_id');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');

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
        Schema::dropIfExists('employee_profiles');
    }
}
