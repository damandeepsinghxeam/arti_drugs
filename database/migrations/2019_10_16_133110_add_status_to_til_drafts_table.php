<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToTilDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('til_drafts', function (Blueprint $table) {
            $table->tinyInteger('status')->after('isactive')->comment('1 => New, 2 => Open, 3 => Complete, 4 => Rejected by Hod, 5 => Closed, 6 => Abandoned');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('til_drafts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
