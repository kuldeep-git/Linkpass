<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Content;
use App\ContentRatingVote;
use App\User;
use Auth;

class ContentRating extends Authenticatable
{
    protected $table = 'content_ratings';

    protected $fillable = [
        'content_id', 'user_id', 'title', 'rating'
    ];

    protected $appends = ['ratings_up_count', 'ratings_down_count', 'is_up_voted_ratings', 'is_down_voted_ratings'];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany('App\ContentRatingVote', 'rating_id','id')->orderBy('id', 'desc');
    }

    public function getRatingsUpCountAttribute()
    {
        return \App\ContentRatingVote::where('rating_id', $this->id)->where('vote', 1)->count();
    }

    public function getRatingsDownCountAttribute()
    {
        return \App\ContentRatingVote::where('rating_id', $this->id)->where('vote', 0)->count();
    }

    public function getIsUpVotedRatingsAttribute()
    {
        return \App\ContentRatingVote::where('rating_id', $this->id)->where('vote', 1)->where('user_id', isset(Auth::user()->id) ? Auth::user()->id : 'N/A')->count();
    }

    public function getIsDownVotedRatingsAttribute()
    {
        return \App\ContentRatingVote::where('rating_id', $this->id)->where('vote', 0)->where('user_id', isset(Auth::user()->id) ? Auth::user()->id : 'N/A')->count();
    }

}
