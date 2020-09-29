<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTilDraftSpecialEligibilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('til_draft_special_eligibilities', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('til_draft_id');
            $table->foreign('til_draft_id')->references('id')->on('til_drafts')->onDelete('cascade');

            $table->string('special_eligibility')->nullable();

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
        Schema::dropIfExists('til_draft_special_eligibilities');
    }
}