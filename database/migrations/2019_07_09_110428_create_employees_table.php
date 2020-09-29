<?php



use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;



class CreateEmployeesTable extends Migration

{

    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()

    {

        Schema::create('employees', function (Blueprint $table) {

            $table->bigIncrements('id');

            

            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');



            $table->unsignedBigInteger('creator_id');

            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');



            $table->string('employee_id')->comment('old employee code');  

            $table->string('salutation');

            $table->string('fullname');

            $table->string('first_name');

            $table->string('middle_name')->nullable();

            $table->string('last_name')->nullable();

            $table->string('personal_email')->nullable();

            $table->enum('attendance_type', ['Biometric','ESS'])->default('Biometric');

            $table->string('mobile_number');

            $table->string('referral_code')->nullable();



            $table->unsignedBigInteger('country_id');

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');



            $table->string('alternative_mobile_number')->nullable();



            $table->unsignedBigInteger('alt_country_id');

            $table->foreign('alt_country_id')->references('id')->on('countries')->onDelete('cascade');



            $table->string('experience_year_month');

            $table->enum('experience_status', ['0', '1'])->comment('0=Fresher, 1=Experienced');

            $table->date('birth_date')->nullable();

            $table->date('joining_date')->nullable();

            $table->string('marital_status');

            $table->date('marriage_date')->nullable();

            $table->string('spouse_name')->nullable();

            $table->string('spouse_working_status')->default('No');

            $table->string('spouse_company_name')->nullable();

            $table->integer('spouse_designation')->default(0);

            $table->string('spouse_contact_number')->nullable();

            $table->string('profile_picture')->nullable();

            $table->string('gender');



            $table->string('father_name')->nullable();

            $table->string('mother_name')->nullable();

            $table->string('registration_fees')->nullable();

            $table->string('application_number')->nullable();

            $table->date('relieve_date')->nullable();

            $table->date('rejoin_date')->nullable();

            $table->string('relieve_description')->nullable();

            $table->string('rejoin_description')->nullable();



            $table->string('nominee_type')->default('NA');

            $table->string('relation')->nullable();

            $table->string('nominee_name')->nullable();

            $table->string('insurance_company_name')->nullable();

            $table->string('cover_amount')->nullable();

            $table->string('type_of_insurance')->nullable();

            $table->date('insurance_expiry_date')->nullable();

            $table->enum('approval_status', ['0', '1'])->comment('0=Not Approved, 1=Approved');

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

        Schema::dropIfExists('employees');

    }

}

