<?php namespace App\Http\Controllers;

use DB;
use App\Hashtag;
use App\Tweet;

class HomeController extends Controller {

    public function index()
    {
        $tweets = Tweet::all();

        $committed = $this->committed($tweets);

        $hashtags = $this->hashtags();

        return view('welcome', compact('tweets', 'committed', 'hashtags'));
    }

    private function committed($tweets, $count = 10)
    {
        $committed = [];

        $pivots = [];
        $indexed = [];
        foreach ($tweets as $tweet)
        {
            $commitments = $tweet['retweets'] + $tweet['favorites'];

            $pivots[$tweet['id']] = $commitments;
            $indexed[$tweet['id']] = $tweet->toArray();
        }

        arsort($pivots);
        $pivots = array_slice($pivots, 0, $count, true);

        foreach ($pivots as $tweetId => $commitments)
        {
            $committed[] = $indexed[$tweetId] + ['commitments' => $commitments];
        }

        return $committed;
    }

    private function hashtags($count = 20)
    {
        return DB::table('hashtag_tweet')
               ->select('hashtags.label', DB::raw('COUNT(`hashtag_tweet`.`hashtag_id`) AS `occurences`'))
               ->join('hashtags', 'hashtag_tweet.hashtag_id', '=', 'hashtags.id')
               ->groupBy('hashtag_tweet.hashtag_id')
               ->orderBy('occurences', 'desc')
               ->take($count)
               ->get();
    }

}
