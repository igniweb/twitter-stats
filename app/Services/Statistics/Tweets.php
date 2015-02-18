<?php namespace App\Services\Statistics;

use DB;

class Tweets {

    public function commitments($searchId, $count = 10)
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

}
