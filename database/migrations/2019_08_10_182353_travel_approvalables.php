<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TravelApprovalables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_approvalables', function (Blueprint $table) {
            $table->bigIncrements('id');
            //morph to projects from opportunities, approved projects etc
            $table->unsignedBigInteger('travel_approvalable_id')->nullable()->comment('model_id');
            $table->string('travel_approvalable_type')->nullable()->comment('model_type');

            $table->unsignedBigInteger('travel_approval_id');
            $table->foreign('travel_approval_id')->references('id')->on('travel_approvals')->onDelete('cascade');
            
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
        Schema::dropIfExists('travel_approvalables');
    }
}
