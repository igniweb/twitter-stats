<?php namespace App\Services\Statistics;

use DB;

class Mentions {

    public function top($searchId, $count = 10)
    {
        return DB::table('mentions')
               ->select('mentions.name')
               ->addSelect(DB::raw('COUNT(`mention_tweet`.`mention_id`) AS `occurences`'))
               ->join('mention_tweet', 'mentions.id', '=', 'mention_tweet.mention_id')
               ->join('search_tweet', 'search_tweet.tweet_id', '=', 'mention_tweet.tweet_id')
               ->where('search_tweet.search_id', '=', $searchId)
               ->groupBy('mention_tweet.mention_id')
               ->orderBy('occurences', 'desc')
               ->take($count)
               ->get();
    }

}
