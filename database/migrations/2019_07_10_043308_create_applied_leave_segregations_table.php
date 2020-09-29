<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppliedLeaveSegregationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applied_leave_segregations', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('applied_leave_id');
            $table->foreign('applied_leave_id')->references('id')->on('applied_leaves')->onDelete('cascade');
            
            $table->date('from_date');
            $table->date('to_date');
            $table->string('number_of_days');
            $table->string('paid_count')->default('0');
            $table->string('unpaid_count')->default('0');
            $table->string('compensatory_count')->default('0');

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
        Schema::dropIfExists('applied_leave_segregations');
    }
}
