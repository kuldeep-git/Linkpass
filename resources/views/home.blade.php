@extends('layouts.app')

@section('content')

<main class="main">
  <article class="container">
    {{-- <div class="Trding">
      <ul class="LinkVerb d-flex justify-content-center">
        <li><a href="#">Trading</a></li>
        <li><a href="#">Latest</a></li>
      </ul>
    </div> --}}
    <div class="row d-flex align-items-stretch">
      <aside class="col-lg-6">
        <div class="row">
          <aside class="col-lg-10">
            <div class="login-box text-center">
              <img width="300" src="{{asset('assets/img/LinkPasser-Text.svg')}}" alt="LinkPasser" class="mb-4"/>

              <form role="form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                  <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required autofocus>
                  @if ($errors->has('email'))
                      <div class="invalid-feedback text-left" style="display: block;" role="alert">
                          {{ $errors->first('email') }}
                      </div>
                  @endif
                </div>
                <div class="form-group">
                  <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password" placeholder="{{ __('Password') }}" type="password" required >
                  @if ($errors->has('password'))
                      <span class="invalid-feedback text-left" style="display: block;" role="alert">
                          {{ $errors->first('password') }}
                      </span>
                  @endif
                </div>
                <div class="form-group radioeffect magic-radio-group text-left">
                  <span>
                    <input name="user_type" value="0" id="radio1" class="css-checkbox radioshow magic-radio" type="radio" data-class="div1" checked="">
                    <label for="radio1" class="css-label radGroup1">Log in as a user</label>
                  </span>
                  <span>
                    <input name="user_type" value="1" id="radio2" class="css-checkbox radioshow magic-radio" type="radio" data-class="div2">
                    <label for="radio2" class="css-label radGroup1">Log in as a creator</label>
                  </span>
                </div>
                <div class="chiller_cb mb-3">
                  <input id="show-password" type="checkbox">
                  <label for="show-password" class="control-label">Show Password</label>
                  <span></span>
              </div>
                <div class="form-group login-btn">
                  <button type="submit" class="btn btn-primary text-uppercase w-100">Log in</button>
                </div>
                <a href="{{ route('password.request') }}">Forgot Password?</a>
                <h5 class="text-light mt-4 font-15">Want an account? <a href="{{ route('register') }}">Sign up</a></h5>
                <div class="or">
                  <p>Or</p>
                </div>
                <h5 class="text-light mt-4 font-15">Want to sign up as a Creator? <a href="{{ route('creator-register') }}">Sign up</a></h5>
              </form>
            </div>
          </aside>
        </div>
      </aside>
      <aside class="col-lg-6">
        <div class="bg-login d-flex align-items-center" style="background:#FFF;color:#666;">
          {{-- <div class="bg-login d-flex align-items-center" style="background: url({{ asset('assets/img/bg01.png') }}); background-size: cover; background-repeat: no-repeat;"> --}}
          <div class="div1 allshow">
            <p>
              Signing up on LinkPasser as a user allows you to
              share your interests with LinkPasser so that
              LinkPasser may find content that matches those
              interests and give it to you on a periodical basis.
              With this type of account you can also create
              your own content listing, to be discovered by
              others, and thereby becoming a hybrid of a user
              and creator account. This account is for
              individuals. If this account isn’t what you’re
              looking for, try the LinkPasser creator account!
            </p>
          </div>
          <div class="div2 allshow" style="display: none;">
            <p>
              Signing up on LinkPasser as a creator allows you
              to create content listings for your various content
              wherever it may be found. Your content listings
              will be matched to the interests of LinkPasser
              users. This type of account is for users who just
              want to list their content on LinkPasser so that it
              may be discovered by others. Nonindividuals,
              such as companies, should choose this account.
              If this account isn’t what you’re looking for, try
              the LinkPasser individual user account!
            </p>
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
$(document).ready(function() {

    var alertMsg = "{!! Session::has('alert-danger') ? Session::get('alert-danger') : '' !!}";

    if(alertMsg != '')
    {
      swal('Error!', alertMsg, 'error');
      return false;
    }
});
</script>
@endsection
