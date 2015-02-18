<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model {

    protected $table = 'searches';

    public $timestamps = false;

    protected $fillable = ['q', 'from', 'to', 'stats', 'done_at'];

    protected $dates = ['from', 'to', 'done_at'];

    public function tweets()
    {
        return $this->belongsToMany('App\Tweet', 'search_tweet', 'search_id', 'tweet_id');
    }

}
