<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Storage;

class ContentView extends Authenticatable
{
    protected $table = 'content_views';

    protected $fillable = [
        'content_id', 'user_id', 'ip_address'
    ];


}
