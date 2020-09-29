<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('task_project_id');
            $table->foreign('task_project_id')->references('id')->on('task_projects')->onDelete('cascade');

            $table->string('title');
            $table->binary('description');
            $table->enum('priority', ['Low', 'Medium', 'High','Critical'])->default('Low');
            $table->date('due_date');
            $table->boolean('reminder_status')->default(0);
            $table->integer('reminder_days')->default(0);
            $table->boolean('reminder_notification')->default(0);
            $table->boolean('reminder_email')->default(0);
            $table->boolean('overdue_notification')->default(1);
            $table->enum('status', ['Completed','Reopened','Inprogress','Suspended','Unassigned','Archived','Open'])->default('Open');
            $table->boolean('isactive')->default(1);
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
        Schema::dropIfExists('tasks');
    }
}
