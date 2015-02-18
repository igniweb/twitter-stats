<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Mention extends Model {

    protected $table = 'mentions';

    public $timestamps = false;

    protected $fillable = ['name'];

    public function tweets()
    {
        return $this->belongsToMany('App\Tweet', 'mention_tweet', 'mention_id', 'tweet_id');
    }

}
