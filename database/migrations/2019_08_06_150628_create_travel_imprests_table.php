<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelImprestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_imprests', function (Blueprint $table) {
            $table->bigIncrements('id');
        
            $table->unsignedBigInteger('travel_approval_id');
            $table->foreign('travel_approval_id')->references('id')->on('travel_approvals')->onDelete('cascade');

            $table->string('remarks_by_applicant');
            $table->float('amount', 10,2);

            $table->enum('status', ['new', 'discussion', 'hold', 'discarded'])->default('new');
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
        Schema::dropIfExists('travel_imprests');
    }
}
