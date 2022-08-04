@extends('layouts.app', ['title' => __('User Profile')])

@section('content')

    <main class="main">
        <article class="container">

            @if(in_array(Auth::user()->user_type, ['0','2']))
                <div class="w100p pull-left mb-3">
                    <span class="text-primary pull-left mr-2 isHybridLabel" id="valueOfSwitch">CREATE:</span>
                    <div class="custom-control custom-switch pull-left">
                        @php $status = $user->user_type == 2 ? 'checked' : ''; @endphp

                        <input name="subscribe" type="checkbox" class="custom-control-input condition-trigger userTypeToggle" id="customSwitchHybrid" {{$status}}>
                        <label class="custom-control-label" for="customSwitchHybrid"></label>
                    </div>
                </div>
            @endif

            @if(in_array(Auth::user()->user_type, ['0','2']))
                <ul class="LinkVerb">
                    <li class="active"><a id="addNewUserPreferencesGroup" href="javascript:void(0);">New # Group</a></li>
                    <li><label># Groups: <span id="userPreferencesCount"></span></label></li>
                    <li><label># Total: <span id="userPreferencesTagsCount"></span></label></li>
                </ul>
                <div id="userPreferencesWrap"></div>
            @endif
            <hr class="mb-3">
            <div class="row d-flex justify-content-center">
                <aside class="col-lg-5">
                <ul class="nav nav-pills mb-3 KeptPills" id="pills-tab" role="tablist">
                    <li class="nav-item w50p"> <a class="nav-link {{ (request()->old('updateProfile') || !request()->old('changePass')) ? 'active' : '' }}" id="pills-Profile-tab" data-toggle="pill" href="#pills-Profile" role="tab" aria-controls="pills-Profile" aria-selected="true">Profile Settings</a> </li>
                    <li class="nav-item w50p"> <a class="nav-link {{ request()->old('changePass') ? 'active' : '' }}" id="pills-Pass-tab" data-toggle="pill" href="#pills-Pass" role="tab" aria-controls="pills-Pass" aria-selected="false">Change Password</a> </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <!--Start Profile-->
                    <div class="tab-pane fade {{ (request()->old('updateProfile') || !request()->old('changePass')) ? 'show active' : '' }}" id="pills-Profile" role="tabpanel" aria-labelledby="pills-Profile-tab">
                    <div class="login-box text-center">
                        <h5><strong>Profile Settings</strong></h5>

                        <form method="post" action="{{ route('profile.update') }}" autocomplete="off" enctype= "multipart/form-data">
                            @csrf
                            @method('put')
                            <input type="hidden" name="updateProfile">
                            @if(session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">

                                <div class="form-group text-left">
                                    <div class="{{ $errors->has('account_name') ? ' has-danger' : '' }}">
                                        <input type="text" name="account_name" id="account_name" class="form-control {{ $errors->has('account_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Account Name') }}" value="{{ old('account_name', auth()->user()->account_name) }}" maxlength="25">
                                        <small id="accNameHelp" class="form-text text-muted">Only 0-9a-zA-Z-_ allowed with maximum 25 characters allowed</small>
                                        @if($errors->has('account_name'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('account_name') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group text-left">
                                    <div class="{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}" maxlength="25">
                                        <small id="nameHelp" class="form-text text-muted">Maximum 25 characters are allowed</small>
                                        @if($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- <div class="form-group text-left">
                                    <div class="{{ $errors->has('surname') ? ' has-danger' : '' }}">
                                        <input type="text" name="surname" id="surname" class="form-control {{ $errors->has('surname') ? ' is-invalid' : '' }}" placeholder="{{ __('Surname') }}" value="{{ old('surname', auth()->user()->surname) }}">

                                        @if($errors->has('surname'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('surname') }}
                                            </span>
                                        @endif
                                    </div>
                                </div> --}}



                                <div class="form-group text-left">
                                    <div class="{{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <input type="email" name="email" id="input-email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}">

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('email') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group text-left">
                                    <div class="{{ $errors->has('location') ? ' has-danger' : '' }}">
                                        <input type="text" name="location" id="location" class="form-control {{ $errors->has('location') ? ' is-invalid' : '' }}" placeholder="{{ __('Location') }}" value="{{ old('location', auth()->user()->location) }}">
                                        @if($errors->has('location'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('location') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group text-left">
                                    <div class="{{ $errors->has('date_of_birth') ? ' has-danger' : '' }}">
                                        <input type="date" name="date_of_birth" id="date_of_birth" class="form-control {{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" placeholder="{{ __('Date of Birth') }}" value="{{ old('date_of_birth', !empty(auth()->user()->date_of_birth) ? date('Y-m-d', strtotime(auth()->user()->date_of_birth)) : '') }}">
                                        @if($errors->has('date_of_birth'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('date_of_birth') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- <div class="form-group text-left">
                                    <label class="form-control-label" for="tags">{{ __('Tags') }}</label>
                                    <div class="{{ $errors->has('tags') ? ' has-danger' : '' }}">
                                        <input type="text" name="tags" class="form-control" id="tags" value="{{old('tags', $userTags)}}" data-role="tagsinput" />
                                        @if ($errors->has('tags'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('tags') }}
                                            </span>
                                        @endif
                                    </div>
                                </div> --}}

                                <div class="row row-example">
                                    <div class="col-12 col-md-8">
                                        <div class="form-group text-left">
                                            <div class="custom-file">
                                                <input type="file" name="profile_img" class="custom-file-input" id="customFileLang" accept="image/*" lang="en" onchange="loadFile(event)">
                                                <label class="custom-file-label" for="customFileLang">Select profile image</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-4">
                                        <a href="javascript:void(0);">
                                            @php
                                                $userProfileClass = '';
                                                if(Auth::user()->user_type == '0')
                                                {
                                                    $userProfileClass = 'user-profile-bg';
                                                }
                                                if((isset(Auth::user()->user_type) && Auth::user()->user_type == '1'))
                                                {
                                                    $userProfileClass = 'creator-profile-bg';
                                                }
                                                if(Auth::user()->user_type == '2')
                                                {
                                                    $userProfileClass = 'hybrid-profile-bg';
                                                }
                                            @endphp
                                            <div class="user-profile-avatar">
                                                <img id="output" src="{{Auth::user()->user_image_url}}" alt="" class="rounded-circle height-64 width-64 {{$userProfileClass}}">
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="form-group login-btn mt-3">
                                    <button type="submit" class="btn btn-primary  text-uppercase w-100">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>

                    <!--Start Pass-->
                    <div class="tab-pane fade {{ request()->old('changePass') ? 'show active' : '' }}" id="pills-Pass" role="tabpanel" aria-labelledby="pills-Pass-tab">
                    <div class="login-box text-center">
                        <h5><strong>Change Password</strong></h5>

                        <form method="post" action="{{ route('profile.password') }}" autocomplete="off" >
                            @csrf
                            @method('put')
                            <input type="hidden" name="changePass" value="1">
                            @if (session('password_status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('password_status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="form-group text-left">
                                    <div class="{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                        <input type="password" name="old_password" id="input-current-password" class="form-control {{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Current Password') }}" value="" >

                                        @if ($errors->has('old_password'))
                                            <span class="invalid-feedback"  role="alert">
                                            {{ $errors->first('old_password') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group text-left">
                                    <div class="{{ $errors->has('password') ? ' has-danger' : '' }}">
                                        <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" value="" >
                                        <small id="passwordHelp" class="form-text text-muted">Password must contain at least one number and special character</small>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('password') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group text-left">
                                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative" placeholder="{{ __('Confirm New Password') }}" value="" >
                                </div>

                                <div class="form-group login-btn">
                                    <button type="submit" class="btn btn-primary  text-uppercase w-100">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
                </aside>
            </div>
            </article>
        </main>
      <!--End main Part-->
@endsection

@section('pagewise_js')
<script type="text/javascript">
var loadFile = function(event) {
var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
};

jQuery(document).ready(function($) {

    $('#account_name').keypress(function( e ) {
      if(!/[0-9a-zA-Z-_]/.test(String.fromCharCode(e.which)))
        return false;
    });

    $(document).on('blur','#account_name',function(event) {

        var account_name = $('#account_name').val();

        if(account_name != '')
        {
            $.ajax(
            {
                url: '{{route("user.validate-account-name")}}',
                type: "post",
                datatype: "json",
                data:{account_name:account_name},
            }).done(function(data){
            if(data.success)
            {
                $.notify({
                message: 'Account name is not available'
                },{
                type: 'alert alert-danger'
                });
            }
            });
        }
    });

    $(document).on('click', '#addNewUserPreferencesGroup', function(event) {
        event.preventDefault();

        var totalGroup = $('.userPreferencesBox').length;

        if (totalGroup == 4) {
            swal('','You reached the maximum number of # groups', '');
            return false;
        }

        saveUserPreferencesGroup(this);
    });

    $(document).on('click', '.editNewUserPreferencesGroup', function(event) {
        event.preventDefault();
        saveUserPreferencesGroup(this);
    });

    $(document).on('click', '.deleteUserPreferencesGroup', function(event) {
        event.preventDefault();
        deleteUserPreferencesGroup(this);
    });

    $(document).on('change', '.groupStatusToggle', function(event) {
        event.preventDefault();

        var status   = this.checked ? 1 : 0,
            group_id = $(this).attr('data-group-id')

        $.ajax({
            url: '{{ route("user.set-preferences-group-status") }}',
            type: "post",
            data : {status : status, group_id : group_id},
            datatype: "json"
        }).done(function(data) {
              getUserPreferences();
              //swal('Success!', data.message, 'success');
              return false;
        })
    });

    $(document).on('change', '#customSwitchHybrid', function(event) {
        event.preventDefault();

        var status = this.checked ? 2 : 0;

        $.ajax({
            url: '{{ route("user.set-user-type") }}',
            type: "post",
            data : {status : status},
            datatype: "json"
        }).done(function(data) {
            if(status == 2)
            {
              swal('', 'You can now create content listings', 'success');
            }
            else
            {
                swal('', 'Content listing creation is suspended', 'success');
            }
            return false;
        })
    });

    $(document).on('click', '.save-user-interest', function(event) {
        event.preventDefault();

        var title       = $('#interest_title').val();
        var description = $('#interest_description').val();

        $.ajax({
            url: '{{ route("user.save-user-interest") }}',
            type: "post",
            data : {title : title, description : description},
            datatype: "json"
        }).done(function(data) {

            $('.user-interest-head-title').html(data.title)
            $('.user-interest-head-time').html(data.updated_at)
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
            toastr.success(data.message);

            return false;
        })
    });

    $(document).mouseup(function(e)
    {
        var container = $('.tagsinput-box');

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            hideTagsInput();
        }
    });

    $(document).on('click', '.addNewTag', function(event) {
        event.preventDefault();
        var groupId = $(this).data('group-id');
        var isTagsInputApplied = $('#tagsinput-box-'+groupId).find('.bootstrap-tagsinput').length;

        if($('#user-tags-box-'+groupId).is(':visible'))
        {
            $('#user-tags-input-'+groupId).show();
            $('#user-tags-box-'+groupId).hide();

            var options = {
                tagClass: 'badge badge-info user-hash-tags',
                allowDuplicates: false,
                trimValue: true,
                addOnBlur: false,
                maxChars:25,
                itemText: function(item) {
                    item = item.replace(" ", "");
                    item = item.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                    return item;
                }
            };

            if(isTagsInputApplied == 1)
            {
                $('#tagsinput-box-'+groupId).find('.bootstrap-tagsinput').show();
                $('#user-tags-input-'+groupId).hide();
            }

            if(isTagsInputApplied == 0)
            {
                $('#user-tags-input-'+groupId).tagsinput(options);
                $('#user-tags-input-'+groupId).tagsinput('focus');

                $('#user-tags-input-'+groupId).on('beforeItemAdd', function(event) {

                    var existingTags = $('#userPreferencesTags').val();
                    var tagListArr = JSON.parse(existingTags);
                    var item = event.item.toLowerCase();
                    item = item.replace(" ", "");
                    item = item.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                    if(tagListArr.includes(item))
                    {
                        event.cancel = true;
                        swal('Error!!', 'This tag already exists', 'error');
                        return false;
                    }
                });


                $('#user-tags-input-'+groupId).on('itemAdded', function(event) {
                    event.preventDefault();
                    var tagStr = event.item;
                        tagStr = tagStr.replace(" ", "");
                        tagStr = tagStr.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');

                        // event.cancel=true;
                        // event.preventDefault=true;
                        // $('#user-tags-input-'+groupId).tagsinput('add', tagStr);

                    $.ajax({
                        url: '{{route("user.save-preferences-group-tag")}}',
                        type: "post",
                        datatype: "json",
                        data: {
                            name: tagStr,
                            group_id: groupId,
                            type: 'add'
                        }
                    }).done(function(data) {
                        if(data.success){
                            $('#userPreferencesTagsCount').html(data.userPreferencesTagsCount);
                            $('#user-tags-box-'+groupId).html(data.tagsHtml);

                            $('#userPreferencesTags').val(data.userPreferencesTags);
                        }
                        // else
                        // {
                        //     swal('Error!!', data.message, 'error');
                        //     return false;
                        // }
                    });
                });

                $('#user-tags-input-'+groupId).on('itemRemoved', function(event) {
                    event.stopImmediatePropagation();

                    var tagStr = event.item;
                    $.ajax({
                        url: '{{route("user.save-preferences-group-tag")}}',
                        type: "post",
                        datatype: "json",
                        data: {
                            name: tagStr,
                            group_id: groupId,
                            type: 'remove'
                        }
                    }).done(function(data) {
                        if(data.success){
                            $('#userPreferencesTagsCount').html(data.userPreferencesTagsCount);
                            $('#user-tags-box-'+groupId).html(data.tagsHtml);
                            $('#userPreferencesTags').val(data.userPreferencesTags);

                           // $('.bootstrap-tagsinput:first').trigger('blur');
                           hideTagsInput();

                        }
                    });
                });
            }
        }
        else
        {
            // if(isTagsInputApplied == 1)
            // {
            //     $('#user-tags-input-'+groupId).tagsinput('destroy');
            // }
            $('#tagsinput-box-'+groupId).find('.bootstrap-tagsinput').hide();
            $('#user-tags-box-'+groupId).show();
            $('#user-tags-input-'+groupId).hide();
        }
    });
});

// Load User Preferences
getUserPreferences();

function hideTagsInput() {
    try {
        var tGroupId = $('.bootstrap-tagsinput').parents('.tagsinput-box').attr('data-group-id');

        $('#tagsinput-box-'+tGroupId).find('.bootstrap-tagsinput').hide();
        $('#user-tags-box-'+tGroupId).show();
        $('#user-tags-input-'+tGroupId).hide();
    } catch (error) {}
}

function getUserPreferences() {

    if($('#userPreferencesWrap').length && $('#userPreferencesCount').length && $('#userPreferencesTagsCount').length)
    {
        $.ajax({
            url: '{{ route("user.get-preferences") }}',
            type: "get",
            datatype: "json",
        }).done(function(data) {

            if (data.success) {
                $('#userPreferencesWrap').html(data.html);
                $('#userPreferencesCount').html(data.userPreferencesCount);
                $('#userPreferencesTagsCount').html(data.userPreferencesTagsCount);
            }
        });
    }
}

function saveUserPreferencesGroup(element) {

    var htmlStr    = '',
        group_id   = $(element).attr('data-group-id') ? $(element).attr('data-group-id') : '',
        group_name = $(element).attr('data-group-name') ? $(element).attr('data-group-name') : '';

    htmlStr = '<input type="text" class="form-control" value="'+group_name+'" name="group_name" id="group_name">';

    if (htmlStr.length > 0) {
        swal({
            title: "Group Name",
            html: htmlStr,
            type: "info",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: group_id != '' ? 'Update' : 'Create',
            cancelButtonText: "No, Cancel it!"
        }).then((result) => {
            if (result.value) {
                var group_name = $('#group_name').val();

                if (group_name == '') {
                    swal({
                        title: "Error!!",
                        text: 'Please enter group name',
                        type: "error",
                        showCancelButton: false,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        $('#addNewUserPreferencesGroup').trigger('click');
                    });

                    return false;
                }

                $.ajax({
                    url: '{{route("user.save-preferences-group")}}',
                    type: "post",
                    datatype: "json",
                    data: {
                        name: group_name,
                        id  : group_id
                    },
                }).done(function(data) {
                    if (data.success) {
                        getUserPreferences();
                        swal('Success!', data.message, 'success');
                        return false;
                    } else {
                        swal({
                            title: "Error!!",
                            text: data.message,
                            type: "error",
                            showCancelButton: false,
                            confirmButtonColor: '#DD6B55',
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            $('#addNewUserPreferencesGroup').trigger('click');
                        });

                        return false;
                    }
                }).fail(function(jqXHR, ajaxOptions, thrownError) {

                });
            }
        });
    }
}

function deleteUserPreferencesGroup(element) {

  var group_id = $(element).attr('data-group-id');

    swal({
        title: "Please Confirm",
        text: "Would you like to delete selected group?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes',
        cancelButtonText: "No, Cancel it!"
    }).then((result) => {
        if (result.value) {

            $.ajax({
                url: '{{route("user.delete-preferences-group")}}',
                type: "post",
                datatype: "json",
                data: {
                    id  : group_id
                },
            }).done(function(data) {
                if (data.success) {
                    getUserPreferences();
                    swal('Success!', data.message, 'success');
                    return false;
                } else {
                    swal('Error!!', data.message, 'error');
                    return false;
                }
            }).fail(function(jqXHR, ajaxOptions, thrownError) {

            });
        }
    });
}

// function saveUserPreferencesGroupTag(element) {

//   var htmlStr = '';

//   htmlStr = '<input type="text" class="form-control" name="tag_name" id="tag_name">';

//   if (htmlStr.length > 0) {
//       swal({
//           title: "Tag Name",
//           html: htmlStr,
//           type: "info",
//           showCancelButton: true,
//           confirmButtonColor: '#DD6B55',
//           confirmButtonText: 'Create',
//           cancelButtonText: "No, Cancel it!"
//       }).then((result) => {
//           if (result.value) {
//               var group_id = $(element).attr('data-group-id');
//               var tag_name = $('#tag_name').val();

//               if (tag_name == '') {
//                   swal({
//                       title: "Error!!",
//                       text: 'Please enter tag name',
//                       type: "error",
//                       showCancelButton: false,
//                       confirmButtonColor: '#DD6B55',
//                       confirmButtonText: 'Ok',
//                   }).then((result) => {
//                       $('#addNewTag'+group_id).trigger('click');
//                   });

//                   return false;
//               }

//               $.ajax({
//                   url: '{{route("user.save-preferences-group-tag")}}',
//                   type: "post",
//                   datatype: "json",
//                   data: {
//                       name: tag_name,
//                       group_id: group_id
//                   },
//               }).done(function(data) {
//                   if (data.success) {
//                       getUserPreferences();
//                       swal('Success!', data.message, 'success');
//                       return false;
//                   } else {
//                       swal({
//                           title: "Error!!",
//                           text: data.message,
//                           type: "error",
//                           showCancelButton: false,
//                           confirmButtonColor: '#DD6B55',
//                           confirmButtonText: 'Ok',
//                       }).then((result) => {
//                           $('#addNewTag'+group_id).trigger('click');
//                       });

//                       return false;
//                   }
//               }).fail(function(jqXHR, ajaxOptions, thrownError) {

//               });
//           }
//       });
//   }
// }
</script>
@endsection