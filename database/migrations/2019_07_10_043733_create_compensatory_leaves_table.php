<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompensatoryLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compensatory_leaves', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('leave_type_id');
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');

            $table->date('from_date');   
            $table->date('to_date');   
            $table->integer('number_of_days')->default(1);   
            $table->binary('description')->nullable();  

            $table->unsignedBigInteger('applied_leave_id')->default(0);    
            
            $table->enum('hr_verification', ['0', '1'])->comment('1=verified, 0=not verified');
            $table->enum('hod_verification', ['0', '1'])->comment('1=verified, 0=not verified');
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
        Schema::dropIfExists('compensatory_leaves');
    }
}
