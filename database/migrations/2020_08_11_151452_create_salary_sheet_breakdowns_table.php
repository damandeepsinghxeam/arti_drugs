<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalarySheetBreakdownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_sheet_breakdowns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('salary_sheet_id');
            $table->foreign('salary_sheet_id')->references('id')->on('salary_sheets')->onDelete('cascade');

            $table->unsignedBigInteger('salary_head_id');
            $table->foreign('salary_head_id')->references('id')->on('salary_heads')->onDelete('cascade');

            $table->string('salary_head_name');
            $table->enum('salary_head_type', ['earning', 'deduction'])->comment('earning or deductions');
            $table->string('value');

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
        Schema::dropIfExists('salary_sheet_breakdowns');
    }
}
