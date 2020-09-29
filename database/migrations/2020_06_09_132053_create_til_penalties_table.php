<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTilPenaltiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('til_penalties', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('til_id');
            $table->foreign('til_id')->references('id')->on('tils')->onDelete('cascade');

            $table->string('penalty')->nullable();

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
        Schema::dropIfExists('til_penalties');
    }
}
