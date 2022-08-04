@extends('layouts.app')
@section('pagewise_css')
        <style type="text/css">

            #printable { display: none; }

            #full_description {display: none;}

            /* HIDE RADIO */
            [type=radio] {
                position: absolute;
                opacity: 0;
                width: 0;
                height: 0;
            }

            /* IMAGE STYLES */
            [type=radio] + img {
                cursor: pointer;
            }

            @media print
            {
                #non-printable { display: none; }
                #printable { display: block; }
            }
        </style>
@endsection
@section('content')

<div class="container-fluid mt--6">

    <div class="row mt20">
        <div class="col-md-6"><span class="normal-title"> <a target="_blank" href="{!! isset($content->content_account->account_url) ? $content->content_account->account_url : 'havascript:void(0)' !!}">{!! isset($content->content_account->name) ? $content->content_account->name : ''!!}</a></span></div>
        <div class="col-md-6 text-right">
            <div class="avtar"><img src="{{$content->content_user->user_image_url}}" width="50" class="rounded-circle"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4>{!! $content->main_title !!}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            @if($content->type == 1)
                <div class="" id="non-printable">
                    <iframe class="embed-responsive-item" height="500" width="100%" class="text-center" src="{{$content->external_link}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            @elseif($content->type == 2)
                @php
                    $videoUrl = $content->external_link;
                    $videoUrl = getYoutubeOrVimeoFromURL($videoUrl);
                @endphp

                <div class="" id="non-printable">
                    <iframe class="embed-responsive-item" height="500" width="100%" class="text-center" src="{{$videoUrl}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            @elseif($content->type == 3)
                @php
                    $mediaUrl = $content->external_link;
                @endphp

                <div class="d-block">
                    <audio controls>
                        <source src="{!! $mediaUrl !!}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            @elseif($content->type == 4)
                <img src="{{asset($content->main_image_url)}}" height="500" width="100%" />
            @endif
        </div>
    </div>

    <div class="row mt20">
        <div class="col-md-4">
            <span class="posted-date w100p pull-left mb10">{{date('d M Y', strtotime($content->created_at))}}</span>

            <label>
                @php
                    $image1 = $avgRating >= 1 ? asset('assets/img/sad-red.png') : asset('assets/img/sad.png');
                @endphp
                <img class="rating-img1" src="{{$image1}}">
            </label>

            <label>
                @php
                    $image2 = $avgRating >= 2 ? asset('assets/img/neutral-red.png') : asset('assets/img/neutral.png');
                @endphp
                <img class="rating-img1" src="{{$image2}}">
            </label>

            <label>
                @php
                    $image3 = $avgRating >= 3 ? asset('assets/img/neutral-red.png') : asset('assets/img/neutral.png');
                @endphp
                <img class="rating-img1" src="{{$image3}}">
            </label>

            <label>
                @php
                    $image4 = $avgRating >= 4 ? asset('assets/img/happy-red.png') : asset('assets/img/happy.png');
                @endphp
                <img class="rating-img1" src="{{$image4}}">
            </label>

            <label>
                @php
                    $image5 = $avgRating >= 5 ? asset('assets/img/happy-red.png') : asset('assets/img/happy.png');
                @endphp
                <img class="rating-img1" src="{{$image5}}">
            </label>
        </div>

        <div class="col-md-4 text-center">
            <div class="disabled-wrap content-actions">
                @if(!isset($content->content_user_like->id))
                    <a href="javascript:void(0);" data-action="1" class="mr20 content-action"><i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i></a>
                @endif

                @if(!isset($content->content_user_unlike->id))
                    <a href="javascript:void(0);" data-action="2" class="mr20 content-action"><i class="fa fa-thumbs-down fa-lg" aria-hidden="true"></i></a>
                @endif

                @if(!isset($content->content_user_inappropriate->id))
                <a href="javascript:void(0);" data-action="3" class="content-action"><i class="fa fa-flag fa-lg" aria-hidden="true"></i></a>
                @endif
            </div>
            <span class="w100p content-actions-text">Like, Unlike, Mark as Inappropriate After</span>
            <div id="viewTimer" class="viewTimer content-actions-timer">{{$timeToread}}:00</div>
            {{-- <div id="viewTimer" class="viewTimer content-actions-timer">00:05</div> --}}

        </div>

        <div class="col-md-4 text-right">
            @if(!isset($content->content_user_keep->id))
                <a href="javascript:void(0);" data-action="4" class="mr20 content-action"><i class="fa fa-lightbulb fa-lg" aria-hidden="true"></i></a>
            @endif

            @if(!isset($content->content_user_remove->id))
                <a href="javascript:void(0);" data-action="5" class="content-action"><i class="fa fa-ban fa-lg" aria-hidden="true"></i></a>
            @endif
        </div>
    </div>

    <div class="row mt20">
        <div class="col-md-12">
            <span class="posted-date">{{date('d M Y', strtotime($content->posted_at))}}</span>
        </div>
        <div class="col-md-12 mt10">
            @if(strlen($content->description) > 500)
            <p>
                <span id="less_description">{!! nl2br(Str::limit($content->description, 500)); !!}</span>
                <span id="full_description">{!!nl2br($content->description)!!}</span>
            </p>
            <p class="text-center">
                <a href="javascript:void(0);" class="readMoreBtn" onclick="descriptionToggle()" id="readMoreBtn"><i class='fa fa-plus-circle fa-lg'></i></a>
            </p>
            @else
                {!! nl2br($content->description) !!}
            @endif
        </div>
    </div>

    <hr class="mt20 mb20" />

    <div class="row content-actions disabled-wrap">
        <div class="col-md-12 mb10">
            <span class="normal-title">Rating</span>
        </div>
        <div class="col-md-2">
            <label>
                <input type="radio" class="rating" name="rating" value="1">
                <img class="rating-img" src="{{asset('assets/img/sad.png')}}">
            </label>

            <label>
                <input type="radio" class="rating" name="rating" value="2">
                <img class="rating-img" src="{{asset('assets/img/neutral.png')}}">
            </label>

            <label>
                <input type="radio" class="rating" name="rating" value="3">
                <img class="rating-img" src="{{asset('assets/img/neutral.png')}}">
            </label>

            <label>
                <input type="radio" class="rating" name="rating" value="4">
                <img class="rating-img" src="{{asset('assets/img/happy.png')}}">
            </label>

            <label>
                <input type="radio" class="rating" name="rating" value="5">
                <img class="rating-img" src="{{asset('assets/img/happy.png')}}">
            </label>
        </div>

        <div class="col-md-6">
            <input class="form-control" type="text" name="rating-text" id="rating-text" />
        </div>
        <div class="col-md-3">
            <button name="saveRating" id="saveRating" class="default-btn">Give a Rate</button>
        </div>
    </div>

    <hr class="mt20 mb20" />

    <div class="row">
        <div class="col-md-12">
           <span class="normal-title"> <span class="ratingsCount">{{$totalRatings}}</span> Ratings </span>
        </div>
    </div>

    <div id="ratings_data" class="ratings_data">
        <div class="row">
            @include('content.content_rating_data')
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                {!! $contentRatings->links() !!}
            </ul>
        </nav>
    </div>
 </div>

