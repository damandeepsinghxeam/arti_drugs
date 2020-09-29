<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelStaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_stays', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('travel_id');
            $table->foreign('travel_id')->references('id')->on('travel_approvals')->onDelete('cascade');

            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');

            $table->date('from_date');
            $table->date('to_date');
            $table->float('rate_per_night', 7,2);
            $table->float('da', 7,2);

            $table->enum('status', ['new', 'discussion', 'hold', 'discarded'])->default('new');

            $table->string('remarks')->nullable();
            $table->boolean('isactive')->default(1)->comment('0 for deleted records and 1 for active records');
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
        Schema::dropIfExists('travel_stays');
    }
}
