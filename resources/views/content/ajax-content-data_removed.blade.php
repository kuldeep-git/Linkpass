@php
    $userProfileClass = '';
    if($content->content_user->user_type == '0')
    {
        $userProfileClass = 'user-profile-bg';
    }
    if($content->content_user->user_type == '1')
    {
        $userProfileClass = 'creator-profile-bg';
    }
    if($content->content_user->user_type == '2')
    {
        $userProfileClass = 'hybrid-profile-bg';
    }
@endphp
<div class="row d-flex align-items-stretch">
    <aside class="col-lg-7">
      <div class="AddVideo mt-0 h-100">
        <div class="YoutubeLable"><span>{{$content->content_account->name}}</span></div>
        @php
        $category_name = isset($content->content_category->name) ? $content->content_category->name : '';
        @endphp
        <a href="javascript:void(0);" class="CategoryTitle">{{$category_name}}</a>
        <h4>{{$content->main_title}}</h4>
        <div class="VideoUser">
            <div class="mr-2 height-32 width-32 user-profile-avatar">
            <img src="{{$content->content_user->user_image_url}}" alt="" class="rounded-circle  {{$userProfileClass}}">
            </div>
        </div>
        <div class="">
          <div class="item">
            <div class="imgvid">
              <img src="{{ $content->main_image_url}}">
            </div>
          </div>
        </div>
        <ul class="d-flex justify-content-between">
          <li><a href="javascript:void(0);"><i class="fal fa-check"></i> <span>0</span></a></li>
          <li><a href="javascript:void(0);"><i class="fal fa-times"></i> <span>0</span></a></li>
          <li><a href="javascript:void(0);"><i class="far fa-share-alt"></i></a></li>
          <li><a href="javascript:void(0);"><i class="far fa-flag"></i></a></li>
        </ul>
        <p class="date"><span class="text-white text-uppercase badge badge-pill badge-info">Rate</span> <span>0 views</span></p>
        <div class="d-flex justify-content-between align-items-center">
            <span>{{ date("d M Y", strtotime($content->created_at)) }}</span>
            <span class="d-flex align-items-center">
                @php
                $creatorName = isset($content->content_user->name) ? $content->content_user->name : '';
                @endphp
                <div class="mr-2 height-32 width-32 user-profile-avatar">
                <img src="{{auth()->user()->user_image_url}}" alt="" class="rounded-circle  {{$userProfileClass}}">
                </div>
                <strong><a href="javascript:void(0);">{{$creatorName}}</a></strong>
            </span>
        </div>
        <hr class="my-3">

        <div class="scrollbar-250" id="style-1">
            <div class="force-overflow-250">
                <p>{{ $content->description }}</p>
            </div>
        </div>

      </div>
    </aside>
    <aside class="col-lg-5">
      <div class="card bg-light h-100 PopupCard">
        <div class="card-body">
          <ul class="RatingList d-flex justify-content-between">
            <li>0 Total Ratings</li>
            <li class="sepreter">|</li>
            <li>0 Linked Account Ratings </li>
          </ul>
          <form>
            <div class="row">
              <aside class="col-8">
                <input type="email" class="form-control" id="RatingsWords" placeholder="Enter Rating Word(s) here">
              </aside>
              <aside class="col-4">
                <select class="form-control" id="Score">
                  <option>Score</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </aside>
            </div>
          </form>
          <div class="scrollbar" id="style-1">
            <div class="force-overflow">
                No ratings found
              {{-- <article class="PopupCardBox"> <span class="d-flex align-items-center mb-2">
                <div class="width32 mr-2"><img src="{{asset('assets/img/unnamed.jpg')}}" alt="" class="rounded-circle border border-danger"></div>
                <div><a href="javascript:void(0);">User Account</a> - <em><a href="javascript:void(0);"> Linked</a></em></div>
                </span>
                <div class="d-flex justify-content-between">
                  <div class="badge badge-secondary"><span class="mt-2 d-block">10</span> <a href="javascript:void(0);" class="font-17 d-block text-center mt-3"><strong><i class="fal fa-long-arrow-up"></i></strong></a></div>
                  <div class="badge badge-secondary d-flex flex-column">
                    <p>The account owner's rating words, ratio number find emojis will appear here. <i class="fal fa-heart"></i> <i class="fal fa-smile"></i></p>
                    <div class="d-flex justify-content-between PopupCardDC">
                      <aside><a href="javascript:void(0);"><span class="text-success"><i class="far fa-arrow-up"></i></span> <span class="PopupCardCount">1322</span></a> <a href="javascript:void(0);"><span class="text-danger"><i class="far fa-arrow-down"></i></span> <span class="PopupCardCount">1322</span></a></aside>
                      <aside><span class="PopupCardDate">jan 12 21</span><span class="PopupCardDate">10:00 PM</span></aside>
                    </div>
                  </div>
                  <div> <a href="javascript:void(0);" class="arrowud text-success"> <i class="far fa-arrow-up"></i> </a> <a href="javascript:void(0);" class="arrowud text-danger"> <i class="far fa-arrow-down"></i> </a> </div>
                </div>
              </article> --}}
            </div>
          </div>
        </div>
      </div>
    </aside>
  </div>