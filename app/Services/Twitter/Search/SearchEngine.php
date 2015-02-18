<?php namespace App\Services\Twitter\Search;

use InvalidArgumentException;
use App\Services\Twitter\Parsers\Tweet as TweetParser;
use Carbon\Carbon;
use Thujohn\Twitter\Twitter;

abstract class SearchEngine {

    protected $from;

    protected $to;

    protected $q;

    private $twitter;

    private $parser;

    private $maxId;

    public function __construct($from, $to)
    {
        if ($to < $from)
        {
            throw new InvalidArgumentException('End date must be greater than start date');
        }

        $this->from = $from;

        $this->to = $to;

        $this->twitter = new Twitter;

        $this->parser = new TweetParser;

        $this->maxId = null;
    }

    abstract public function q($q = null);

    public function search($q)
    {
        if (empty($q))
        {
            throw new InvalidArgumentException('Empty query string');
        }
        $this->q($q);

        return $this->process();
    }

    private function process()
    {
        $tweets = [];

        $continue = true;
        while ($continue)
        {
            $fetched = $this->fetch();

            if (empty($fetched))
            {
                $continue = false;
            }
            else
            {
                foreach ($fetched as $tweet)
                {
                    $publishedAt = Carbon::createFromFormat('Y-m-d H:i:s', $tweet['published_at']);
                    if ($publishedAt < $this->from)
                    {
                        $continue = false;
                    }
                    else
                    {
                        $tweets[] = $tweet;
                    }
                }
            }
        }

        return $tweets;
    }

    private function fetch()
    {
        $data = $this->twitter->query('search/tweets', 'GET', $this->queryParams());

        $this->maxId = $this->parseMaxId($data->search_metadata);

        return $this->parseStatuses($data->statuses);
    }

    private function queryParams()
    {
        $params = [
            'q'     => $this->q,
            'count' => 100
        ];

        if ( ! is_null($this->maxId))
        {
            $params['max_id'] = $this->maxId;
        }
        else
        {
            $params['until'] = $this->to->addDays(1)->format('Y-m-d');
        }

        return $params;
    }

    private function parseStatuses($statuses)
    {
        $tweets = [];

        if ( ! empty($statuses))
        {
            foreach ($statuses as $status)
            {
                if (empty($status->retweeted_status))
                {
                    $tweets[] = $this->parser->parse($status);
                }
            }
        }

        return $tweets;
    }

    private function parseMaxId($metadata)
    {
        if (isset($metadata->next_results))
        {
            parse_str(substr($metadata->next_results, 1), $data);
        }

        return ! empty($data['max_id']) ? $data['max_id'] : null;
    }

}
