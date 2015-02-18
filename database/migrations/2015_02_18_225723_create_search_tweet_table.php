<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchTweetTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_tweet', function(Blueprint $table)
        {
            $table->integer('search_id')->unsigned();
            $table->integer('tweet_id')->unsigned();

            $table->primary(['search_id', 'tweet_id']);
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('search_tweet');
    }

}
