<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_drafts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('project_approval')->nullable();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status', ['0', '1', '2'])->default('0');
            $table->text('bg_data')->nullable();
            $table->text('insurance_data')->nullable();
            $table->text('it_req_data')->nullable();
            $table->text('salary_structure')->nullable();
            $table->integer('bg_counter')->nullable();
            $table->integer('it_counter')->nullable();
            $table->integer('insurance_counter')->nullable();
            $table->tinyInteger('sent_back')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('project_drafts');
    }
}
