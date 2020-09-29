<?php



use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;



class CreateAppliedLeavesTable extends Migration

{

    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()

    {

        Schema::create('applied_leaves', function (Blueprint $table) {

            $table->bigIncrements('id');



            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');



            $table->unsignedBigInteger('leave_type_id');

            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');



            $table->binary('reason');

            $table->string('number_of_days');

            $table->string('excluded_dates')->nullable();



            $table->unsignedBigInteger('country_id');

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');



            $table->unsignedBigInteger('state_id');

            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');



            $table->unsignedBigInteger('city_id');

            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');



            $table->date('from_date');

            $table->date('to_date');

            $table->string('from_time')->nullable();

            $table->string('to_time')->nullable();

            $table->string('mobile_number');



            $table->unsignedBigInteger('mobile_country_id');

            $table->foreign('mobile_country_id')->references('id')->on('countries')->onDelete('cascade');



            $table->enum('secondary_leave_type', ['Short', 'Half', 'Full']);

            $table->string('leave_half')->nullable();

            $table->binary('tasks')->nullable();

            $table->enum('final_status', ['0', '1']);

            $table->boolean('isactive')->default(1);
            // $table->enum('generated_by', ['User', 'System'])->default('User');
            

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

        Schema::dropIfExists('applied_leaves');

    }

}

