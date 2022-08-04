<?php

namespace App;

use App\Http\Traits\Hashidable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class Enquiry extends Authenticatable
{
    use SoftDeletes, Hashidable;

    protected $table = 'enquiries';

    protected $appends = [''];

    public $timestamps = false;

    protected $fillable = [
        'user_id','subject', 'message', 'created_at'
    ];
}