@endsection

@section('pagewise_js')
<script type="text/javascript">
var pageno=1;

jQuery(document).ready(function($){

    $(document).on('click', '.pagination a',function(event){
        event.preventDefault();

        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var myurl = $(this).attr('href');
        pageno=$(this).attr('href').split('page=')[1];
        //getRatingsData();
    });

    setTimeout(countDownTimer, 1000);

    $(".rating").click(function(e){
        e.preventDefault();
        $(".rating").removeClass('checked');
        $(this).addClass('checked');
        $('.rating-img').css('border', 'none');
        $(this).next('.rating-img').css('border-bottom', '2px solid red');
    });

    $(".content-action").click(function(e){
        e.preventDefault();
        var action = $(this).attr('data-action');

        saveContentAction(this, action);
    });



    $( "#saveRating" ).click(function() {

        var rating      =  $('.rating.checked');
        var ratingText  =  $('#rating-text').val();
        var content_id  = '{{ $content->id }}'

        if(rating.length == 0)
        {
            swal('Error!', 'Please give a rating', 'error');
            return false;
        }

        $.ajax(
        {
            url: '{{route("user.content.save-rating")}}',
            type: "post",
            datatype: "json",
            data:{content_id : content_id, rating : rating.val(), ratingText : ratingText},
        }).done(function(data){

            if(data.status)
            {
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : true
                }
                toastr.success(data.message);

                $('.ratingsCount').html(data.ratingsCount);

                $(".rating").removeClass('checked');
                $('.rating-img').css('border', 'none');
                $('#rating-text').val('');
                pageno=1;
                //getRatingsData();

                return false;
            }
            else
            {
                swal('Error!!', data.message, 'error');
                return false;
            }
        }).fail(function(jqXHR, ajaxOptions, thrownError){

        });
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

function countDownTimer() {

    var $worked = $("#viewTimer");

    var myTime = $worked.html();
    var ss = myTime.split(":");

    if(parseInt(ss[0]) == 0 && parseInt(ss[1]) == 0)
    {
        $('.content-actions').removeClass('disabled-wrap');
        $('.content-actions-text').remove();
        $('.content-actions-timer').remove();

        return false;
    }

    var dt = new Date();
    dt.setHours(0);
    dt.setMinutes(ss[0]);
    dt.setSeconds(ss[1]);

    var dt2 = new Date(dt.valueOf() - 1000);
    var temp = dt2.toTimeString().split(" ");
    var ts = temp[0].split(":");

    $worked.html(ts[1]+":"+ts[2]);

    if(parseInt(ts[1]) == 0 && parseInt(ts[2]) == 0)
    {
        $('.content-actions').removeClass('disabled-wrap');
        $('.content-actions-text').remove();
        $('.content-actions-timer').remove();

        return false;
    }

    setTimeout(countDownTimer, 1000);
}

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

function descriptionToggle() {
  var moreText  = document.getElementById("full_description");
  var lessText  = document.getElementById("less_description");
  var btnText   = document.getElementById("readMoreBtn");

  if($(moreText).is(':visible')){
    btnText.innerHTML       = "<i class='fa fa-plus-circle fa-lg'></i>";
    moreText.style.display  = "none";
    lessText.style.display  = "inline";
  } else {
    moreText.style.display  = "inline";
    lessText.style.display  = "none";
    btnText.innerHTML       = "<i class='fa fa-minus-circle fa-lg'></i>";
  }
}

function getRatingsData()
{
    $.ajax(
    {
        url: '{{ route("user.content.get-ratings") }}',
        type: "get",
        datatype: "html",
        data:{page:pageno},
    }).done(function(data){
        $("#ratings_data").html(data);

        //location.hash = page;
    }).fail(function(jqXHR, ajaxOptions, thrownError){
        //alert('No response from server');

    });
}

function saveContentAction(element, action){

    var text       = '';
    var content_id = '{{ $content->id }}'

    switch(action) {
    case '1':
        text = "Are you sure you want to recommend this listing?";
        break;
    case '2':
        text = "Are you sure you want to not recommend this listing?";
        break;
    case '3':
        text = "Are you sure you want to report this listing?";
        break;
    case '4':
        text = "Are you sure you want to Keep this listing?";
        break;
    case '5':
        text = "Are you sure you want to Remove this listing?";
        break;
    }

    if(text.length > 0)
    {
        swal({
            title: "Are you sure?",
            text: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes',
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.value) {
                $.ajax(
                {
                    url: '{{route("user.content.save-action")}}',
                    type: "post",
                    datatype: "json",
                    data:{content_id : content_id, action : action},
                }).done(function(data){

                    if(data.status)
                    {
                        toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success(data.message);

                        $(element).remove();

                        return false;
                    }
                    else
                    {
                        swal('Error!!', data.message, 'error');
                        return false;
                    }
                }).fail(function(jqXHR, ajaxOptions, thrownError){

                });
            }
        });
    }


}
</script>
@endsection
