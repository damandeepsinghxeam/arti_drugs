<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppliedLeaveDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applied_leave_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('applied_leave_id');
            $table->foreign('applied_leave_id')->references('id')->on('applied_leaves')->onDelete('cascade');
            
            $table->string('name');
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
        Schema::dropIfExists('applied_leave_documents');
    }
}
