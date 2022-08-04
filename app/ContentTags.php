<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Content;

class ContentTags extends Authenticatable
{
    protected $table = 'content_tags';

    protected $fillable = [
        'content_id', 'name'
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
