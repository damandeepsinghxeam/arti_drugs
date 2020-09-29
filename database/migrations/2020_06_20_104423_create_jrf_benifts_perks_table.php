<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJrfBeniftsPerksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jrf_benifts_perks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('jrf_id');
            $table->foreign('jrf_id')->references('id')->on('jrfs')->onDelete('cascade');

            $table->unsignedBigInteger('benifits_perks_id');
            $table->foreign('benifits_perks_id')->references('id')->on('benifits_perks')->onDelete('cascade');

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
        Schema::dropIfExists('jrf_benifts_perks');
    }
}
