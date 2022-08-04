@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->name,
        'description' => __('You can change the password from here.'),
        'class' => 'col-lg-12'
    ])

    <div class="container-fluid mt--7 pb-5">
        <div class="row">
            <div class="col-xl-4 order-xl-1 mb-5 mb-xl-0">
                @include('profile.left-bar-links')
            </div>
            <div class="col-xl-8 order-xl-2">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center ">
                            <h4 class="mb-0 ml-3">{{ __('Change Password') }}</h4>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <form method="post" action="{{ route('profile.password') }}" autocomplete="off" >
                            @csrf
                            @method('put')

                            @if (session('password_status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('password_status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="form-group">
                                    <div class="{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                        <input type="password" name="old_password" id="input-current-password" class="form-control {{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Current Password') }}" value="" >

                                        @if ($errors->has('old_password'))
                                            <span class="invalid-feedback"  role="alert">
                                               {{ $errors->first('old_password') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="{{ $errors->has('password') ? ' has-danger' : '' }}">
                                        <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" value="" >

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('password') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative" placeholder="{{ __('Confirm New Password') }}" value="" >
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="default-btn mt-4">{{ __('Change password') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagewise_js')
<script type="text/javascript">

</script>
@endsection