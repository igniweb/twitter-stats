<?php namespace App\Console\Commands;

use InvalidArgumentException, StdClass;
use App\Search;
use App\Tweet;
use App\Services\Statistics\Hashtags;
use App\Services\Statistics\Tweets;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TwitterStats extends Command {

    protected $name = 'twitter:stats';

    protected $description = 'Compute statistics for a given search';

    private $debug;

    private $search;

    public function handle()
    {
        $this->debug = $this->option('debug');
        $force = $this->option('force');

        $searchId = intval($this->argument('search_id'));
        $this->search = Search::find($searchId);
        if (empty($this->search))
        {
            throw new InvalidArgumentException('Unknown search ID #' . $searchId);
        }

        if ($force or empty($this->search->stats))
        {
            $this->compute($searchId);
        }
    }

    protected function getOptions()
    {
        return [
            ['debug', null, InputOption::VALUE_NONE, 'Turn on debug mode', null],
            ['force', null, InputOption::VALUE_NONE, 'Force new computation and persistence', null],
        ];
    }

    protected function getArguments()
    {
        return [
            ['search_id', InputArgument::REQUIRED, 'Search ID to compute', null],
        ];
    }

    private function compute($searchId)
    {
        $stats = new StdClass;

        $stats->topHashtags = $this->computeTopHashtags($searchId, 10);
        $stats->committedTweets = $this->computeCommittedTweets($searchId, 10);

        $this->search->stats = json_encode($stats);
        $this->search->save();
    }

    private function computeTopHashtags($searchId, $count)
    {
        if ($this->debug)
        {
            $this->line('Compute statistics about hashtags for "' . $this->search->q . '"');
        }

        $hashtagComputer = new Hashtags;
        $topHashtags = $hashtagComputer->top($searchId, $count);

        if ($this->debug)
        {
            $this->comment('Top ' . count($topHashtags) . ' hashtags');
            foreach ($topHashtags as $topHashtag)
            {
                $this->line($topHashtag->label . ' (' . $topHashtag->occurences . ')');
            }
        }

        return $topHashtags;
    }

    private function computeCommittedTweets($searchId, $count)
    {
        if ($this->debug)
        {
            $this->line('Compute statistics about tweets for "' . $this->search->q . '"');
        }

        $tweetComputer = new Tweets;
        $committedTweets = $tweetComputer->commitments($searchId, $count);

        if ($this->debug)
        {
            $this->comment('Top ' . count($committedTweets) . ' committed tweets');

            foreach ($committedTweets as $committedTweetCount => $committedTweetId)
            {
                $tweet = Tweet::find($committedTweetId);
                $this->line($tweet->user_name . ': ' . $tweet->text . ' (' . $committedTweetCount . ')');
            }
        }

        return $committedTweets;
    }

}
