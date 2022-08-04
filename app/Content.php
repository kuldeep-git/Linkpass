<?php

namespace App;

use App\Http\Traits\Hashidable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Config;
use Storage;
use Auth;

class Content extends Authenticatable
{
    use Hashidable, SoftDeletes;

    protected $table = 'content';

    protected $fillable = [
        'category_id', 'sub_category', 'user_id', 'type', 'social_account_id', 'main_title', 'main_image', 'description', 'external_link', 'number_of_images', 'number_of_words', 'video_length', 'podcast_length', 'status', 'is_published', 'posted_at'
    ];

    protected $appends = ['main_image_url', 'views_count', 'user_views_count', 'ratings_count', 'like_count', 'unlike_count'];

    public function content_category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function content_user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getMainImageUrlAttribute()
    {
        return (isset($this->main_image) && Storage::disk(env('FILESYSTEM_DRIVER'))->exists($this->main_image) ? Config('filesystems.disks.public.url').'/'.$this->main_image : asset('assets/img/no_img.jpg'));
    }

    public function getViewsCountAttribute()
    {
        return \App\ContentView::where('content_id', $this->id)->count();
    }

    public function getUserViewsCountAttribute()
    {
        return \App\ContentView::where('content_id', $this->id)->where('user_id', isset(Auth::user()->id) ? Auth::user()->id : 'N/A')->count();
    }

    public function getRatingsCountAttribute()
    {
        return \App\ContentRating::where('content_id', $this->id)->count();
    }

    public function getLikeCountAttribute()
    {
        return \App\ContentAction::where('content_id', $this->id)->where('action' , '1')->count();
    }

    public function getUnlikeCountAttribute()
    {
        return \App\ContentAction::where('content_id', $this->id)->where('action' , '2')->count();
    }

    public function content_tags()
    {
        return $this->hasMany('App\ContentTags', 'content_id','id');
    }

    public function content_category_tags()
    {
        return $this->hasMany('App\ContentCategoryTags', 'content_id','id');
    }

    public function content_account()
    {
        return $this->belongsTo('App\SocialAccount', 'social_account_id');
    }

    public function content_ratings()
    {
        return $this->hasMany('App\ContentRating', 'content_id','id')->orderBy('id', 'desc');
    }

    public function content_user_like()
    {
        return $this->hasOne('App\ContentAction', 'content_id','id')->where('action' , '1')->where('user_id', isset(Auth::user()->id) ? Auth::user()->id : 'N/A');
    }

    public function content_user_unlike()
    {
        return $this->hasOne('App\ContentAction', 'content_id','id')->where('action' , '2')->where('user_id', isset(Auth::user()->id) ? Auth::user()->id : 'N/A');
    }

    public function content_user_inappropriate()
    {
        return $this->hasOne('App\ContentAction', 'content_id','id')->where('action' , '3')->where('user_id', isset(Auth::user()->id) ? Auth::user()->id : 'N/A');
    }

    public function content_user_keep()
    {
        return $this->hasOne('App\ContentAction', 'content_id','id')->where('action' , '4');
    }

    public function content_user_remove()
    {
        return $this->hasOne('App\ContentAction', 'content_id','id')->where('action' , '5')->where('user_id', isset(Auth::user()->id) ? Auth::user()->id : 'N/A');
    }

    public function content_user_deleted()
    {
        return $this->hasOne('App\ContentAction', 'content_id','id')->where('action' , '5');
    }

    public function content_user_visited()
    {
        return $this->hasOne('App\ContentView', 'content_id','id')->where('user_id', isset(Auth::user()->id) ? Auth::user()->id : 'N/A');
    }


}
