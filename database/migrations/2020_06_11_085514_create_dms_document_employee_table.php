<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDmsDocumentEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dms_document_employee', function (Blueprint $table) {
            $table->unsignedBigInteger('dms_document_id');
            $table->foreign('dms_document_id')->references('id')->on('dms_documents')->onDelete('cascade');

            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dms_document_employee', function (Blueprint $table) {
            //
        });
    }
}
