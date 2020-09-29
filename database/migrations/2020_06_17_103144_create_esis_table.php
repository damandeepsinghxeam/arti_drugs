<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('esis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_percent');
            $table->string('employer_percent');
            $table->string('cutoff');
            $table->date('effective_esi_dt');
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
        Schema::dropIfExists('esis');
    }
}
