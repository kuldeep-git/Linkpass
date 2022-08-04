<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Content;
use App\User;

class ContentAction extends Authenticatable
{
    protected $table = 'content_actions';

    protected $fillable = [
        'content_id', 'user_id', 'action', 'reason'
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
