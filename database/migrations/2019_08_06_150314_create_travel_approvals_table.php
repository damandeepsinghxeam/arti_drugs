<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('travel_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('date_from');
            $table->integer('approved_by')->default(0);
            $table->date('date_to');
            $table->string('purpose');
            $table->boolean('isclient')->default(1);

            
            $table->boolean('under_policy')->default(0);
            $table->enum('status', ['new', 'discussion', 'hold', 'discarded', 'approved'])->default('new');
            $table->string('remarks')->nullable();
            $table->boolean('isactive')->default(1)->comment('0 for deleted records and 1 for active records');
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
        Schema::dropIfExists('travel_approvals');
    }
}
