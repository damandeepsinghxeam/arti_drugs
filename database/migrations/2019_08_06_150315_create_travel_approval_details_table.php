<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelApprovalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_approval_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('travel_approval_id');
            $table->foreign('travel_approval_id')->references('id')->on('travel_approvals')->onDelete('cascade');
            $table->date('travel_date');
            $table->unsignedBigInteger('city_id_from');
            $table->foreign('city_id_from')->references('id')->on('cities')->onDelete('cascade');
            $table->unsignedBigInteger('city_id_to');
            $table->foreign('city_id_to')->references('id')->on('cities')->onDelete('cascade');
            $table->unsignedBigInteger('conveyance_id');
            $table->foreign('conveyance_id')->references('id')->on('conveyances')->onDelete('cascade');
            
            $table->string('city_class');
            $table->float('expected_amount', 9,2);
            $table->float('expected_amount_local', 8,2);

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
        Schema::dropIfExists('travel_approval_details');
    }
}
