<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBdTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->string('name');
            $table->enum('team_type', ['govt', 'corp'])->comment('govt => Government, corp => Corporate');
            $table->boolean('isactive')->default(1);
            $table->bigInteger('created_by');
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
        Schema::dropIfExists('bd_teams');
    }
}
