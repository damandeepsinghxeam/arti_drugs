<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelAuthoritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Travel pre approval and travel claim has only 1 diff i.e auditor comes in between MD Sir(Approver) and Verifier (HOD)
        Schema::create('travel_authorities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('manager_id');
            $table->foreign('manager_id')->references('id')->on('users')->onDelete('cascade');

            $table->float('max_travel_approval', 7,2)->default(0)->comment('in case of approver only');
            $table->smallInteger('priority')->default(0)->comment('1=recommender, 2=approver');
            
            $table->enum('authority_type', ['pre_approval', 'claim_approval'])->comment('pre_approval', 'claim_approval');

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
        Schema::dropIfExists('travel_authorities');
    }
}
