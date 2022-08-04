<!--Start Header-->
<header id="header">

  <!-- Start Site Header -->
  <section class="site-header">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <aside class="logo"> <a class="navbar-brand" href="{{url('home')}}"><img src="{{ asset('assets/img/logo.svg') }}" alt=""></a> </aside>

        <div class="header-center">
          <!-- Actual search box -->
          <form method="GET" action="{{route('results')}}">
            {{-- <form method="GET" action="#"> --}}
            <div class="has-search"> <span class="fa fa-search form-control-feedback"></span>
              <input name="search" type="text" class="form-control" placeholder="Search" value="{{ request()->get('search')}}">
            </div>
          </form>
        </div>

        <div class="btn-menu">
          <ul>
            <li class="top-right-ellipse-li"><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-ellipsis-v"></i></a>
              <ul class="dropdown-menu dropdown-menu-right">
                @if(isset(Auth::user()->id))
                  <li class="nav-item"> <a class="nav-link" href="{{url('profile_settings')}}"> <span class="font-16"><i class="fal fa-cog"></i> Settings</span></a> </li>
                  <li class="nav-item"> <a class="nav-link" href="{{url('account')}}"> <span class="font-16"><i class="fal fa-user"></i> My Account</span></a> </li>

                {{-- <li class="nav-item"> <a class="nav-link" id="ShowFooter" href="javascript:void(0);"> <span class="font-16"><i class="fal fa-square"></i> Footer</span></a> </li> --}}

                  {{-- <li class="nav-item"> <a class="nav-link" id="" href="{{url('trending')}}"> <span class="font-16"><i class="fal fa-align-justify"></i> Trending</span></a> </li>
                  <li class="nav-item"> <a class="nav-link" id="" href="{{url('latest')}}"> <span class="font-16"><i class="fal fa-align-justify"></i> Latest</span></a> </li> --}}
                  <li class="nav-item"> <a class="nav-link" href="{{route('logout')}}">  <span class="font-16"><i class="fal fa-sign-out"></i> Log out</span></a> </li>
                 @else
                  <li class="nav-item"> <a class="nav-link" id="" href="javascript:void(0);" data-toggle="modal" data-target="#loginModalPrompt"> <span class="font-16"><i class="fal fa-sign-in"></i> Login</span></a> </li>
                  <li class="nav-item"> <a class="nav-link" id="" href="{{url('register')}}" > <span class="font-16"><i class="fal fa-user-plus"></i> Sign up</span></a> </li>
                  @endif
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</header>

<div class="header-sec-top">
    <div class="header-sec-top-part">
      @if(isset($interest_last_updated_at) && !empty($interest_last_updated_at))
      <p class="head-time user-interest-head-time">{{ date('Y/m/d', strtotime($interest_last_updated_at)) }} </p>
      @elseif(!empty(Auth::user()->interest_last_updated_at))
      <p class="head-time user-interest-head-time">{{ date('Y/m/d', strtotime(Auth::user()->interest_last_updated_at)) }} </p>
      @endif
      <h4 class="m-0 user-interest-head-title">{{ isset($interest_title) ? $interest_title : (!empty(Auth::user()->interest_title) ? Auth::user()->interest_title : 'Let your interests find you')}}</h4>
    </div>
    @php
      $pageName = isset($page->id) ? $page->url_slug : '';
    @endphp
    @if(isset($interest_title) || (isset(Auth::user()->id) && Route::currentRouteName() != 'home' && Route::currentRouteName() != 'register' && $pageName != 'about-us' && $pageName != 'privacy-policy' && $pageName != 'terms-conditions' && !empty(Route::currentRouteName())))
      <div class="header-sec-link btn-receita" id="btn-receitamob" data-clicked-times="0"> <span class="custom-scroll-link"><i class="fal fa-chevron-double-down" id="seta"></i></span> </div>
      <div id="receita-div" style="display: none; height: 250px; border: 1px solid #ccc; border-top: 0;" class="{{Route::currentRouteName() != 'profile.edit' ? 'receita-hidden' : 'user-ineresest-wrap'}}">

          @if(Route::currentRouteName() == 'profile.edit')

            <form role="form" method="POST" action="" class="">
                @csrf

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group{{ $errors->has('interest_title') ? ' has-danger' : '' }} text-left">
                        <div class="input-group input-group-alternative">
                            <input class="form-control" placeholder="{{ __('Slogan') }}" maxlength="60" type="text" name="interest_title" id="interest_title" value="{{ isset(Auth::user()->interest_title) ? Auth::user()->interest_title : '' }}">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('interest_description') ? ' has-danger' : '' }} text-left">
                        <div class="input-group input-group-alternative">
                            <textarea class="form-control" placeholder="{{ __('Description') }}" name="interest_description" id="interest_description" >{{ isset(Auth::user()->interest_description) ? Auth::user()->interest_description : '' }}</textarea>
                        </div>
                    </div>

                    <div class="form-group login-btn">
                      <button type="button" class="btn btn-primary  text-uppercase w-100 save-user-interest">Save</button>
                    </div>
                  </div>
                </div>

            </form>
          @else
            <div class="row">
              <div class="col-md-12 user-ineresest-head-dec-wrap">
                @if(isset($interest_description))
                  {{$interest_description}}
                @else
                  {{ isset(Auth::user()->interest_description) ? Auth::user()->interest_description : '' }}
                @endif
              </div>
            </div>
          @endif

      </div>
    @endif
</div>
