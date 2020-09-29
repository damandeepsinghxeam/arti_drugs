<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJrfLevelOneScreeningQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jrf_level_one_screening_qualifications', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('jrf_level_one_screening_id');
            $table->foreign('jrf_level_one_screening_id')->references('id')->on('jrf_level_one_screenings')->onDelete('cascade');

            $table->unsignedBigInteger('qualification_id');
            $table->foreign('qualification_id')->references('id')->on('qualifications')->onDelete('cascade');
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
        Schema::dropIfExists('jrf_level_one_screening_qualifications');
    }
}
