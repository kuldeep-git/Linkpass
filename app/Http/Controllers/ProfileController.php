<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use Storage;
use Auth;
use App\User;
use App\UserFollower;
use App\Category;
use App\UserPreferencesGroups;
use App\UserPreferencesGroupTags;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user                  = auth()->user();
        $category              = new Category();
        $userPreferencesGroups = UserPreferencesGroups::where('user_id', $user->id)->where('name', 'default')->first();

        if(!isset($userPreferencesGroups->id))
        {
            UserPreferencesGroups::create(['name' => 'default', 'user_id' => Auth::user()->id]);
        }

        return view('profile.edit', array('user' => $user));
    }

    /**
     * Show the form for change password
     *
     * @return \Illuminate\View\View
     */
    public function changePassword()
    {
        $user        = auth()->user();
        $category    = new Category();
        $toalUserPreferencesGroups = UserPreferencesGroups::where('user_id', $user->id)->count();

        return view('profile.change-password');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        $file=$request->file('profile_img');
        $userArr = array();
        $userArr['name'] = $request->name;
        $userArr['email'] = $request->email;
        //$userArr['surname'] = $request->surname;
        $userArr['account_name'] = $request->account_name;
        $userArr['location'] = $request->location;
        if($request->has('date_of_birth'))
        {
            $userArr['date_of_birth'] = $request->has('date_of_birth') ? date("Y-m-d H:i:s", strtotime($request->date_of_birth)) : '';
        }
       // $userArr['category_id'] = $request->category;

        if($file){

            if (is_file(public_path($user->profile_img))) {

                unlink(public_path($user->profile_img));
            }
            $file_name =$file->getClientOriginalName();
            $fileslug= pathinfo($file_name, PATHINFO_FILENAME);
            $imageName = md5($fileslug.time());
            $imgext =$file->getClientOriginalExtension();
            $path = 'userprofile/'.$user->id.'/'.$imageName.".".$imgext;
            Storage::disk('public')->putFileAs('userprofile/'.$user->id,$file,$imageName.".".$imgext);

           $userArr['profile_img'] = $path;
        }

        auth()->user()->update($userArr);
        return back()->withStatus(__('Profile has been updated successfully.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password has been updated successfully.'));
    }

    public function getUserPreferences(Request $request){

        $userPreferencesGroups = UserPreferencesGroups::with('tags')->where('user_id', Auth::user()->id)->orderBy('id','asc')->get();

        $userPreferencesCount  = $userPreferencesGroups->count();

        $userPreferencesTagsCount = UserPreferencesGroupTags::where('user_preferences_groups.user_id', Auth::user()->id)->join('user_preferences_groups', 'user_preferences_groups.id', '=', 'user_preferences_group_tags.group_id')->count();
        $userPreferencesTags = UserPreferencesGroupTags::where('user_preferences_groups.user_id', Auth::user()->id)->join('user_preferences_groups', 'user_preferences_groups.id', '=', 'user_preferences_group_tags.group_id')->pluck('user_preferences_group_tags.name')->toArray();

        $html = view('profile.ajax-user-preferences-list', array('userPreferencesGroups' => $userPreferencesGroups, 'userPreferencesTags' => $userPreferencesTags))->render();

        return response()->json(['success' => true, 'userPreferencesCount' => $userPreferencesCount, 'userPreferencesTagsCount' => $userPreferencesTagsCount, 'html' => $html]);
    }

    public function saveUserPreferencesGroup(Request $request){

        $name = $request->get('name');
        $id   = $request->get('id');

        if(!empty($name))
        {
            if(!empty($id))
            {
                $group = UserPreferencesGroups::find($id);
                $group->name = $name;
                $group->save();
            }
            else
            {
                UserPreferencesGroups::create(['name' => $name, 'user_id' => Auth::user()->id]);
            }

            return response()->json(['success' => true, 'message' => 'The user group has been saved successfully.']);
        }
        else
        {
            return response()->json(['success' => false, 'message' => 'Please enter group name']);
        }
    }

    public function deleteUserPreferencesGroup(Request $request){

        $id = $request->get('id');

        if(!empty($id))
        {
            $group = UserPreferencesGroups::find($id);

            if(isset($group->id))
            {
                UserPreferencesGroupTags::where('group_id', $group->id)->delete();
            }

            $group->delete();

            return response()->json(['success' => true, 'message' => 'The user group has been saved successfully.']);
        }
        else
        {
            return response()->json(['success' => false, 'message' => 'Cound not found the group']);
        }
    }

    public function setUserPreferencesGroupStatus(Request $request){

        $status = $request->get('status');
        $id     = $request->get('group_id');

        $group  = UserPreferencesGroups::find($id);

        if(isset($group->id))
        {
            $group->status = $status;
            $group->save();

            return response()->json(['success' => true, 'message' => 'The user group status has been saved successfully.']);
        }
        else
        {
            return response()->json(['success' => false, 'message' => 'Cound not found the group']);
        }
    }

    public function saveUserPreferencesGroupTag(Request $request){

        $name     = trim($request->get('name'));
        $group_id = $request->get('group_id');
        $type     = $request->get('type');

        if(!empty($name))
        {
            if($type == 'add')
            {
                $isExist = UserPreferencesGroupTags::where('name', $name)->first();

                if(!isset($isExist->id))
                {
                    UserPreferencesGroupTags::create(['name' => $name, 'group_id' => $group_id]);
                }
                // else
                // {
                //     return response()->json(['success' => false, 'message' => 'This tag already exists']);
                // }
            }

            if($type == 'remove')
            {
                UserPreferencesGroupTags::where('name', $name)->where('group_id', $group_id)->delete();
            }

            $userPreferencesTagsCount = UserPreferencesGroupTags::where('user_preferences_groups.user_id', Auth::user()->id)->join('user_preferences_groups', 'user_preferences_groups.id', '=', 'user_preferences_group_tags.group_id')->count();
            $userPreferencesTags = UserPreferencesGroupTags::where('user_preferences_groups.user_id', Auth::user()->id)->join('user_preferences_groups', 'user_preferences_groups.id', '=', 'user_preferences_group_tags.group_id')->pluck('user_preferences_group_tags.name')->toArray();

            $group = UserPreferencesGroups::find($group_id);
            $tagsHtml = view('profile.ajax-user-tags', array('item' => $group))->render();

            return response()->json(['success' => true, 'userPreferencesTagsCount' => $userPreferencesTagsCount, 'userPreferencesTags' => json_encode($userPreferencesTags), 'tagsHtml' =>$tagsHtml]);
        }
        else
        {
            return response()->json(['success' => false, 'message' => 'Please enter tag name']);
        }
    }

    public function setUserType(Request $request){

        $status = $request->get('status');
        $user   = Auth::user();

        if(isset($user->id))
        {
            $user->user_type = $status;
            $user->save();

            return response()->json(['success' => true, 'message' => 'The user type has been saved successfully.']);
        }
        else
        {
            return response()->json(['success' => false, 'message' => 'Cound not found the user']);
        }
    }

    public function saveUserInterest(Request $request){

        $title       = $request->get('title');
        $description = $request->get('description');

        $user = Auth::user();

        if(isset($user->id))
        {
            $user->interest_title = $title;
            $user->interest_description = $description;
            $user->interest_last_updated_at = Carbon::now();
            $user->save();

            return response()->json(['success' => true, 'title' => $title, 'updated_at' => date('Y/m/d', strtotime($user->interest_last_updated_at)), 'message' => 'Your changes have been saved']);
        }
        else
        {
            return response()->json(['success' => false, 'message' => 'Cound not found the user']);
        }
    }

    public function validateAccountName(Request $request){

        $account_name = $request->get('account_name');

        $user = Auth::user();

        if(isset($user->id))
        {
            $isExist = User::where('account_name', $account_name)->where('id', '!=', $user->id)->first();

            return response()->json(['success' => isset($isExist->id) ? true : false]);
        }
        else
        {
            $isExist = User::where('account_name', $account_name)->first();

            return response()->json(['success' => isset($isExist->id) ? true : false]);
        }
    }

    public function followUser(Request $request){

        $linkedUserId = $request->get('linked_user_id');
        $userId   = Auth::user()->id;

        if(!empty($linkedUserId))
        {
            $isExist = UserFollower::where('user_id', $userId)->where('linked_user_id', $linkedUserId)->first();

            if(!isset($isExist->id))
            {
                $userFollower                 = new UserFollower();
                $userFollower->user_id        = $userId;
                $userFollower->linked_user_id = $linkedUserId;
                $userFollower->created_at     = date("Y-m-d H:i:s");
                $userFollower->save();
            }

            return response()->json(['success' => true]);
        }
        else
        {
            return response()->json(['success' => false, 'message' => 'Cound not found the user']);
        }
    }
}
