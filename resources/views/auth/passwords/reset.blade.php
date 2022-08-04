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

    <div class="container mt--8">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card border-1 mb-0">
                    <div class="card-body">
                        <div class="text-center text-muted mb-4">
                            <span>{{ __('Reset Password') }}</span>
                        </div>
                        <form role="form" method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                                <div class="input-group input-group-alternative">
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ $email ?? old('email') }}" autofocus>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative">
                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" type="password">
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('password') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <input class="form-control" placeholder="{{ __('Confirm Password') }}" type="password" name="password_confirmation">
                                </>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">{{ __('Reset Password') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
