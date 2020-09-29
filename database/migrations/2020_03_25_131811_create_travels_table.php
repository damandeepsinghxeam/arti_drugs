<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travels', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('project_id')->index('project_id');
            $table->unsignedBigInteger('til_id')->index('til_id');

            $table->enum('travel_for', ['1', '2', '3'])->comment('1 => Existing Clients, 2 => Future Clients, 3 => Others');

            $table->string('others');
            $table->string('travel_code');
            $table->string('travel_purpose');
            
            $table->tinyInteger('cover_under_policy')->default(0);
            $table->tinyInteger('stay')->default(0);
            $table->tinyInteger('other_financial_approval')->default(0);
            $table->tinyInteger('imprest_request')->default(0);

            $table->tinyInteger('travel_type')->default(1)->comment('1 => Local, 2 => National');

            $table->string('remarks')->nullable();

            $table->enum('status', ['new','discussion','hold','discarded','approved'])->comment('new, discussion, hold, discarded, approved');

            $table->tinyInteger('isactive')->default(1);
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
        Schema::dropIfExists('travels');
    }
}
