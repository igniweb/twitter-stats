<?php namespace App\Services\Twitter\Search;

use InvalidArgumentException;
use Thujohn\Twitter\Twitter;

abstract class SearchEngine {

    protected $from;

    protected $to;

    protected $q;

    private $twitter;

    public function __construct($from, $to)
    {
        if ($to < $from)
        {
            throw new InvalidArgumentException('End date must be greater than start date');
        }

        $this->from = $from;

        $this->to = $to;

        $this->twitter = new Twitter;
    }

    abstract public function q($q = null);

    public function search($q)
    {
        if (empty($q))
        {
            throw new InvalidArgumentException('Empty query string');
        }

        $this->q($q);

        // Fetch tweets

        // Save search results
    }

    private function fetchTweets()
    {
        
    }

}
