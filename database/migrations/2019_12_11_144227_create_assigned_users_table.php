<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigned_users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->morphs('assignable', 'assignable_morpf_key');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->boolean('type')->default(1)->comment('1=> users, 2=> managers, 3=> hod');
            
            $table->dateTime('wef')->comment('with effect from date')->nullable();
            $table->dateTime('wet')->comment('with effect to date')->nullable();
            $table->boolean('is_active')->default(0)->nullable();

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
        Schema::dropIfExists('assigned_users');
    }
}
