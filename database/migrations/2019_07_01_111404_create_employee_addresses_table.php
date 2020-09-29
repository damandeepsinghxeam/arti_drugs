<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['1', '2'])->comment('1=Present, 2=Permanent');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('house_number')->nullable();
            $table->string('road_street')->nullable();
            $table->string('locality_area')->nullable();
            $table->string('pincode')->nullable();
            $table->string('emergency_number')->nullable();

            $table->unsignedBigInteger('emergency_number_country_id');
            $table->foreign('emergency_number_country_id')->references('id')->on('countries')->onDelete('cascade');

            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');

            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            
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
        Schema::dropIfExists('employee_addresses');
    }
}
