<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCloserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closer', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('jrf_level_one_screening_id');
            $table->foreign('jrf_level_one_screening_id')->references('id')->on('jrf_level_one_screenings')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('supervisor_id');

            $table->unsignedBigInteger('jrf_id');
            $table->foreign('jrf_id')->references('id')->on('jrfs')->onDelete('cascade');

            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('designation_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('report_id');

            $table->enum('quick_learner',['excellent','very_good','good','average'])->nullable()->comment('REPORTING MANAGER FEEDBACK');

            $table->enum('confid_lvl',['excellent','very_good','good','average'])->nullable();

            $table->enum('attitude',['excellent','very_good','good','average'])->nullable();

            $table->enum('team_work',['excellent','very_good','good','average'])->nullable();

            $table->enum('exec_skill',['excellent','very_good','good','average'])->nullable();

            $table->enum('result_orient',['excellent','very_good','good','average'])->nullable();

            $table->enum('attendence',['excellent','very_good','good','average'])->nullable();

            $table->string('closour_date')->nullable()->comment('JRF Closure Date');

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
        Schema::dropIfExists('closer');
    }
}
