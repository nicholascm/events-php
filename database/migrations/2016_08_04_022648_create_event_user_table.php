<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_user', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            //FK to user table
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')
              ->on('users')->onDelete('cascade');

            //FK to event table
            $table->integer('event_id');
            $table->foreign('event_id')->references('id')
              ->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event_user');
    }
}
