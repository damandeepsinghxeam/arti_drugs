<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLwfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lwfs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('state_id');
            $table->string('tenure');
            $table->string('min_salary');
            $table->string('max_salary');
            $table->string('employee_share');
            $table->string('employer_share');
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
        Schema::dropIfExists('lwfs');
    }
}
