<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('log_id');
            $table->foreign('log_id')->references('id')->on('logs')->onDelete('cascade');

            $table->string('message');
            $table->longText('data')->nullable();
            $table->bigInteger('log_detailable_id');
            $table->string('log_detailable_type');

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
        Schema::dropIfExists('log_details');
    }
}
