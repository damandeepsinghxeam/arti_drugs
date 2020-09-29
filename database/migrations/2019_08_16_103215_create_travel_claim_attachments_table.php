<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelClaimAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_claim_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('travel_claim_id');
            $table->foreign('travel_claim_id')->references('id')->on('travel_claims')->onDelete('cascade');

            $table->string('name');
            $table->string('attachment');
            $table->string('attachment_type');//conveyance type from master as text
            $table->enum('status', ['new', 'back', 'paid'])->default('new');
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
        Schema::dropIfExists('travel_claim_attachments');
    }
}
