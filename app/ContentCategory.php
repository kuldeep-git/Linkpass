<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ContentCategory extends Authenticatable
{
    protected $table = 'content_category';

    protected $fillable = [
        'content_id', 'category_id'
    ];

    protected $casts = [
        "status" => "int"
    ];

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

}
