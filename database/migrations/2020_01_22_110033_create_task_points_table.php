<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('priority');
            $table->timestamp('effective_from')->useCurrent();
            $table->unsignedBigInteger('max_limit')->default(1);
            $table->unsignedBigInteger('weight')->default(1);
            $table->unsignedBigInteger('danger_zone1_points')->default(1)->comment('% of weight');
            $table->unsignedBigInteger('danger_zone1_days')->default(1)->comment('after due date');
            $table->unsignedBigInteger('danger_zone2_points')->default(1)->comment('% of weight');
            $table->unsignedBigInteger('danger_zone2_days')->default(1)->comment('after due date');
            $table->unsignedBigInteger('danger_zone3_points')->default(0)->comment('% of weight');
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
        Schema::dropIfExists('task_points');
    }
}
