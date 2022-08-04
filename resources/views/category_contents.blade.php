@extends('layouts.app')

@section('content')

<main class="main">

  <div class="header bg-gradient-primary pt-lg-3">
    <div class="container">
      <div class="header-body text-center ">
        <div class="row justify-content-center">
          <div class="col-xl-5 col-lg-6 col-md-8 px-5">
            <span class="Small-Title">Contents</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container pt-lg-3">
    <!--start Content Section-->

    <div class="row align-items-center mb20">
        <div class="col-lg-6 col-7">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark pl-0">
                  <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{route('categories')}}">Categories</a></li>
                  <li class="breadcrumb-item">{{$categoryName}}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
      <!--Start Slider-->
      @if($results->count() > 0)
          @foreach ($results as $item)
            <div class="col-md-3">
              <div class="item">
                <div class="SliderBox">
                  <div class="boximg"> <img src="{{!empty($item->main_image_url) ? $item->main_image_url : asset('assets/img/no_img.jpg')}}" alt="" class="w-100"> </div>
                  <div class="description">
                    <h3><a href="{!! route('result.get-details', $item->hashid) !!}">{!! $item->main_title !!}</a></h3>
                    <div class="d-flex align-items-center">
                      <div class="avtar"><img src="{{$item->content_user->user_image_url}}" class="rounded-circle"></div>
                    <div> <a href="javascript:void(0)">{{$item->content_user->name}}</a>
                        <p>{{$item->content_category->name}}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
      @else
        <div class="col-md-12 col-sm-12 text-center">
          No records available
        </div>
      @endif
      <!--End Slider-->
    </div>
  </div>
  <!--End main Part-->
</main>
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
