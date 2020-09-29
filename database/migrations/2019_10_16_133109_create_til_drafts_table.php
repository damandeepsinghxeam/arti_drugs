<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTilDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('til_drafts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('lead_id');
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->index('user_id');

            $table->string('tender_owner')->nullable();
            $table->string('tender_location')->nullable();
            $table->string('department')->nullable();
            $table->dateTime('due_date')->nullable();

            $table->bigInteger('vertical_id')->nullable();
            $table->double('value_of_work', 10, 2)->nullable();

            $table->enum('bid_system', ['online', 'manual', 'both'])->nullable();
            $table->double('volume', 10, 2)->nullable();

            $table->bigInteger('tenure_year_one')->nullable();
            $table->bigInteger('tenure_year_two')->nullable();

            $table->dateTime('emd_date')->nullable();
            $table->bigInteger('emd')->nullable();

            $table->bigInteger('tender_fee')->nullable();

            $table->bigInteger('processing_fee')->nullable();
                
            $table->tinyInteger('performance_guarantee_type')->nullable();

            $table->double('performance_guarantee', 10, 2)->nullable();

            $table->dateTime('pre_bid_meeting')->nullable();

            $table->tinyInteger('payment_terms')->nullable();

            $table->bigInteger('pay_and_collect')->nullable();
            $table->bigInteger('collect_and_pay')->nullable();
            $table->text('complete_clause')->nullable();

            $table->bigInteger('obligation_id')->nullable();

            $table->double('penalties', 10, 2)->nullable();
            $table->double('total_investments', 10, 2)->nullable();
                
            $table->dateTime('financial_opening_date')->nullable();
            $table->dateTime('technical_opening_date')->nullable();
            $table->string('assigned_to_group')->nullable();

            $table->bigInteger('hod_id')->default(0);

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
        Schema::dropIfExists('til_drafts');
    }
}