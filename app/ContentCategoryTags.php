<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Content;

class ContentCategoryTags extends Authenticatable
{
    protected $table = 'content_category_tags';

    protected $fillable = [
        'content_id', 'name'
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
