@extends('layouts.app')
@section('content')
<!-- Main content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary mt-4 py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-3">
              <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                  <span class="Small-Title">Welcome to {{env('APP_NAME')}}</span>
                </div>
              </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 ">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card border-1 mb-0">

            <div class="card-body ">
                @if(Session::has('alert-success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                        <span class="alert-inner--text"><strong>Success!</strong> {{Session::get('alert-success')}}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                @endif

                @php
                    $isCreator = isset($isCreator) ? 1 : 0;
                @endphp

                <div class="text-center text-muted mb-4">
                  @if($isCreator)
                    <span>Creator Log in</span>
                  @else
                    <span>Log in</span>
                  @endif
                </div>

                <form role="form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="user_type" value="{!! $isCreator ? 1 : 0 !!}" >
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                        <div class="input-group input-group-alternative">
                            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}" autofocus>
                        </div>
                        @if ($errors->has('email'))
                            <div class="invalid-feedback" style="display: block;" role="alert">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <div class="input-group input-group-alternative">
                            <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" type="password" >
                        </div>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                    <div class="custom-control custom-control-alternative custom-checkbox">
                        <input class="custom-control-input" name="remember" id="customCheckLogin" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="customCheckLogin">
                            <span class="text-muted">{{ __('Remember me') }}</span>
                        </label>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary my-4">{{ __('Log in') }}</button>
                    </div>
                </form>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-6">
              <a href="{{ route('password.request') }}" class=""><small>{{ __('Forgot Password?') }}</small></a>
            </div>
            <div class="col-6 text-right">
              @if($isCreator)
              <a href="{{ route('creator-register') }}" class=""><small>{{ __('Create New Creator Account') }}</small></a>
              @else
              <a href="{{ route('register') }}" class=""><small>{{ __('Create New Account') }}</small></a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
