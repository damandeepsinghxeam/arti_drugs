<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceChangeApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_change_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('attendance_change_id');
            $table->foreign('attendance_change_id')->references('id')->on('attendance_changes')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('manager_id');
            $table->foreign('manager_id')->references('id')->on('users')->onDelete('cascade');

            $table->enum('priority', ['1', '2'])->default('1')->comment('1=HOD,2=IT');

            $table->enum('status', ['0', '1', '2'])->default('0')->comment('0=None,1=Approved,2=Rejected');

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
        Schema::dropIfExists('attendance_change_approvals');
    }
}
