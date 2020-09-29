<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBdTeamMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_team_members', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('bd_team_id');
            $table->foreign('bd_team_id')->references('id')->on('bd_teams')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->tinyInteger('team_role_id')->comment('1 => Executive, 2 => Manager')->default(1);
            $table->bigInteger('leads_counter')->default(0);
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
        Schema::dropIfExists('bd_team_members');
    }
}
