@php
    $userProfileClass = '';
    if($user->user_type == '0')
    {
        $userProfileClass = 'user-profile-bg';
    }
    if($user->user_type == '1')
    {
        $userProfileClass = 'creator-profile-bg';
    }
    if($user->user_type == '2')
    {
        $userProfileClass = 'hybrid-profile-bg';
    }
@endphp
<div class="row d-flex justify-content-between">
    <aside class="col-md-10">

        <div class="user-profile-avatar-90 user-profile-avatar-top">
            <a href="{{route('user.account')}}">
            <img src="{{$user->user_image_url}}" alt="" class="rounded-circle height-90 width-90 {{$userProfileClass}}">
            </a>
        </div>

        {{-- <ul class="LinkVerb mt-3">
            @if(isset(Auth::user()->id) && Auth::user()->id != $user->id)
                @if(isset(Auth::user()->id) && (Auth::user()->id != $user->id) && in_array($user->id, $followingIds))
                    <li class="active"><a class="" data-user-id="{{$user->id}}" href="javascript:void(0);">Linked</a></li>
                @else
                    <li class="active"><a class="follow-user" data-user-id="{{$user->id}}" href="javascript:void(0);">Link</a></li>
                    <li><i><a class="sm LinkVerbLabel" href="javascript:void(0);">Verb</a></i></li>
                @endif
            @endif
        </ul> --}}
    </aside>
    <aside class="col-md-2 head-link">
        <p><a href="javascript:void(0);" ><strong class="text-secondary">{{$user->account_name}}</strong></a></p>
        <p><a href="javascript:void(0);" class="text-secondary">{{$user->name}}</a></p>
        <p class="font-14"><a href="javascript:void(0);" class="text-primary"><strong class="text-primary">Here Since: </strong><span>{{date('d M Y', strtotime($user->created_at))}}</span></a></p>
        @if(!empty($user->location))
        <p class="font-14"><a href="javascript:void(0);" class="text-primary"><strong class="text-primary">From:</strong> <span>{{ !empty($user->location) ? $user->location : 'N/A'}}</span></a></p>
        @endif
    </aside>
</div>
{{-- <ul class="ListingList font-12">
    <li><strong><a href="javascript:void(0);" class="text-light">Linked: </strong><span class="text-light">{{count($followingIds)}}</span></a></li>
    <li><strong><a href="javascript:void(0);" class="text-light">Linker: </strong><span class="text-light">{{count($followerIds)}}</span></a></li>
</ul> --}}