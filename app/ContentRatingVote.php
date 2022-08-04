<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\ContentRating;
use App\User;

class ContentRatingVote extends Authenticatable
{
    protected $table = 'content_rating_votes';

    protected $fillable = [
        'rating_id', 'user_id', 'vote'
    ];

    public function rating()
    {
        return $this->belongsTo(ContentRating::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
