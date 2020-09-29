<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtiDrugsAchievedSaleTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arti_drugs_achieved_sale_targets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->integer('year');
            $table->integer('month');
            $table->integer('achieved_target');
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
        Schema::dropIfExists('arti_drugs_achieved_sale_targets');
    }
}
