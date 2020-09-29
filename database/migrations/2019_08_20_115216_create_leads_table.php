<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
    */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id')->comment('lead owner id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->tinyInteger('business_type')->comment('1 => govt business, 2 => non govt business, 3 => international business');

            $table->unsignedBigInteger('source_id');
            $table->foreign('source_id')->references('id')->on('lead_sources')->onDelete('cascade');
            $table->text('other_sources')->nullable();
            
            $table->string('file_name')->nullable();
            
            $table->string('name_of_prospect')->nullable();
            $table->text('address_location')->nullable();
            
            $table->unsignedBigInteger('industry_id')->nullable();
            $table->foreign('industry_id')->references('id')->on('lead_industries')->onDelete('cascade');

            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('lead_units')->onDelete('cascade');

            $table->string('service_ids', 255)->nullable();
            $table->text('service_description');

            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_no')->nullable();
            $table->string('alternate_contact_no')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('is_completed')->default(0);

            $table->bigInteger('executive_id')->default(0);

            $table->dateTime('due_date')->nullable();
            $table->tinyInteger('priority')->comment('0 => Low, 1 => Normal, 2 => Critical');

            $table->tinyInteger('status')->comment('1 => New, 2 => Open, 3 => Complete, 4 => Rejected by Hod, 5 => Closed, 6 => Abandoned');

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
        Schema::dropIfExists('leads');
    }
}
