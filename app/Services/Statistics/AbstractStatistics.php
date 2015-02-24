<?php namespace App\Services\Statistics;

use DB;

abstract class AbstractStatistics {

    protected function tweetIds($searchId)
    {
        $tweets = DB::table('search_tweet')->select('tweet_id')->where('search_id', '=', $searchId)->get();

        return array_pluck($tweets, 'tweet_id');
    }

}
