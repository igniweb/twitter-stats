<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTweetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tweets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('twitter_id');
			$table->string('url');
			$table->string('text', 140);
			$table->string('user_id');
			$table->string('user_name');
			$table->string('user_avatar');
			$table->string('media_normal');
			$table->string('media_small');
			$table->string('media_type');
			$table->integer('retweets')->unsigned();
			$table->integer('favorites')->unsigned();
			$table->timestamp('published_at');
			$table->timestamps();

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
		Schema::drop('tweets');
	}

}
