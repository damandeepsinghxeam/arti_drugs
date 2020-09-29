<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmploymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employment_histories', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->date('employment_from');
            $table->date('employment_to');
            $table->string('organization_name');
            $table->string('organization_phone')->nullable();

            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

            $table->string('organization_phone_stdcode')->nullable();
            $table->string('organization_email')->nullable();
            $table->string('organization_website')->nullable();
            $table->binary('responsibilities')->nullable();
            $table->string('report_to_position')->nullable();
            $table->string('salary_per_month')->nullable();
            $table->string('perks')->nullable();
            $table->binary('reason_for_leaving')->nullable();
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
        Schema::dropIfExists('employment_histories');
    }
}
