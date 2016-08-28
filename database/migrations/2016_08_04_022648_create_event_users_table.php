<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            //FK to user table
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')
              ->on('users');

            //FK to event table
            $table->integer('event_id');
            $table->foreign('event_id')->references('id')
              ->on('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event_users');
    }
}
