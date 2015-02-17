<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHashtagTweetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hashtag_tweet', function(Blueprint $table)
		{
			$table->integer('hashtag_id')->unsigned();
			$table->integer('tweet_id')->unsigned();

			$table->primary(['hashtag_id', 'tweet_id']);
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
		Schema::drop('hashtag_tweet');
	}

}
