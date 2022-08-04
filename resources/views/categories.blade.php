@extends('layouts.app')

@section('content')

<main class="main">

  <div class="header bg-gradient-primary pt-lg-3">
    <div class="container">
      <div class="header-body text-center ">
        <div class="row ">
          <div class="col-xl-12 col-lg-12 col-md-12 px-3 text-left">
            <span class="Small-Title">Categories</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container pt-lg-3">
    <!--start Category Section-->

    <div class="row">
      <!--Start Slider-->
      @if($categories->count() > 0)
          @foreach ($categories as $item)
            <div class="col-md-3">
              <div class="item">
                <div class="CategoryBox"> <a href="{{route('categories.get-items', $item->hashid)}}">
                  <div class="boximg"> <img src="{{!empty($item->icon_url) ? $item->icon_url : asset('assets/img/no_img.jpg')}}" alt="" width="256" height="160"> </div>
                  <div class="description">
                    <h4>{!! $item->name !!}</h4>
                  </div>
                  </a>
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
