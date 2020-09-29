<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArfJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arf_job_posts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('jrf_id');
            $table->foreign('jrf_id')->references('id')->on('jrfs')->onDelete('cascade');
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
        Schema::dropIfExists('arf_job_posts');
    }
}
