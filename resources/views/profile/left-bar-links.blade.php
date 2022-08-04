<div class="card card-profile shadow">
    <div class="row justify-content-center">
        <div class="col-lg-3 order-lg-2 pt-2">
            <div class="card-profile-image">
                <a href="javascript:void(0);">
                    <img src="{{auth()->user()->user_image_url}}" class="rounded-circle img-center img-fluid shadow shadow-lg--hover" style="width: 140px;">
                </a>
            </div>
        </div>
    </div>

    <div class="card-body pt-0 pt-3">
        <div class="text-center mt-md-6 mt-6">
            <h4> {{ auth()->user()->name }} </h4>
            <div class="h5 font-weight-300">
                <i class="ni location_pin mr-2"></i>{{ auth()->user()->email }}
            </div>
        </div>

    </div>

    <div class="dashboard-side-menu">
        <ul>
            <li>
                <a class="{{Route::currentRouteName() == 'profile.edit' ? 'active' : ''}}" href="{{url('profile_settings')}}">Profile</a>
            </li>
            <li>
                <a class="{{Route::currentRouteName() == 'change-password' ? 'active' : ''}}" href="{{url('change-password')}}">Change Password</a>
            </li>
            @if(isset(auth()->user()->id) && auth()->user()->user_type)
            <li>
                <a href="{{route('user.content.list')}}" >Manage Contents</a>
            </li>
            @endif
            <li>
                <a class="{{in_array(Route::currentRouteName(), ['user.social-account.list', 'user.social-account.edit', 'user.social-account.create']) ? 'active' : ''}}" href="{{url('social-account')}}">Social Accounts</a>
            </li>
        </ul>
    </div>

</div>