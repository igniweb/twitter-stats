<?php namespace App\Console\Commands;

use DB;
use App\Hashtag;
use App\Mention;
use App\Search;
use App\Tweet;
use App\Services\Twitter\SearchEngine;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TwitterFetch extends Command {

    protected $name = 'twitter:fetch';

    protected $description = 'Fetch tweets, hashtags and mentions for queried word and given dates';

    public function handle()
    {
        $q = trim($this->argument('q'));
        $from = $this->option('from');
        $to = $this->option('to');
        $debug = $this->option('debug');

        $from = is_string($from) ? Carbon::createFromFormat('Y-m-d', $from)->setTime(0, 0, 0) : $from;
        $to = is_string($to) ? Carbon::createFromFormat('Y-m-d', $to)->setTime(0, 0, 0) : $to;

        if ($debug)
        {
            $this->line('Search for "' . $q . '" from ' . $from->format('Y-m-d') . ' to ' . $to->format('Y-m-d'));
        }

        $searchFrom = $from->format('Y-m-d H:i:s');
        $searchTo = $to->format('Y-m-d H:i:s');
        $search = Search::where('q', '=', $q)->where('from', '=', $searchFrom)->where('to', '=', $searchTo)->first();
        if (empty($search))
        {
            $searchEngine = new SearchEngine($debug);
            $tweets = $searchEngine->search($q, $from, $to);

            if ($debug)
            {
                $this->comment('Found ' . count($tweets) . ' tweets');
            }

            $search = Search::create([
                'q'       => $q,
                'from'    => $searchFrom,
                'to'      => $searchTo,
                'done_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            $this->persist($tweets, $search->id);
        }
        else
        {
            if ($debug)
            {
                $this->comment('Found ' . count($search->tweets) . ' tweets');
            }
        }
    }

    protected function getOptions()
    {
        return [
            ['from', null, InputOption::VALUE_OPTIONAL, 'Start date to consider (format yyyy-mm-dd)', Carbon::yesterday()->setTime(0, 0, 0)],
            ['to', null, InputOption::VALUE_OPTIONAL, 'End date to consider (format yyyy-mm-dd)', Carbon::now()->setTime(0, 0, 0)],
            ['debug', null, InputOption::VALUE_NONE, 'Turn on debug mode', null],
        ];
    }

    protected function getArguments()
    {
        return [
            ['q', InputArgument::REQUIRED, 'Queried word (search will perform on #q and @q)', null],
        ];
    }

    private function persist($tweets, $searchId)
    {
        foreach ($tweets as $tweet)
        {
            $hashtags = $tweet['hashtags'];
            $mentions = $tweet['mentions'];
            unset($tweet['hashtags'], $tweet['mentions']);

            $dbTweet = $this->saveTweet($tweet);
            $this->saveHashtags($hashtags, $dbTweet->id);
            $this->saveMentions($mentions, $dbTweet->id);

            DB::table('search_tweet')->insert([
                'search_id' => $searchId,
                'tweet_id'  => $dbTweet->id,
            ]);
        }
    }

    private function saveTweet($tweet)
    {
        $dbTweet = Tweet::where('twitter_id', '=', $tweet['twitter_id'])->first();

        if (empty($dbTweet))
        {
            $dbTweet = Tweet::create($tweet);
        }
        else
        {
            $dbTweet->retweets  = $tweet['retweets'];
            $dbTweet->favorites = $tweet['favorites'];
            $dbTweet->save();
        }

        return $dbTweet;
    }

    private function saveHashtags($hashtags, $tweetId)
    {
        DB::table('hashtag_tweet')->where('tweet_id', '=', $tweetId)->delete();

        foreach ($hashtags as $hashtag)
        {
            $dbHashtag = Hashtag::where('label', '=', $hashtag)->first();
            if (empty($dbHashtag))
            {
                $dbHashtag = Hashtag::create(['label' => $hashtag]);
            }

            DB::table('hashtag_tweet')->insert([
                'hashtag_id' => $dbHashtag->id,
                'tweet_id'   => $tweetId,
            ]);
        }
    }

    private function saveMentions($mentions, $tweetId)
    {
        DB::table('mention_tweet')->where('tweet_id', '=', $tweetId)->delete();

        foreach ($mentions as $mention)
        {
            $dbMention = Mention::where('name', '=', $mention)->first();
            if (empty($dbMention))
            {
                $dbMention = Mention::create(['name' => $mention]);
            }

            DB::table('mention_tweet')->insert([
                'mention_id' => $dbMention->id,
                'tweet_id'   => $tweetId,
            ]);
        }
    }

}
