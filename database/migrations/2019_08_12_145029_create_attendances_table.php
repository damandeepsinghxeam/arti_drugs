<?php



use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;



class CreateAttendancesTable extends Migration

{

    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()

    {

        Schema::create('attendances', function (Blueprint $table) {

            $table->bigIncrements('id');



            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');



            $table->date('on_date');

            $table->enum('status', ['Present', 'Absent', 'Week-Off', 'Holiday', 'Leave', 'Travel']);



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

        Schema::dropIfExists('attendances');

    }

}

