@extends('layouts.app')
@section('pagewise_css')
        <style type="text/css">

            #printable { display: none; }

            @media print
            {
                #non-printable { display: none; }
                #printable { display: block; }
            }
        </style>
@endsection
@section('content')
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-8 col-10">
                    <h6 class="h2 text-white d-inline-block mb-0">{{$title}}</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{route('admin.content.list')}}">Content</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-3 col-2 text-right">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--6">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
             <div class="alert alert-custom alert-{{ $msg }} alert-dismissible alert-dismissible fade show mb-2" role="alert">
                <div class="alert-text">{{ Session::get('alert-' . $msg) }}</div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
        @endif
    @endforeach
    <!-- Card stats -->
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-8">
                    <h5 class="h3 mb-0">{{$content->main_title}}</h5>
                </div>
                <div class="col-4 text-right">
                    <a href="{!! url('admin/content') !!}" class="btn btn-sm btn-neutral">Back</a>
                </div>
            </div>
        </div>
        <div class="p-4 " id="printableArea">
            <div class="row">
                <div class="col-md-5 col-sm-5 col-xs-12">
                    <div class="tuto-main-image noprint">
                        <a class="image" href="" id="lightgallery" data-image="{{asset($content->main_image_url)}}" data-maintitle="{{$content->main_title}}" >
                            <img class="img-fluid" style="filter: blur(0px);" src="{{asset($content->main_image_url)}}">
                        </a>
                    </div>
                </div>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <div class="tuto-details-box">
                        <p class="mt-0">{{$content->description}}</p>
                        <div class="tuto-items-container">
                            <div class="alert alert-secondary fade show" role="alert">
                                <span class="alert-icon"><i class="fas fa-user"></i></span>
                                <span class="alert-text">Author</span>
                                <span class="alert-text-right"><strong>{{ isset($content->content_user->name) ? $content->content_user->name : ''}}</strong></span>
                            </div>
                            <div class="alert alert-secondary fade show" role="alert">
                                <span class="alert-icon"><i class="fas fa-tag"></i></span>
                                <span class="alert-text">Category</span>
                                @php
                                    $category_name = !empty($content->content_category->name) ? $content->content_category->name : '';
                                @endphp
                                <span class="alert-text-right"><strong>{{ $category_name }}</strong></span>
                            </div>
                            <div class="alert alert-secondary fade show" role="alert">
                                <span class="alert-icon"><i class="ni ni-world"></i></span>
                                <span class="alert-text">Link</span>
                                <span class="alert-text-right"><strong>{{$content->external_link}}</strong></span>
                            </div>
                            <div class="alert alert-secondary fade show" role="alert">
                                <span class="alert-icon"><i class="fas fa-calendar"></i></span>
                                <span class="alert-text">Posted At</span>
                                <span class="alert-text-right"><strong>{{!empty($content->posted_at) ? date('j F, Y', strtotime($content->posted_at)) : ''}}</strong></span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div id="Introduction" class="mt-4">
                @if($content->introduction)
                    <h2 class="display-3 mb-0">Summary</h2>
                    <p>{!!$content->introduction!!}</p>
                    <hr>
                @endif
                @if($content->introduction_video_link)
                    <h2 class="display-3 mb-0">Video overview</h2>
                    @php
                        $videoUrl = $content->introduction_video_link;
                        $videoUrl = getYoutubeOrVimeoFromURL($videoUrl);
                    @endphp

                    <div class="embed-responsive embed-responsive-16by9" id="non-printable">
                        <iframe class="embed-responsive-item" class="text-center" src="{{$videoUrl}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <hr>
                @endif
            </div>

            @if($content->content_step)
            @php $step = 1; @endphp
                @foreach($content->content_step as $stepkey => $stepdata)
                    <div id="Step_{{$step}}_-_{{\Str::slug($stepdata->title, '_')}}" class="mt-4">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div id="carousel-step{{$step}}" class="carousel slide carousel-fade carousel-thumbnails carousel-thumbnails-bottom" data-ride="carousel" data-interval="false">
                                      <!--Slides-->
                                      <div class="carousel-inner lightgallery" style="cursor: pointer;" data-id="{{$stepdata->id}}" title="Show Image">
                                        @if($stepdata->media)
                                            @foreach($stepdata->media as $media)

                                            @php
                                                $extension       = pathinfo(storage_path($media->media_url), PATHINFO_EXTENSION);
                                                $audioExtensions = config('default.audio_extensions');
                                                $mediaUrl        = asset($media->media_url);
                                            @endphp

                                                @if(!empty($audioExtensions) && !empty($extension) && in_array($extension, $audioExtensions))
                                                {
                                                    <div class="carousel-item @if($loop->first) active @endif">
                                                        <div class="d-block">
                                                            <audio controls>
                                                                <source src="{!! $mediaUrl !!}" type="audio/mpeg">
                                                                Your browser does not support the audio element.
                                                            </audio>
                                                        </div>
                                                    </div>
                                                }
                                                @else
                                                    <div class="carousel-item @if($loop->first) active @endif">
                                                        <img class="d-block" src="{!! $mediaUrl !!}" alt="First slide">
                                                    </div>
                                                @endif

                                            @endforeach
                                        @endif

                                        @if($stepdata->video_media)
                                            <div class="carousel-item @if(count($stepdata->media) == 0) active @endif step-item-video">
                                                @php $videoUrl = getYoutubeOrVimeoFromURL($stepdata->video_media); @endphp
                                                <iframe class="embed-responsive-item" class="text-center" src="{{$videoUrl}}" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            </div>
                                        @endif
                                      </div>
                                      <!--/.Slides-->
                                      <!--/.Controls-->
                                      <ol class="carousel-indicators">
                                        @if($stepdata->media)
                                        @php $dataslide = 0; @endphp
                                            @foreach($stepdata->media as $media)
                                                @php
                                                    $extension       = pathinfo(storage_path($media->media_url), PATHINFO_EXTENSION);
                                                    $audioExtensions = config('default.audio_extensions');
                                                    $thumbUrl        = asset($media->media_url);

                                                    if(!empty($audioExtensions) && !empty($extension) && in_array($extension, $audioExtensions))
                                                    {
                                                        $thumbUrl = asset('assets/img/icons/audio.png');
                                                    }
                                                @endphp

                                                <li data-target="#carousel-step{!! $step !!}" onmouseover="bigImg(this,'image')" data-slide-to="{{$dataslide}}" @if($loop->first) class="active" @endif >
                                                    <img class="d-block" src="{!! $thumbUrl !!}" class="img-fluid">
                                                </li>

                                                @php $dataslide++; @endphp
                                            @endforeach
                                        @endif

                                        @if($stepdata->video_media)
                                            <li data-target="#carousel-step{{$step}}" onmouseover="bigImg(this,'video')" data-slide-to="{{$dataslide}}" class="step-video-li">
                                                <img class="d-block img-fluid step-video-icon" src="{{asset('assets/img/icons/'.$stepdata->video_type.'.png')}}" >
                                            </li>
                                        @endif
                                      </ol>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-{{(count($stepdata->media) > 0 || $stepdata->video_media != '') ? '6' : '12'}} step-instructions">
                                <h3 class="display-4">Media {{$step}} - {{$stepdata->title}}</h3>
                            </div>
                        </div>
                    </div>
                   @if($stepdata != $loop->last) <hr> @endif
                @php $step++; @endphp
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection

