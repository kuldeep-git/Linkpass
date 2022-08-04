<?php

namespace App\Http\Controllers;

use App\Guide;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\SocialAccountRequest;
use Auth;
use PDF;
use App\SocialAccount;
use App\User;
use App\Content;
use App\UserFollower;
use Response;
use Storage;

class UserAccountController extends Controller
{

    public function __construct()
    {

    }

    /**
     * Display a logged in user account
     *
     * @return \Illuminate\Http\Response
     */
    public function getLoggedInUserAccount(Request $request)
    {
        $socialAccounts = SocialAccount::where('user_id', Auth::user()->id)->where('status', '1')->orderBy('name', 'asc')->get();
        $followingIds  = UserFollower::where('user_id', Auth::user()->id)->pluck('linked_user_id')->toArray();
        $followerIds   = UserFollower::where('linked_user_id', Auth::user()->id)->pluck('user_id')->toArray();
        $user = User::find(Auth::user()->id);

        return view('user-account.logged-in-user-account', array('title' => 'My Account', 'socialAccounts' => $socialAccounts, 'type' => 'socialAccount' , 'user' => $user, 'editable' => true, 'followerIds' => $followerIds, 'followingIds' => $followingIds));
    }

    /**
     * Display a logged in user account
     *
     * @return \Illuminate\Http\Response
     */
    public function getOtherUserAccount($accoutnName)
    {
        $user = User::where('account_name', $accoutnName)->first();
       
        if(!isset($user->id))
        {
            if(isset(Auth::user()->id))
            {
                return redirect(route('user.account'));
            }

            return redirect(route('home'));
        }

        $decodedId = isset($user->id) ? $user->id : '';

        $socialAccounts = SocialAccount::where('user_id', $decodedId)->where('status', '1')->orderBy('name', 'asc')->get();
        $followingIds  = UserFollower::where('user_id', $decodedId)->pluck('linked_user_id')->toArray();
        $followerIds   = UserFollower::where('linked_user_id', $decodedId)->pluck('user_id')->toArray();
        $user = User::find($decodedId);

        $editable = isset(Auth::user()->id) && Auth::user()->id == $user->id ? true : false;

        return view('user-account.logged-in-user-account', array('title' => 'User Account', 'socialAccounts' => $socialAccounts, 'type' => 'socialAccount', 'user' => $user, 'editable' => $editable, 'followerIds' => $followerIds, 'followingIds' => $followingIds, 'interest_title' => $user->interest_title, 'interest_description' => $user->interest_description, 'interest_last_updated_at' => $user->interest_last_updated_at));
    }

    /**
     * Display a logged in user contents by accountId
     *
     * @return \Illuminate\Http\Response
     */
    public function getContentsByAccountId($id, $userId)
    {
        $decodedId = decodeHashId($id);
        $decodedUserId = decodeHashId($userId);
        $user = User::find($decodedUserId);

        $editable = isset(Auth::user()->id) && Auth::user()->id == $user->id ? true : false;

        $socialAccount = SocialAccount::where('user_id', $decodedUserId)->where('id', $decodedId)->where('status', '1')->first();

        $items = Content::where('user_id', $decodedUserId)->where('social_account_id', $decodedId)
            ->where('status', '1')->orderBy('created_at', 'desc')->paginate(12);

        $followingIds  = UserFollower::where('user_id', $decodedUserId)->pluck('linked_user_id')->toArray();
        $followerIds   = UserFollower::where('linked_user_id', $decodedUserId)->pluck('user_id')->toArray();

        return view('user-account.logged-in-user-account', array('title' => 'Account Contents', 'items' => $items, 'type' => 'content', 'socialAccountId' => $id, 'user' => $user, 'socialAccount' => $socialAccount, 'editable' => $editable, 'followerIds' => $followerIds, 'followingIds' => $followingIds, 'interest_title' => $user->interest_title, 'interest_description' => $user->interest_description, 'interest_last_updated_at' => $user->interest_last_updated_at));
    }
}
