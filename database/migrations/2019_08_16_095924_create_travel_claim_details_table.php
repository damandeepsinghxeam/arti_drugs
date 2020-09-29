<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelClaimDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_claim_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('travel_claim_id');
            $table->foreign('travel_claim_id')->references('id')->on('travel_claims')->onDelete('cascade');

            $table->date('expense_date');
            $table->string('from_location');
            $table->string('to_location');
            $table->string('expense_type');//conveyance type from master as text
            $table->string('description');
            $table->float('amount', 9,2);
            $table->enum('status', ['new', 'back', 'paid'])->default('new');

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
        Schema::dropIfExists('travel_claim_details');
    }
}
