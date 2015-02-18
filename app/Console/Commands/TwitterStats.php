<?php namespace App\Console\Commands;

use InvalidArgumentException;
use App\Search;
use App\Services\Statistics\Hashtags;
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

        $searchId = intval($this->argument('search_id'));
        $this->search = Search::find($searchId);
        if (empty($this->search))
        {
            throw new InvalidArgumentException('Unknown search ID #' . $searchId);
        }

        $this->computeHashtags($searchId, 10);
    }

    protected function getOptions()
    {
        return [
            ['debug', null, InputOption::VALUE_NONE, 'Turn on debug mode', null],
        ];
    }

    protected function getArguments()
    {
        return [
            ['search_id', InputArgument::REQUIRED, 'Search ID to compute', null],
        ];
    }

    private function computeHashtags($searchId, $count)
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
    }

}
