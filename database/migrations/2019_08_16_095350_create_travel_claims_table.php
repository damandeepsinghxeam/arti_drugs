<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_claims', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('travel_approval_id');
            $table->foreign('travel_approval_id')->references('id')->on('travel_approvals')->onDelete('cascade');

            $table->string('bank');
            $table->string('account_no');
            $table->string('ifsc');
            $table->string('project');
            $table->string('designation');
            $table->boolean('ispaid')->default(0);
            $table->string('utr')->nullable();
            $table->string('eligible_conveyance');
            $table->float('eligible_stay_amount', 7,2);
            $table->float('approved_amount', 7,2);
            $table->float('imprest_taken', 7,2);
            $table->float('balance_amount', 7,2);
            $table->enum('status', ['new', 'back', 'paid'])->default('new');
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
        Schema::dropIfExists('travel_claims');
    }
}
