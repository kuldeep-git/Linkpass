<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserFollower extends Authenticatable
{
	protected $table = 'user_followers';

    public $timestamps = false;


   // protected $appends = [ 'image_by_user', 'image_by_admin' ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'user_id', 'linked_user_id'
    ];
}
