<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTravelImprestables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_imprestables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('travel_imprestable_id')->nullable()->comment('model_id');
            $table->string('travel_imprestable_type')->nullable()->comment('model_type');

            $table->unsignedBigInteger('travel_imprest_id');
            $table->foreign('travel_imprest_id')->references('id')->on('travel_imprests')->onDelete('cascade');
            
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
        Schema::dropIfExists('travel_imprestables');
    }
}
