<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model {

    protected $table = 'searches';

    public $timestamps = true;

    protected $fillable = ['q', 'from', 'to', 'stats'];

    protected $dates = ['from', 'to', 'created_at', 'updated_at'];

    public function tweets()
    {
        return $this->belongsToMany('App\Tweet', 'search_tweet', 'search_id', 'tweet_id');
    }

}
