<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pfs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('epf_percent');
            $table->string('epf_cutoff');
            $table->integer('restrict_emp')->default(0);
            $table->string('pension_fund');
            $table->string('epf_ab');
            $table->integer('employmentVerification')->default(0);
            $table->string('acc_no2');
            $table->string('acc_no21');
            $table->string('acc_no22');
            $table->date('effective_pf_dt');
            $table->enum('is_active',['1','0'])->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('pfs');
    }
}
