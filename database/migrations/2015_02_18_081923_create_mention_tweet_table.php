<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMentionTweetTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mention_tweet', function(Blueprint $table)
        {
            $table->integer('mention_id')->unsigned();
            $table->integer('tweet_id')->unsigned();

            $table->primary(['mention_id', 'tweet_id']);
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
        Schema::drop('mention_tweet');
    }

}
