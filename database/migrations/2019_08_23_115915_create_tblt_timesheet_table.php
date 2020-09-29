<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbltTimesheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblt_timesheet', function (Blueprint $table) {
            $table->bigIncrements('timesheetid');
            $table->decimal('punchingcode', 5, 0);
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->decimal('Tid', 5, 0)->nullable(); 
            $table->boolean('ispunched')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblt_timesheet');
    }
}
