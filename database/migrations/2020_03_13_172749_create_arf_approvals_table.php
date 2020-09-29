<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArfApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arf_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id'); // assigned to 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('jrf_id');
            $table->foreign('jrf_id')->references('id')->on('jrfs')->onDelete('cascade');

            $table->unsignedBigInteger('arf_id');
            $table->foreign('arf_id')->references('id')->on('jrf_ad_requisition_forms')->onDelete('cascade');

            $table->unsignedBigInteger('supervisor_id');
            $table->foreign('supervisor_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('priority');
            $table->enum('arf_status', ['0','1','2'])->comment('0=inprogress, 1=approved, 2=rejected'); 

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
        Schema::dropIfExists('arf_approvals');
    }
}
