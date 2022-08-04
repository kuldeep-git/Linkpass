<!doctype html>
<!--[if IE 8]> <html class="no-js lt-ie9 ie8" lang="en"> <![endif]-->
<!--[if IE 9]> <html class="ie9" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->


<head>
  <meta charset="utf-8">
  <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta name="author" content="">
  <meta name="description" content="">
  <meta Http-Equiv="Cache-Control" Content="no-cache">
  <meta Http-Equiv="Pragma" Content="no-cache">
  <meta Http-Equiv="Expires" Content="0">
  <title>{{ config('app.name', 'LinkPasser') }}</title>
  <!-- Favicon -->
  <link rel="icon" href="{{asset('assets/img/favicon.png')}}" type="image/png">

  <!-- Owl Stylesheets -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick-theme.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.carousel.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.theme.default.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/dropzone/dist/min/dropzone.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">

  <!-- datatables CSS -->
  <link rel="stylesheet" href="{{asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/datatables.net/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/datatables.net/css/responsive.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">

  <!-- Fonts Fontawesome -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome-all.css') }}">

  <link rel="stylesheet" href="{{asset('assets/css/front-custom.css')}}" type="text/css">

  <!-- CSS bootstrap Plugin  -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link href="{{ asset('assets/css/bootstrap-switch-button.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/css/stellarnav.css') }}">
  <!-- Animation STYLESHEETS-->

  <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}">

  <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/contextmenu/jquery.contextMenu.css') }}">

  <!-- Style -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="{{ asset('assets/js/ie10-viewport-bug-workaround.js') }}"></script>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="{{asset('assets/js/html5shiv.js')}}"></script>
        <script src="{{asset('assets/js/respond.min.js')}}"></script>
      <![endif]-->

  <!-- HEADER SCRIPTS	-->
  @yield('pagewise_css')
</head>

<body>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

  <!-- Main content -->
  <div id="wrapper">
    @include('layouts.header')
    <!-- Header -->
    @yield('content')

    @include('layouts.footer')
    <!-- Modal -->
      <div class="modal fade bd-example-modal-md" id="loginModalPrompt" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header py-3">
              <h4 class="modal-title text-light">LinkPasser Login</h4>
              <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
              <form role="form" method="POST" id="post-login-form" action="{{ route('post-login') }}">
                @csrf
                <input type="hidden" name="loginPrompt" value="1">
                <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                  <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required autofocus>
                  @if ($errors->has('email'))
                      <div class="invalid-feedback text-left" style="display: block;" role="alert">
                          {{ $errors->first('email') }}
                      </div>
                  @endif
                </div>
                <div class="form-group">
                  <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" type="password" required >
                  @if ($errors->has('password'))
                      <span class="invalid-feedback text-left" style="display: block;" role="alert">
                          {{ $errors->first('password') }}
                      </span>
                  @endif
                </div>
                <div class="form-group radioeffect magic-radio-group text-left">
                  <span>
                    <input name="auser_type" value="0" id="aradio1" class="css-checkbox radioshow magic-radio" type="radio"  checked="">
                    <label for="aradio1" class="css-label radGroup1">User</label>
                  </span>
                  <span>
                    <input name="auser_type" value="1" id="aradio2" class="css-checkbox radioshow magic-radio" type="radio" >
                    <label for="aradio2" class="css-label radGroup1">Creator</label>
                  </span>
                </div>

                <div class="form-group login-btn">
                  <button type="submit" id="loginBtn" class="btn btn-primary  text-uppercase w-100">Log in</button>
                </div>
                <div class="text-center"> <a href="{{ route('password.request') }}">Forgot Password?</a> </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Setup of jquery JS -->
  <script src="{{asset('assets/js/jquery-3.3.1.min.js')}}"></script>
  <script src="{{asset('assets/js/moment.min.js')}}"></script>
  <script src="{{asset('assets/js/popper.min.js')}}"></script>

  <!-- Setup of Bootstrap JS -->
  <script type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap-switch-button.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery.conditional-fields.js')}}"></script>
  <!-- Setup of Slider JS -->
  <script src="{{asset('assets/js/slick.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('assets/js/owl.carousel.js')}}" type="text/javascript"></script>

  <!-- datatables JS -->
  <script src="{{asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('assets/vendor/datatables.net/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
  <script src="{{asset('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
  <script src="{{asset('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
  <script src="{{asset('assets/vendor/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
  <script src="{{asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js')}}"></script>

  <script src="{{asset('assets/vendor/dropzone/dist/min/dropzone.min.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
  <script src="{{asset('assets/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
  <script src="{{asset('assets/vendor/select2/dist/js/select2.min.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
  <script src="{{asset('assets/vendor/emoji/emoji.min.js')}}"></script>

  <script src="{{asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

  <script src="{{asset('assets/vendor/contextmenu/jquery.contextMenu.min.js')}}"></script>
  <script src="{{asset('assets/vendor/contextmenu/jquery.ui.position.js')}}"></script>

  <!-- Toastr -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

  <!-- Setup of Menu JS -->
  <script type="text/javascript" src="{{asset('assets/js/stellarnav.js')}}"></script>
  <!-- Setup of Custom JS -->
  <script type="text/javascript" src="{{asset('assets/js/custom.js')}}"></script>

  <script src="{{asset('assets/vendor/js-cookie/js.cookie.js')}}"></script>
  <script src="{{asset('assets/js/argon.js?v=1.1.0')}}"></script>
  <!-- Google recaptcha-->
  <script src="https://www.google.com/recaptcha/api.js"></script>

  <script>
    var btn = $('#backtop');

    $(window).scroll(function() {
      if ($(window).scrollTop() > 300) {
        btn.addClass('show');
      } else {
        btn.removeClass('show');
      }
    });

    btn.on('click', function(e) {
      e.preventDefault();
      $('html, body').animate({scrollTop:0}, '300');
    });

    $("form#post-login-form").submit(function(e){
      e.preventDefault();
        $.ajax({
            url: '{{route("post-login")}}',
            type: "post",
            dataType : 'json',
            data:$("#post-login-form input").serialize()
        }).done(function(data) {
            if(data.success)
            {
              window.location = data.redirectUrl;
            }
            else
            {
              swal('Log in Failed!!', data.message, 'error');
            }
        });
    });

  </script>
  @yield('pagewise_js')
  @if($errors->has('email') || $errors->has('password'))
      <script>
      $(function() {
        var currentUrl = '{{Route::currentRouteName()}}';

        // if(currentUrl != 'home' || currentUrl != 'profile.edit')
        // {
        //     $('#loginModalPrompt').modal({
        //         show: true
        //     });
        // }
      });
      </script>
  @endif
  <script>
    @if(Session::has('alert-success'))
    toastr.options =
    {
      "closeButton" : true,
      "progressBar" : true
    }
        toastr.success("{{ session('alert-success') }}");
    @endif

    @if(Session::has('alert-error'))
    toastr.options =
    {
      "closeButton" : true,
      "progressBar" : true
    }
        toastr.error("{{ session('alert-error') }}");
    @endif

    @if(Session::has('alert-info'))
    toastr.options =
    {
      "closeButton" : true,
      "progressBar" : true
    }
        toastr.info("{{ session('alert-info') }}");
    @endif

    @if(Session::has('alert-warning'))
    toastr.options =
    {
      "closeButton" : true,
      "progressBar" : true
    }
        toastr.warning("{{ session('alert-warning') }}");
    @endif
  </script>
</body>

</html>