@extends('layouts.app')
@section('content')
    <div class="header pb-7">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <span class="Small-Title mb-0">Contents</span>
                        <p class="text-muted">You can manage your content from here.</p>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                    <a href="{{route('user.content.create')}}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add New</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <div class="input-group input-group-merge">
                                <input class="form-control" placeholder="Search..." type="text" id="search">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-2">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <select class="form-control" id="category">
                                    <option value="">All Category</option>
                                    @if($categories)
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <a href="javascript:void(0);" class="default-btn pull-left" onclick="return resetFilter();">Clear</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="content-listing-loader" style="display: none;">
        <i class="fa fa-spinner fa-pulse"></i>
    </div>
    <div class="container-fluid mt--6" id="content_data">
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
        <div class="row">
            @include('content.content_data')
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                {!! $content->links() !!}
            </ul>
        </nav>
    </div>
@endsection
@section('pagewise_js')
<script type="text/javascript">
/*$(window).on('hashchange', function() {
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        }else{
            getData(page);
        }
    }
});
*/
var pageno=1;
$(document).ready(function() {

    $(document).on('click','.delete-content',function(event) {

        var contentId = $(this).attr('data-id');


        swal({
            title: "Delete!",
            text: "Would you like to delete this listing?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes',
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.value) {
                deleteContent(contentId);
            }
        });
    });

    $(document).on('click', '.pagination a',function(event){
        event.preventDefault();

        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var myurl = $(this).attr('href');
        pageno=$(this).attr('href').split('page=')[1];
        getData();
    });

    $('#search').on('keyup',function(){
        pageno=1;
        getData();
    });

    $('#category').on('change',function(){
        pageno=1;
        getData();
    });
});

function getData(){
    $(".content-listing-loader").show();
    $.ajax(
    {
        url: '{{route("user.content.search")}}',
        type: "get",
        datatype: "html",
        data:{page:pageno,search:$('#search').val(),category_id:$('#category').val()},
    }).done(function(data){
        $("#content_data").html(data);
        $(".content-listing-loader").hide();
        //location.hash = page;
    }).fail(function(jqXHR, ajaxOptions, thrownError){
          //alert('No response from server');
          $(".content-listing-loader").hide();
    });
}

function deleteContent(id){
    $(".content-listing-loader").show();
    $.ajax(
    {
        url: '{{route("user.content.delete")}}',
        type: "post",
        datatype: "json",
        data:{content_id:id},
    }).done(function(data){

        $(".content-listing-loader").hide();

        if(data.status)
        {
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
            toastr.success(data.message);
            pageno=1;
            getData();
            return false;
        }
    }).fail(function(jqXHR, ajaxOptions, thrownError){
          //alert('No response from server');
          $(".content-listing-loader").hide();
    });
}

function resetFilter(){

    $("#search").val('');
    $("#category").val('');
    $('#category').change();
}
</script>
@endsection