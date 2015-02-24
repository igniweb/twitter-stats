<?php namespace App\Services\Statistics;

use DB;

class Users {

    public function top($searchId, $count = 10)
    {
        return DB::table('tweets')
               ->select('tweets.user_name AS name')
               ->addSelect(DB::raw('COUNT(`tweets`.`id`) AS `occurences`'))
               ->join('search_tweet', 'search_tweet.tweet_id', '=', 'tweets.id')
               ->where('search_tweet.search_id', '=', $searchId)
               ->groupBy('tweets.user_name')
               ->orderBy('occurences', 'desc')
               ->take($count)
               ->get();
    }

}
