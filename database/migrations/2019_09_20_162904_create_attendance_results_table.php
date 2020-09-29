<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_results', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->date('on_date');
            $table->string('department');
            $table->string('employee_name');
            $table->string('employee_code');
            $table->string('holidays')->default('0');
            $table->string('week_offs')->default('0');
            $table->string('workdays')->default('0');
            $table->string('late')->default('0');
            $table->string('absent_days')->default('0');
            $table->string('travel_days')->default('0');
            $table->string('paid_leaves')->default('0');
            $table->string('unpaid_leaves')->default('0');
            $table->string('total_present_days')->default('0');
            
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
        Schema::dropIfExists('attendance_results');
    }
}
