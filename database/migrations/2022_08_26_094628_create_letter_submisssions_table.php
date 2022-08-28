<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLetterSubmisssionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_submissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('religion');
            $table->boolean('gender')->default(false);
            $table->string('address');
            $table->longText('response');
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('type_letters')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('letter_submisssions');
    }
}
