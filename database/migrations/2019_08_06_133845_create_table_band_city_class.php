<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBandCityClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('band_city_class', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('band_id');
            $table->foreign('band_id')->references('id')->on('bands')->onDelete('cascade');
            $table->unsignedBigInteger('city_class_id');
            $table->foreign('city_class_id')->references('id')->on('city_classes')->onDelete('cascade');
            $table->float('price', 6,2);
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
        Schema::dropIfExists('band_city_class');
    }
}
