<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalarySheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_sheets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('year');
            $table->string('month');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('designation');
            $table->string('department');
            $table->string('total_month_days');
            $table->string('paid_days');
            $table->string('unpaid_days');
            $table->decimal('salary', 24, 2);
            $table->decimal('gross_salary', 24,2);
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
        Schema::dropIfExists('salary_sheets');
    }
}
