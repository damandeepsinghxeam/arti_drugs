<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('adhaar')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('uan_number')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('esi_number')->nullable();
            $table->string('dispensary')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('pf_number_department')->nullable();
            
            $table->unsignedBigInteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
            
            $table->enum('contract_signed', ['0', '1'])->comment('0=No, 1=Yes');
            $table->date('contract_signed_date')->nullable();
            $table->enum('employment_verification', ['0', '1'])->comment('0=No, 1=Yes');
            $table->enum('address_verification', ['0', '1'])->comment('0=No, 1=Yes');
            $table->enum('police_verification', ['0', '1'])->comment('0=No, 1=Yes');
            $table->binary('remarks')->nullable();
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
        Schema::dropIfExists('employee_accounts');
    }
}
