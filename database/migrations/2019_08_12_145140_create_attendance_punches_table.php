<?php



use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;



class CreateAttendancePunchesTable extends Migration

{

    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()

    {

        Schema::create('attendance_punches', function (Blueprint $table) {

            $table->bigIncrements('id');



            $table->unsignedBigInteger('attendance_id');

            $table->foreign('attendance_id')->references('id')->on('attendances')->onDelete('cascade');



            $table->string('on_time')->nullable();

            $table->bigInteger('punched_by')->default(0)->comment('0(machine), user_id(himself,verifier)');
            $table->enum('type', ['NA', 'Check-In', 'Check-Out'])->default('NA');

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

        Schema::dropIfExists('attendance_punches');

    }

}

