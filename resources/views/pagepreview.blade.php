@extends('layouts.app', ['title' => __('User Profile')])

@section('content')

<main class="main">
    <article class="container">
        <hr class="mb-3">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <aside class="col-lg-12">
                    <div class="border-0">
                        <div class="row align-items-center ">
                            <h4 class="mb-4 ml-3">{{ $page ? $page->title : ''}}</h4>
                        </div>
                    </div>
                    <div class="pt-0">
                        <form method="post" action="{{ route('user.send-enquiry') }}" autocomplete="off" enctype= "multipart/form-data">
                            @csrf

                            <div class="pl-lg-4">

                                @if(isset($page->id) && $page->url_slug == 'contact')

                                  <div class="form-group">
                                      {{-- <label class="form-control-label" for="input-name">{{ __('Name') }}</label> --}}
                                      <div class="{{ $errors->has('subject') ? ' has-danger' : '' }}">
                                          <input type="text" name="subject" id="input-name" class="form-control {{ $errors->has('subject') ? ' is-invalid' : '' }}" placeholder="{{ __('Subject') }}" value="{{ old('subject') }}" maxlength="25" autofocus required>

                                          @if($errors->has('subject'))
                                              <span class="invalid-feedback" role="alert">
                                                  {{ $errors->first('subject') }}
                                              </span>
                                          @endif
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      {{-- <label class="form-control-label" for="message">{{ __('message') }}</label> --}}
                                      <div class="{{ $errors->has('message') ? ' has-danger' : '' }}">
                                          <textarea rows="5" type="message" name="message" id="message" class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" placeholder="{{ __('Message') }}" maxlength="500" value="{{ old('message') }}" required></textarea>

                                          @if ($errors->has('message'))
                                              <span class="invalid-feedback" role="alert">
                                                  {{ $errors->first('message') }}
                                              </span>
                                          @endif
                                      </div>
                                  </div>

                                  <div class="form-group mt-3">
                                      <button type="submit" class="btn btn-primary  text-uppercase float-left w-50">Send</button>
                                      <a href="{{route('profile.edit')}}" class="btn btn-default  text-uppercase float-left ml-2 w-45">{{ __('Cancel') }}</a>
                                  </div>

                                @else
                                  {!! $page ? $page->content : '' !!}
                                @endif

                            </div>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </article>
</main>
@if(isset($page->id) && ($page->url_slug == 'privacy-policy' || $page->url_slug == 'terms-conditions'))
<style>
    ul{
        list-style-type:initial;
    }
    ul li, ol li
    {
        margin-left: 25px;
        margin-bottom:5px;
    }
    h1 {
        font-size: 32px;
        font-weight: bold;
        margin: 12px 0px 0 0px;
    }

    h3 {
        font-size: 26px;
        font-weight: 600;
        margin: 12px 0px 14px 0px;
    }
</style>
@endif
<!--End main Part-->
@endsection

@section('pagewise_js')
<script type="text/javascript">
      $(function() {
        var isLoggedIn = '{{isset(Auth::user()->id) ? 1 : 0 }}';
        var homeUrl = "{{url('home') }}";
        var pageName = "{{ isset($page->id) ? $page->url_slug : '' }}";

        if(isLoggedIn == 0 && pageName == 'contact')
        {
            $('#loginModalPrompt').modal({
                show: true
            });
        }

        $( ".close" ).click(function() {
          window.location = homeUrl;
        });
      });
</script>
@endsection