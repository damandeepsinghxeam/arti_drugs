<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('company_group_id');
            $table->foreign('company_group_id')->references('id')->on('company_groups')->onDelete('cascade');

            $table->enum('approval_status', ['0', '1'])->comment('0=Not Approved, 1=Approved');
            $table->string('address')->nullable();
            $table->string('name')->nullable();
            $table->string('pf_account_number')->nullable();
            $table->string('extension')->nullable();
            $table->string('dbf_file_code')->nullable();
            $table->string('phone_extension')->nullable();
            $table->string('phone')->nullable();
            $table->string('tan_number')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('responsible_person')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