@section('pagewise_js')
<script type="text/javascript">
var elementArr = new Array();
    @php
        if($content->content_step){
            foreach($content->content_step as $stepdata){
                if($stepdata->media){
    @endphp
                    var mediaArr = new Array();
    @php
                    foreach ($stepdata->media as $media){
    @endphp
                        mediaArr.push({src: '{{asset($media->media_url)}}', thumb: '{{asset($media->media_url)}}', subHtml : '{{$stepdata->title}}'});
    @php
                    }
                }
    @endphp
                elementArr['{{$stepdata->id}}'] = mediaArr;
    @php
            }
        }
    @endphp
jQuery(document).ready(function($){
    $('.lightgallery').on('click', function(e) {
        e.preventDefault();
        var ids = $(this).data('id');

        $(this).lightGallery({
            dynamic: true,
            dynamicEl: elementArr[ids],
            download:false,
            fullScreen:false,
            zoom:false,
            share:false,
            autoplay:false,
            autoplayControls:false,
        })
    });

    $('#lightgallery').on('click', function(e) {
        e.preventDefault();
        var url = $(this).data('image');
        var title = $(this).data('maintitle');

        $(this).lightGallery({
            dynamic: true,
            dynamicEl: [{src: url, thumb: url, subHtml : title}],
            download:false,
            fullScreen:false,
            zoom:false,
            share:false,
            autoplay:false,
            autoplayControls:false,
        })
    });

    $(".togglelink").click(function(e){
        e.preventDefault();
        $($(this).attr('href')).slideToggle();
        if ($(this).text() == "hide")
           $(this).text("show")
        else
           $(this).text("hide");
    });

    $("#content-sr li a[href^='#']").on('click', function(e) {
       e.preventDefault();
       var hash = this.hash;
       // animate
       return $('html, body').animate({
           scrollTop: $(hash).offset().top-20
         }, 1000, function(){
           // /window.location.hash = hash;
           return window.history.pushState(null, null, hash)
         });

    });
});

function bigImg(x,type) {
    x.click();

}

function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}
</script>
@endsection
