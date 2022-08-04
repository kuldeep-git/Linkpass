<?php

namespace App\Http\Controllers;

use App\Content;
use App\Category;
use App\SocialAccount;
use App\ContentTags;
use App\ContentCategoryTags;
use App\UserPreferencesGroupTags;
use App\ContentRating;
use App\ContentRatingVote;
use App\ContentAction;
use App\ContentView;
use App\User;
use App\UserFollower;
use Illuminate\Http\Request;
use Response;
use Auth;
use PDF;
use Str;
use Dompdf\Dompdf;
use Storage;

class ContentController extends Controller
{
    public function __construct()
    {

        $this->content          = new Content();
        $this->contentTags      = new ContentTags();
        $this->contentCategoryTags = new ContentCategoryTags();
        $this->contentRatings   = new ContentRating();
        $this->user             = new User();
    }

    public function publishContent()
    {
        $unpublishedContents = $this->content->select('id', 'created_at')->where('is_published', 0)->get();

        if($unpublishedContents->count() > 0)
        {
            foreach($unpublishedContents as $content)
            {
                $createdAt = strtotime($content->created_at);

                $publishDate = strtotime("+3 hour", strtotime($createdAt));

                if($publishDate > $createdAt)
                {
                    $this->content->where('id', $content->id)->update(['is_published' => 1]);
                }
            }
        }
    }
}
