<?php namespace App\Services\Statistics;

use DB;

class Hashtags {

    public function top($searchId, $count = 10)
    {
        return DB::table('hashtags')
               ->select('hashtags.label')
               ->addSelect(DB::raw('COUNT(`hashtag_tweet`.`hashtag_id`) AS `occurences`'))
               ->join('hashtag_tweet', 'hashtags.id', '=', 'hashtag_tweet.hashtag_id')
               ->join('search_tweet', 'search_tweet.tweet_id', '=', 'hashtag_tweet.tweet_id')
               ->where('search_tweet.search_id', '=', $searchId)
               ->groupBy('hashtag_tweet.hashtag_id')
               ->orderBy('occurences', 'desc')
               ->take($count)
               ->get();
    }

}
