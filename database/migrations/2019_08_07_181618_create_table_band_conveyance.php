<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBandConveyance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('band_conveyance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('band_id');
            $table->foreign('band_id')->references('id')->on('bands')->onDelete('cascade');
            $table->unsignedBigInteger('conveyance_id');
            $table->foreign('conveyance_id')->references('id')->on('conveyances')->onDelete('cascade');
            $table->boolean('isactive')->default(1);
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
        Schema::dropIfExists('band_conveyance');
    }
}
