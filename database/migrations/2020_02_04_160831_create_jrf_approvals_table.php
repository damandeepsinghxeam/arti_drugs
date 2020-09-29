<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJrfApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jrf_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id'); // assigned to 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('jrf_id');
            $table->foreign('jrf_id')->references('id')->on('jrfs')->onDelete('cascade');

            $table->unsignedBigInteger('supervisor_id');
            $table->foreign('supervisor_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('priority');
            $table->enum('jrf_status', ['0','1','2','3'])->comment('0=inprogress, 1=approved, 2=rejected, 3=sendback'); 

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
        Schema::dropIfExists('jrf_approvals');
    }
}
