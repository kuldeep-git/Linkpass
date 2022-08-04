<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\UserPreferencesGroups;

class UserPreferencesGroupTags extends Authenticatable
{
    protected $table = 'user_preferences_group_tags';

    protected $fillable = [
        'group_id', 'name'
    ];

    public function group()
    {
        return $this->belongsTo(UserPreferencesGroups::class);
    }
}
