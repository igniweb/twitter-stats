<?php namespace App\Services\Statistics;

use DB;

class Tweets {

    public function commitments($searchId, $count = 10)
    {
        $commitments = [];

        $tweets = DB::table('tweets')->select('id', 'retweets', 'favorites')->whereIn('id', $this->tweetIds($searchId))->get();
        foreach ($tweets as $tweet)
        {
            $tweetCommitments = ($tweet->retweets + $tweet->favorites);

            if (count($commitments) < $count)
            {
                $commitments[$tweetCommitments] = $tweet->id;
            }
            else
            {
                $committedCounts = array_keys($commitments);
                $leastCommittedCount = array_pop($committedCounts);
                $leastCommittedTweetId = array_pop($commitments);

                if ($tweetCommitments > $leastCommittedCount)
                {
                    $commitments[$tweetCommitments] = $tweet->id;
                }
                else
                {
                    $commitments[$leastCommittedCount] = $leastCommittedTweetId;
                }
            }

            krsort($commitments);
        }

        return $commitments;
    }

    private function tweetIds($searchId)
    {
        $tweets = DB::table('search_tweet')->select('tweet_id')->where('search_id', '=', $searchId)->get();

        return array_pluck($tweets, 'tweet_id');
    }

}
