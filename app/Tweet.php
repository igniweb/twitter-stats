<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model {

    protected $table = 'tweets';

    public $timestamps = true;

    protected $fillable = ['twitter_id', 'url', 'text', 'user_id', 'user_account', 'user_name', 'user_avatar', 'media_normal', 'media_small', 'media_type', 'retweets', 'favorites', 'published_at'];

    protected $dates = ['published_at', 'created_at', 'updated_at'];

    public function hashtags()
    {
        return $this->belongsToMany('App\Hashtag', 'hashtag_tweet', 'tweet_id', 'hashtag_id');
    }

    public function mentions()
    {
        return $this->belongsToMany('App\Mention', 'mention_tweet', 'tweet_id', 'mention_id');
    }

}
