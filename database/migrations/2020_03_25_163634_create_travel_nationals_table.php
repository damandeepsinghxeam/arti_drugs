<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelNationalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_nationals', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('travel_id');
            $table->foreign('travel_id')->references('id')->on('travels')->onDelete('cascade');

            $table->dateTime('travel_date');

            $table->unsignedBigInteger('from_city_id');
            $table->foreign('from_city_id')->references('id')->on('cities')->onDelete('cascade');

            $table->unsignedBigInteger('to_city_id');
            $table->foreign('to_city_id')->references('id')->on('cities')->onDelete('cascade');

            $table->enum('approval_duration', ['one time', 'monthly'])->comment('one time', 'monthly');

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
        Schema::dropIfExists('travel_nationals');
    }
}
