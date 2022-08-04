<div class="tab-content" id="pills-tabContent">

    <!--Start Saved-->
    <div class="tab-pane fade" id="pills-Kept" role="tabpanel" aria-labelledby="pills-Kept-tab">
      <div class="d-flex justify-content-center TabFilter ">
        {{-- <ul>
          <li><a class="AllTab bg-secondary" id="showall">All</a></li>
        </ul> --}}
        <ul>
          <li class="disabled-li"><a href="javascript:void(0);"  class="filter-btn-disabled circle-link"><i class="fas fa-plus"></i></a></li>
          <li class="active"><a href="javascript:void(0);" data-tab-name="saved" data-filter-by="" class="bg-secondary sortContentListing"><i class="fas fa-align-left"></i></a></li>
        </ul>
        <ul>
          <li><a href="javascript:void(0);" data-tab-name="saved" data-filter-by="like" class="bg-success sortContentListing"><i class="far fa-check"></i></a></li>
          <li><a href="javascript:void(0);" data-tab-name="saved" data-filter-by="unlike" class="bg-danger sortContentListing"><i class="far fa-times"></i></a></li>
        </ul>

        <ul>
          <li><a href="javascript:void(0);" data-tab-name="saved" data-filter-by="visited" class="bg-secondary sortContentListing"><i class="fas fa-eye"></i></a></li>
          <li><a href="javascript:void(0);" data-tab-name="saved" data-filter-by="unvisited" class="bg-secondary sortContentListing"><i class="fas fa-eye-slash"></i></a></li>
        </ul>

      </div>
      <div class="CompanyList savedContent">
        <div class="text-center mt-10 saved-loader">
          <img src="{{asset('assets/img/loader.gif')}}" width="30">
        </div>
      </div>

      <div class="text-center mt-2">
        <button class="btn btn-primary col-md-12 load-more" style="display: none;" id="load-more-saved" data-paginate="2">Load More</button>
        <p id="invisible-saved" class="invisible">No listings found</p>
      </div>
    </div>

    <!--Start Matches-->
    <div class="tab-pane fade {{($user->user_type == '0' || $user->user_type == '2') ? 'show active' : ''}}" id="pills-Matches" role="tabpanel" aria-labelledby="pills-Matches-tab">
      <div class="d-flex justify-content-center TabFilter">
        {{-- <ul>
          <li><a class="AllTab bg-secondary" id="showall">All</a></li>
        </ul> --}}
        <ul>
          <li><a href="javascript:void(0);" class="bg-secondary circle-link loadUnpublishedContents"><i class="fas fa-plus"></i></a></li>
          <li class="active"><a href="javascript:void(0);" data-tab-name="matched" data-filter-by="" class="bg-secondary sortContentListing"><i class="fas fa-align-left"></i></a></li>
        </ul>
        <ul>
          <li><a href="javascript:void(0);" data-tab-name="matched" data-filter-by="like" class="bg-success sortContentListing"><i class="far fa-check"></i></a></li>
          <li><a href="javascript:void(0);" data-tab-name="matched" data-filter-by="unlike" class="bg-danger sortContentListing"><i class="far fa-times"></i></a></li>
        </ul>

        <ul>
          <li><a href="javascript:void(0);" data-tab-name="matched" data-filter-by="visited" class="bg-secondary sortContentListing"><i class="fas fa-eye"></i></a></li>
          <li><a href="javascript:void(0);" data-tab-name="matched" data-filter-by="unvisited" class="bg-secondary sortContentListing"><i class="fas fa-eye-slash"></i></a></li>
        </ul>

      </div>
      <div class="CompanyList matchesContent">
        <div class="text-center mt-10 matched-loader">
          <img src="{{asset('assets/img/loader.gif')}}" width="30">
        </div>
      </div>
      <div class="text-center mt-2">
        <button class="btn btn-primary col-md-12 load-more" style="display: none;" id="load-more-matched" data-paginate="2">Load More</button>
        <p id="invisible-matched" class="invisible">No listings found</p>
      </div>
    </div>
    <!--Start Rated-->
    {{-- <div class="tab-pane fade" id="pills-Rated" role="tabpanel" aria-labelledby="pills-Rated-tab">
      <div class="d-flex justify-content-center TabFilter disabled">
        <ul>
          <li><a class="AllTab bg-secondary" id="showall">All</a></li>
        </ul>
        <ul>
          <li><a href="javascript:void(0);" class="bg-secondary circle-link"><i class="fas fa-plus"></i></a></li>
          <li class="active"><a href="javascript:void(0);" class="bg-secondary"><i class="fas fa-align-left"></i></a></li>
        </ul>
        <ul>
          <li><a href="javascript:void(0);" class="bg-success"><i class="far fa-check"></i></a></li>
          <li><a href="javascript:void(0);" class="bg-danger"><i class="far fa-times"></i></a></li>
        </ul>

        <ul>
          <li><a href="javascript:void(0);" class="bg-secondary"><i class="fas fa-eye"></i></a></li>
          <li><a href="javascript:void(0);" class="bg-secondary"><i class="fas fa-eye-slash"></i></a></li>
        </ul>

      </div>
      <div class="CompanyList ratedContent">
        <div class="text-center mt-10">
          <img src="{{asset('assets/img/loader.gif')}}" width="30">
        </div>
      </div>
    </div> --}}

    <!--Start Creators-->
    <div class="tab-pane fade {{($user->user_type == '1') ? 'show active' : ''}}" id="pills-Cretors" role="tabpanel" aria-labelledby="pills-Cretors-tab">
      <div class="d-flex justify-content-center TabFilter">
        {{-- <ul>
          <li class="disabled-li"><a class="filter-btn-disabled" id="showall">All</a>

          </li>
        </ul> --}}
        <ul>
          @if($editable)
            @if($type == 'socialAccount')
              <li class="disabled-li"><a href="{{route('user.social-account.create')}}" class="bg-secondary circle-link"><i class="fas fa-plus"></i></a></li>
            @else
              <li class="disabled-li"><a id="content-terms-button" href="{{route('user.content.create', ['saId'=> @$socialAccountId])}}" class="bg-secondary circle-link"><i class="fas fa-plus"></i></a></li>
            @endif
          @else
            <li class="disabled-li"><a href="javascript:void(0);" class="filter-btn-disabled circle-link"><i class="far fa-plus"></i></a></li>
          @endif
          <li class="disabled-li"><a href="javascript:void(0);" class="filter-btn-disabled"><i class="fas fa-align-left"></i></a></li>
        </ul>
        <ul>
          <li class="disabled-li"><a href="javascript:void(0);" class="filter-btn-disabled"><i class="far fa-check"></i></a></li>
          <li class="disabled-li"><a href="javascript:void(0);" class="filter-btn-disabled"><i class="far fa-times"></i></a></li>
        </ul>

        <ul>
          <li class="disabled-li"><a href="javascript:void(0);" class="filter-btn-disabled"><i class="fas fa-eye"></i></a></li>
          <li class="disabled-li"><a href="javascript:void(0);" class="filter-btn-disabled"><i class="fas fa-eye-slash"></i></a></li>
        </ul>

      </div>
      <div class="CompanyList creatorsContent">
        <div class="content-listing-loader" style="display: none;">
          <i class="fa fa-spinner fa-pulse"></i>
        </div>

          {{-- Social Accounts --}}
          @if($type == 'socialAccount')
            <div class="row">
              @if(count($socialAccounts) > 0)
                @foreach ($socialAccounts as $socialAccount)
                  <aside class="col-lg-3 col-md-4 col-sm-6" id="social-account-box-{{$socialAccount->id}}">
                    <div class="AddListing">
                      <h4>{{$socialAccount->name}}</h4>
                      <p class="ListingList">
                        @if((isset(Auth::user()->user_type) && Auth::user()->user_type != '1' && Auth::user()->id == $user->id))
                          {{$socialAccount->user_content_count}}
                        @elseif(!isset(Auth::user()->id) || Auth::user()->id != $user->id)
                          {{$socialAccount->logged_out_user_content_count}}
                        @else
                          {{$socialAccount->content_count}}
                        @endif

                        @if((isset(Auth::user()->user_type) && Auth::user()->user_type != '1' && Auth::user()->id == $user->id))
                          {{$socialAccount->user_content_count == 1 ? 'Listing' : 'Listings'}}
                        @elseif(!isset(Auth::user()->id) || Auth::user()->id != $user->id)
                          {{$socialAccount->logged_out_user_content_count == 1 ? 'Listing' : 'Listings'}}
                        @else
                          {{$socialAccount->content_count == 1 ? 'Listing' : 'Listings'}}
                        @endif
                      </p>
                      <div class="">
                        <a href="{{route('user.account.contents', [$socialAccount->hashid, $user->hashid])}}" class="ListingLogo">
                          <img class="rounded-circle height-75 width-75 " src="{{$socialAccount->image_url}}" alt="">
                        </a>
                      </div>
                      <p class="ListingList">{{$socialAccount->host_name}}</p>
                      @if($editable)
                      <div class="VideoPopup text-center">
                        <div class="SettingBoxHeadLast">
                          <ul>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-ellipsis-v"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                  <li class="nav-item"> <a href="{{route('user.social-account.edit', $socialAccount->hashid)}}" class="btn btn-primary  w100p text-align-left"><i class="far fa-edit"></i> Edit</a> </li>
                                  <li class="nav-item"> <a href="javascript:void(0);" data-id="{{ $socialAccount->id }}" class="btn btn-primary mr-3  w100p delete-social-account text-align-left"><i class="far fa-trash"></i> Delete</a> </li>
                                </ul>
                            </li>
                      </div>
                      @endif

                    </div>
                  </aside>
                @endforeach
              @else
                <div class="col-lg-12 col-md-12 col-sm-12 mt-10 text-center">You can create a listing group here</div>
              @endif
            </div>
          @endif

          {{-- Contents --}}
          @if($type == 'content')
            <div class="row">
              <div class="col-md-6 mt-3">
                <h5>{{ isset($socialAccount->name) ? $socialAccount->name : '' }}</h5>
              </div>
              <div class="col-md-6 mt-3">
                @if($editable)
                  <a href="{{route('user.account', array('tab' => 'created'))}}" class="btn btn-primary btn-sm  text-uppercase pull-right ">Back</a>
                @else
                  <a href="{{route('other-user.account', $user->hashid, array('tab' => 'created'))}}" class="btn btn-primary btn-sm  text-uppercase pull-right ">Back</a>
                @endif
              </div>
            </div>

            <div class="createdContent">
              @include('content-rows')
            </div>

            <div class="text-center mt-2">
              @if($items->count() > 0)
                <button class="btn btn-primary col-md-12 load-more" style="display: none;" id="load-more-created" data-paginate="2">Load More</button>
              @endif
              <p id="invisible-created" class="invisible">No listings found</p>
            </div>

          @endif
      </div>
    </div>
  </div>