<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelClimbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_climbers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('travel_id');
            $table->foreign('travel_id')->references('id')->on('travels')->onDelete('cascade');

            $table->unsignedBigInteger('climber_user_id');
            $table->foreign('climber_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('remarks')->nullable();

            $table->enum('status', ['new','back','discussion','hold','discarded','approved','paid'])
            ->comment('new, back, discussion, hold, discarded, approved, paid');
            
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
        Schema::dropIfExists('travel_climbers');
    }
}
