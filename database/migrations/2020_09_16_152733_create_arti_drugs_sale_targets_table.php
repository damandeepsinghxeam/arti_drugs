<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtiDrugsSaleTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arti_drugs_sale_targets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->integer('year');
            $table->integer('month');
            $table->integer('user_id');
            $table->string('employee_name');
            $table->integer('target');
            $table->integer('status');
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
        Schema::dropIfExists('arti_drugs_sale_targets');
    }
}
