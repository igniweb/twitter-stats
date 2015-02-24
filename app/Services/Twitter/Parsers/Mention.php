<?php namespace App\Services\Twitter\Parsers;

class Mention {

    public function parse($status)
    {
        $mentions = [];

        if ( ! empty($status->entities->user_mentions))
        {
            foreach ($status->entities->user_mentions as $mention)
            {
                $mentions[] = mb_strtolower($mention->screen_name);
            }
        }

        return array_unique($mentions);
    }

}
