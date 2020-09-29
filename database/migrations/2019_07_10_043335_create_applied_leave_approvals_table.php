<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppliedLeaveApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applied_leave_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('applied_leave_id');
            $table->foreign('applied_leave_id')->references('id')->on('applied_leaves')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->unsignedBigInteger('supervisor_id');
            $table->foreign('supervisor_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->string('priority');
            $table->enum('leave_status', ['0','1','2'])->comment('0=inprogress, 1=approved, 2=rejected'); 

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
        Schema::dropIfExists('applied_leave_approvals');
    }
}
