<?php namespace App\Services\Twitter\Parsers;

class Tweet {

    public function __construct()
    {
        $this->userParser = new User;

        $this->mediaParser = new Media;
    }

    public function parse($status)
    {
        $user = $this->userParser->parse($status);
        $media = $this->mediaParser->parse($status);

        return [
            'twitter_id'   => $status->id_str,
            'url'          => 'https://twitter.com/' . $status->user->id_str . '/status/' . $status->id_str,
            'text'         => $status->text,
            'user_id'      => $user['id'],
            'user_account' => $user['account'],
            'user_name'    => $user['name'],
            'user_avatar'  => $user['avatar'],
            'media_normal' => $media['normal'],
            'media_small'  => $media['small'],
            'media_type'   => $media['type'],
            'retweets'     => intval($status->retweet_count),
            'favorites'    => intval($status->favorite_count),
            'published_at' => date('Y-m-d H:i:s', strtotime($status->created_at)),
            'hashtags'     => $this->hashtags($status),
            'mentions'     => $this->mentions($status),
        ];
    }

    private function hashtags($status)
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

    private function mentions($status)
    {
        $mentions = [];

        if ( ! empty($status->entities->user_mentions))
        {
            foreach ($status->entities->user_mentions as $mention)
            {
                $mentions[] = $mention->screen_name;
            }
        }

        return array_unique($mentions);
    }

}