<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDmsDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dms_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dms_category_id');
            $table->foreign('dms_category_id')->references('id')->on('dms_categories')->onDelete('cascade');
            $table->string('name');
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
        Schema::dropIfExists('dms_documents');
    }
}
