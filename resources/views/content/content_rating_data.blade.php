@if($contentRatings->count() > 0)
    @foreach ($contentRatings as $item)
        @php
        $userProfileClass = '';
        if($item->user->user_type == '0')
        {
            $userProfileClass = 'user-profile-bg';
        }
        if($item->user->user_type == '1')
        {
            $userProfileClass = 'creator-profile-bg';
        }
        if($item->user->user_type == '2')
        {
            $userProfileClass = 'hybrid-profile-bg';
        }
    @endphp
    <article class="PopupCardBox">
        <span class="d-flex align-items-center mb-2">
        <div class="mr-2 height-32 width-32 user-profile-avatar">
            <img style="width: 32px; height:32px;" src="{{$item->user->user_image_url}}" alt="" class="rounded-circle  {{$userProfileClass}}">
        </div>
        <div>
            @php
                $userName = isset($item->user->name) ? $item->user->name : '';
            @endphp
            <a href="javascript:void(0);">{{$userName}}</a>
            - <em>
                <a href="javascript:void(0);"> Linked</a>
            </em>
        </div>
        </span>
        <div class="d-flex justify-content-between">
          <div class="badge badge-secondary">
              <span class="mt-2 d-block">0</span>
               <a href="javascript:void(0);" class="font-17 d-block text-center mt-3">
                    @if($item->is_up_voted_ratings)
                        <strong><i class="fal fa-long-arrow-up"></i></strong>
                    @else
                        <strong><i class="fal fa-long-arrow-down"></i></strong>
                    @endif
                </a>
          </div>
          <div class="badge badge-secondary d-flex flex-column w100p">
            <p>{!! $item->title !!}
                <label>
                    @php
                        $image1 = $item->rating >= 1 ? asset('assets/img/sad-red.png') : asset('assets/img/sad.png');
                    @endphp
                    <img class="" src="{{$image1}}" width="15">
                </label>

                <label>
                    @php
                        $image2 = $item->rating >= 2 ? asset('assets/img/neutral-red.png') : asset('assets/img/neutral.png');
                    @endphp
                    <img class="" src="{{$image2}}" width="15">
                </label>

                <label>
                    @php
                        $image3 = $item->rating >= 3 ? asset('assets/img/neutral-red.png') : asset('assets/img/neutral.png');
                    @endphp
                    <img class="" src="{{$image3}}" width="15">
                </label>

                <label>
                    @php
                        $image4 = $item->rating >= 4 ? asset('assets/img/happy-red.png') : asset('assets/img/happy.png');
                    @endphp
                    <img class="" src="{{$image4}}" width="15">
                </label>

                <label>
                    @php
                        $image5 = $item->rating >= 5 ? asset('assets/img/happy-red.png') : asset('assets/img/happy.png');
                    @endphp
                    <img class="" src="{{$image5}}" width="15">
                </label>
            </p>
            <div class="d-flex justify-content-between PopupCardDC">
              <aside>
                    <a href="javascript:void(0);">
                        <span class="text-success"><i class="far fa-arrow-up"></i></span>
                        <span class="PopupCardCount">{{$item->ratings_up_count}}</span>
                    </a>
                    <a href="javascript:void(0);">
                        <span class="text-danger"><i class="far fa-arrow-down"></i></span>
                        <span class="PopupCardCount">{{$item->ratings_down_count}}</span>
                    </a>
                </aside>
              <aside><span class="PopupCardDate">{{date('d M Y', strtotime($item->created_at))}}</span><span class="PopupCardDate">{{date('h:i A', strtotime($item->created_at))}}</span></aside>
            </div>
          </div>
            <div>
                @if($item->is_up_voted_ratings || $item->is_down_voted_ratings|| (isset(Auth::user()->user_type) && Auth::user()->user_type == '1'))
                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-type="1" class="arrowud text-muted "> <i class="far fa-arrow-up"></i> </a>
                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-type="0" class="arrowud text-muted "> <i class="far fa-arrow-down"></i> </a>
                @else
                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-type="1" class="arrowud text-success ratingVoteAction"> <i class="far fa-arrow-up"></i> </a>
                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-type="0" class="arrowud text-danger ratingVoteAction"> <i class="far fa-arrow-down"></i> </a>
                @endif
            </div>
        </div>
      </article>
    @endforeach
{{-- @else
<div class="col-lg-12">
    <div class="card col-md-12 text-center">
        <!-- Card body -->
        <div class="card-body">
            <span class="card-title mb-0 text-center">No matching records found</span>
        </div>
    </div>
</div> --}}
@endif
