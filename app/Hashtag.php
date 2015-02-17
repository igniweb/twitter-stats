<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model {

    protected $table = 'hashtags';

    public $timestamps = false;

    protected $fillable = ['label'];

    public function tweets()
    {
        return $this->belongsToMany('App\Tweet', 'hashtag_tweet', 'hashtag_id', 'tweet_id');
    }

}
