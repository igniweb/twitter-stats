<?php namespace App\Services\Twitter\Parsers;

class Tweet {

    protected $userParser;

    protected $mediaParser;

    protected $hashtagParser;

    protected $mentionParser;

    public function __construct()
    {
        $this->userParser = new User;

        $this->mediaParser = new Media;

        $this->hashtagParser = new Hashtag;

        $this->mentionParser = new Mention;
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
            'hashtags'     => $this->hashtagParser->parse($status),
            'mentions'     => $this->mentionParser->parse($status),
        ];
    }

}
