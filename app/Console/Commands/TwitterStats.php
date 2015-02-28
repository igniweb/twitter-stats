<?php namespace App\Console\Commands;

use InvalidArgumentException, StdClass;
use App\Search;
use App\Tweet;
use App\Services\Statistics\Hashtags;
use App\Services\Statistics\Mentions;
use App\Services\Statistics\Tweets;
use App\Services\Statistics\Users;
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

        $stats->topUsers = $this->computeTopUsers($searchId, 10);
        $stats->topHashtags = $this->computeTopHashtags($searchId, 10);
        $stats->topMentions = $this->computeTopMentions($searchId, 10);
        $stats->committedTweets = $this->computeCommittedTweets($searchId, 10);
        $stats->tweetsDistributionPerHour = $this->computeTweetsDistributionPerHour($searchId);

        $this->search->stats = json_encode($stats);
        $this->search->save();
    }

    private function computeTopUsers($searchId, $count)
    {
        if ($this->debug)
        {
            $this->line('Compute statistics about top users for "' . $this->search->q . '"');
        }

        $userComputer = new Users;
        $topUsers = $userComputer->top($searchId, $count);

        if ($this->debug)
        {
            $this->comment('Top ' . count($topUsers) . ' users');
            foreach ($topUsers as $topUser)
            {
                $this->line($topUser->name . ' (' . $topUser->occurences . ')');
            }
        }

        return $topUsers;
    }

    private function computeTopHashtags($searchId, $count)
    {
        if ($this->debug)
        {
            $this->line('Compute statistics about top hashtags for "' . $this->search->q . '"');
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

    private function computeTopMentions($searchId, $count)
    {
        if ($this->debug)
        {
            $this->line('Compute statistics about top mentions for "' . $this->search->q . '"');
        }

        $mentionComputer = new Mentions;
        $topMentions = $mentionComputer->top($searchId, $count);

        if ($this->debug)
        {
            $this->comment('Top ' . count($topMentions) . ' mentions');
            foreach ($topMentions as $topMention)
            {
                $this->line($topMention->name . ' (' . $topMention->occurences . ')');
            }
        }

        return $topMentions;
    }

    private function computeCommittedTweets($searchId, $count)
    {
        if ($this->debug)
        {
            $this->line('Compute statistics about committed tweets for "' . $this->search->q . '"');
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

    private function computeTweetsDistributionPerHour($searchId)
    {
        if ($this->debug)
        {
            $this->line('Compute statistics about tweets distribution per hour for "' . $this->search->q . '"');
        }

        $tweetComputer = new Tweets;
        $tweetsDistributionPerHour = $tweetComputer->distributionPerHour($searchId);

        if ($this->debug)
        {
            $this->comment('Tweets distribution per hour');
            print_r($tweetsDistributionPerHour);
        }

        return $tweetsDistributionPerHour;
    }

}
