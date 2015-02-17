<?php namespace App\Services\Twitter\Search;

class Hashtags extends SearchEngine {

    public function q($q = null)
    {
        if ( ! is_null($q))
        {
            $this->q = '#' . $q;
        }

        return $this->q;
    }

}
