<?php namespace App\Services\Twitter\Parsers;

class Hashtag {

    public function parse($status)
    {
        $hashtags = [];

        if ( ! empty($status->entities->hashtags))
        {
            foreach ($status->entities->hashtags as $hashtag)
            {
                $hashtags[] = $hashtag->text;
            }
        }

        return array_unique($hashtags);
    }

}
