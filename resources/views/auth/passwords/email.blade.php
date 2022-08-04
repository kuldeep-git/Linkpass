@extends('layouts.app')
@section('content')
<!-- Main content -->
<div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary mt-4 py-7 py-lg-8">
        <div class="container">
        </div>
    </div>

    <div class="container mt--8">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card border-1 mb-0">
                    <div class="card-body">
                        <div class="text-center text-muted mb-4">
                            <span>{{ __('Reset password') }}</span>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form role="form" method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                                <div class="input-group input-group-alternative">
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}"  autofocus>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert" >
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">{{ __('Send Password Reset Link') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">

                    </div>
                    <div class="col-6 text-right">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#loginModalPrompt">
                            {{ __('Login') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
