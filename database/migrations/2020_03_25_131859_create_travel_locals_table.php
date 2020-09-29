<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelLocalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_locals', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('travel_id');
            $table->foreign('travel_id')->references('id')->on('travels')->onDelete('cascade');

            $table->enum('approval_duration', ['one time', 'monthly'])->comment('one time', 'monthly');

            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');

            $table->unsignedBigInteger('conveyance_id');
            $table->foreign('conveyance_id')->references('id')->on('conveyances')->onDelete('cascade');

            $table->double('travel_amount', 10, 2);
            
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
        Schema::dropIfExists('travel_locals');
    }
}
