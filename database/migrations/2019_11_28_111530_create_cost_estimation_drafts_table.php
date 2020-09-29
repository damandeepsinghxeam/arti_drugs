<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostEstimationDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_estimation_drafts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('til_draft_id');
            $table->foreign('til_draft_id')->references('id')->on('til_drafts')->onDelete('cascade');

            $table->text('estimation_data');

            $table->boolean('is_complete')->default(0);
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
        Schema::dropIfExists('cost_estimation_drafts');
    }
}