<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrears', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('year');
            $table->string('month');
            $table->integer('project_id');
            $table->integer('department_id');
            $table->string('user_id');
            $table->decimal('amount', 24,2);
            $table->string('reason');
            $table->text('remark');
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
        Schema::dropIfExists('arrears');
    }
}
