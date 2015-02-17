<?php namespace App\Console\Commands;

use App\Services\Twitter\Search\Hashtags;
use App\Services\Twitter\Search\Mentions;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TwitterFetch extends Command {

	protected $name = 'twitter:fetch';

	protected $description = 'Fetch tweets, hashtags and mentions for queried word and given dates';

	public function handle()
	{
		$q = $this->argument('q');
		$from = $this->option('from');
		$to = $this->option('to');
		$debug = $this->option('debug');

		$from = is_string($from) ? Carbon::createFromFormat('Y-m-d', $from) : $from;
		$to = is_string($to) ? Carbon::createFromFormat('Y-m-d', $to) : $to;

		$hashtagsSearchEngine = new Hashtags($from, $to);
		$hashtagsSearchEngine->search($q);
	}

	protected function getOptions()
    {
        return [
            ['from', null, InputOption::VALUE_OPTIONAL, 'Start date to consider (format yyyy-mm-dd)', Carbon::yesterday()],
            ['to', null, InputOption::VALUE_OPTIONAL, 'End date to consider (format yyyy-mm-dd)', Carbon::now()],
            ['debug', null, InputOption::VALUE_NONE, 'Turn on debug mode', null],
        ];
    }

    protected function getArguments()
    {
        return [
            ['q', InputArgument::REQUIRED, 'Queried word (search will perform on #q and @q)', null],
        ];
    }

}
