@extends('layouts.app')

@section('content')


<header class="masthead" style="background-image:url('{{asset('assets/img/home-bg.jpg')}}');">
    <div class="overlay"></div>
    <div class="container">
        <form method="get" action="{{route('results')}}">
            <div class="row">
                <div class="col-md-10 col-lg-8 mx-auto">
                    <div class="site-heading" style="font-size: 24px;margin:100px;">
                        <div class="form-group">
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input class="form-control" name="search" placeholder="Search" type="text">
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</header>

<div class="article-list">
    <div class="container">
       <div class="intro">
          <h2 class="text-center">Latest</h2>
       </div>
       @if($latest->count() > 0)
       <div class="row articles">

          @foreach ($latest as $item)
            <div class="col-sm-6 col-md-3 item">
                <div class="item-wrap">
                    <a href="{!! route('result.get-details', $item->id) !!}">
                        <img width="225" height="150" src="{{!empty($item->main_image_url) ? $item->main_image_url : asset('assets/img/no_img.jpg')}}">
                    </a>
                    <h3 class="name">{!! $item->main_title !!}</h3>
                    <p class="description">{!! $item->description !!}</p>
                    <a class="action" href="{!! route('result.get-details', $item->id) !!}"><i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
          @endforeach

          <div class="col-md-12 col-sm-12 text-right view-all">
            <a href="{!! url('latest') !!}">View All</a>
          </div>
       </div>
       @else
       <div class="col-md-12 col-sm-12 text-center">
         No records available
       </div>
       @endif

    </div>
 </div>

 <div class="article-list">
    <div class="container">
       <div class="intro">
          <h2 class="text-center">Trending</h2>
       </div>
       @if($trending->count() > 0)
       <div class="row articles">

          @foreach ($trending as $item)
            <div class="col-sm-6 col-md-3 item">
                <div class="item-wrap">
                    <a href="{!! route('result.get-details', $item->id) !!}">
                        <img width="225" height="150" src="{{!empty($item->main_image_url) ? $item->main_image_url : asset('assets/img/no_img.jpg')}}">
                    </a>
                    <h3 class="name">{!! $item->main_title !!}</h3>
                    <p class="description">{!! $item->description !!}</p>
                    <a class="action" href="{!! route('result.get-details', $item->id) !!}"><i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
          @endforeach

          <div class="col-md-12 col-sm-12 text-right view-all">
            <a href="{!! url('trending') !!}">View All</a>
          </div>
       </div>
       @else
       <div class="col-md-12 col-sm-12 text-center">
         No records available
       </div>
       @endif

    </div>
 </div>

 <div class="article-list">
    <div class="container">
       <div class="intro">
          <h2 class="text-center">Categories</h2>
       </div>
       @if($trending->count() > 0)
       <div class="row articles">

          @foreach ($categories as $item)
            <div class="col-sm-6 col-md-3 item">
                <div class="item-wrap">
                    <a href="#">
                        <img width="225" height="150" src="{{!empty($item->icon_url) ? $item->icon_url : asset('assets/img/no_img.jpg')}}">
                    </a>
                    <h3 class="name">{!! $item->name !!}</h3>
                    <a class="action" href="#"><i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
          @endforeach

          <div class="col-md-12 col-sm-12 text-right view-all">
            <a href="#">View All</a>
          </div>
       </div>
       @else
       <div class="col-md-12 col-sm-12 text-center">
         No records available
       </div>
       @endif

    </div>
 </div>



<style>
    /* Search Box - Start */
    header.masthead {
        margin-bottom: 50px;
        background: no-repeat 50%;
        background-color: #6c757d;
        background-attachment: scroll;
        position: relative;
        background-size: cover;
        height: 350px;
    }
    header.masthead .overlay {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: #212529;
        opacity: .5;
    }
     /* Search Box - End */

    /* Content List - Start */
    .article-list {
        color: #313437;
        background-color: #fff;
    }
    .article-list h2 {
        font-weight: bold;
        padding-top: 20px;
        color: inherit;
        text-decoration: underline;
    }
    .article-list .intro p {
        margin-bottom: 0;
    }
    .article-list p {
        color: #7d8285;
    }
    .article-list .intro {
        font-size: 16px;
        max-width: 500px;
        margin: 0 auto;
    }
    .article-list .item {
        padding-top: 20px;
        min-height: 350px;
        text-align: center;
    }
    .article-list .item-wrap {
        border: 1px solid #17408B;
        padding: 15px;
        border-radius: 10px;
    }
    .article-list .articles {
        padding-bottom: 40px;
    }
    .article-list .item .name {
        font-weight: bold;
        font-size: 16px;
        margin-top: 20px;
        color: inherit;
    }
    .article-list .item .description {
        font-size: 14px;
        margin-top: 15px;
        margin-bottom: 0;
    }
    .article-list .item .action {
        font-size: 24px;
        width: 24px;
        margin: 22px auto 0;
        line-height: 1;
        display: block;
        color: #4f86c3;
        opacity: 0.85;
        transition: opacity 0.2s;
        text-decoration: none;
    }
    .article-list .view-all{
        text-decoration: underline;
        font-weight: bold;
    }
    /* Content List - End */
</style>


@endsection
