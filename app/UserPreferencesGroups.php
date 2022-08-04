<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\UserPreferencesGroupTags;
use App\User;

class UserPreferencesGroups extends Authenticatable
{
    protected $table = 'user_preferences_groups';

    protected $fillable = [
        'user_id', 'name', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->hasMany(UserPreferencesGroupTags::class, 'group_id');
    }
}
