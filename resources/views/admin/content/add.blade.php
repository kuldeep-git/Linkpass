<!-- Admin Dashboard Page -->
@extends('layouts.adminapp')
@section('content')

<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Add Content</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{!! url('admin') !!}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{!! url('admin/content') !!}">Content</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Content</li>
            </ol>
          </nav>
        </div>

      </div>
      <!-- Card stats -->

    </div>
  </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
      <div class="card mb-4">
        <!-- Card header -->
        <div class="card-header">
          <h3 class="mb-0">Add Content</h3>
        </div>

        <!-- Card body -->
        <div class="card-body">
          <form action="{{ route('admin.content.update',$content->hashid) }}" onsubmit="return validateStep2()"  method="post" enctype="multipart/form-data">
          @csrf
          {{ method_field('PUT') }}

                {{-- Tabs : Start --}}
                <div class="nav-wrapper">
                  <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                      <li class="nav-item">
                          <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">Step 1</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">Step 2</a>
                      </li>
                  </ul>
              </div>
              <div class="card shadow">
                  <div class="card-body">
                      <div class="tab-content" id="myTabContent">
                          <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group @if($errors->has('type')) has-danger @endif">
                                  <label class="form-control-label" for="type">Type <strong class="text-danger">*</strong></label><br>
                                  <select class="js-example-basic-single form-control @if($errors->has('type')) is-invalid @endif" id="type" name="type">
                                    <option value="">Please Select Type</option>
                                    <option @if($content->type ==1) selected @endif value="1">Images</option>
                                    <option @if($content->type ==2) selected @endif value="2">Video</option>
                                    <option @if($content->type ==3) selected @endif value="3">Audio</option>
                                    <option @if($content->type ==4) selected @endif value="4">Text/Blog</option>
                                  </select>
                                  <span class="invalid-feedback">{{ $errors->first('type') }}</span>
                                </div>

                                <div class="form-group @if($errors->has('user_id')) has-danger @endif">
                                    <label class="form-control-label" for="user_id">Creator <strong class="text-danger">*</strong></label><br>
                                    <select class="js-example-basic-single form-control @if($errors->has('user_id')) is-invalid @endif" id="user_id" name="user_id">
                                      <option value="">Please Select Creator</option>
                                      @if(count($users) > 0)
                                        @foreach($users as $user)
                                          <option value="{{$user['id']}}" @if($user['id'] == $content['user_id'])) selected @endif>{!! $user['name'] !!}</option>
                                        @endforeach
                                      @endif
                                    </select>
                                    @if($errors->has('user_id'))
                                      <span class="invalid-feedback">{{ $errors->first('user_id') }}</span>
                                    @endif
                                </div>

                                <div class="form-group @if($errors->has('social_account_id')) has-danger @endif">
                                  <label class="form-control-label" for="social_account_id">Account <strong class="text-danger">*</strong></label><br>
                                  <select class="js-example-basic-single form-control @if($errors->has('social_account_id')) is-invalid @endif" id="social_account_id" name="social_account_id">
                                    <option value="">Please Select Account</option>
                                    @if(count($socialAccounts) > 0)
                                      @foreach($socialAccounts as $account)
                                        <option value="{{$account['id']}}" @if($account['id'] == $content->social_account_id) selected @endif>{!! $account['name'] !!}</option>
                                      @endforeach
                                    @endif
                                  </select>
                                  {{-- <span class="text-primary mb-0 text-right float-right small"><a id="add_new_account" href="javascript:void(0);">Add Account</a></span> --}}
                                  @if($errors->has('social_account_id'))
                                      <span class="invalid-feedback">{{ $errors->first('social_account_id') }}</span>
                                  @endif
                                </div>
                              </div>

                            </div>

                            <div class="row">
                              <div class="col-md-12 text-center">
                                  <a href="javascript:void(0);" class="btn btn-success" id="go-to-next-step">Next</a>
                                  <a href="{{route('admin.content.list')}}" class="btn btn-primary">Cancel</a>
                              </div>
                            </div>

                          </div>
                          <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">

                            <div class="row">
                              <div class="col-md-5 main-img">
                                <div class="form-group">
                                  <label class="form-control-label" for="content_main_image">Main Image</label>

                                  <div class="dropzone dropzone-single mb-3" data-toggle="dropzone" data-dropzone-url="{{route('admin.content.mainupload',['id' => $content->id])}}">
                                    <div class="fallback">
                                      <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="content_main_image">
                                        <label class="custom-file-label" for="content_main_image">Choose file</label>
                                      </div>
                                    </div>
                                    <div class="dz-message" data-dz-message><span>Drop file here or click to upload.</span></div>
                                    <div class="dz-preview dz-preview-single" style="height: 185px;">
                                      <div class="dz-preview-cover">
                                        <img class="dz-preview-img" src="" data-dz-thumbnail>
                                      </div>
                                    </div>
                                  </div>
                                  <p class="text-info mb-0"><strong>Recommended Size: 800 X 600 px</strong></p>
                                </div>
                              </div>
                              <div class="col-md-7">

                                  <div class="form-group ">
                                      <label class="form-control-label" for="example3cols2Input">Main Title <strong class="text-danger">*</strong></label>
                                      <input type="text" name="main_title" class="form-control @if($errors->has('main_title')) is-invalid @endif" id="main_title" value="{{old('main_title', $content->main_title)}}">
                                      @if($errors->has('main_title'))
                                          <span class="invalid-feedback">{{ $errors->first('main_title') }}</span>
                                      @endif
                                  </div>

                                  <div class="form-group">
                                    <label class="form-control-label" for="category_id">Category <strong class="text-danger">*</strong></label><br>
                                    <select class="js-example-basic-single form-control @if($errors->has('category_id')) is-invalid @endif" id="category_id" name="category_id">
                                      <option value="">Please Select Category</option>
                                        @if(count($categories) > 0)
                                          @foreach($categories as $category)
                                            <option value="{{$category['id']}}" @if($category['id'] == $content['category_id'])) selected @endif>{!! $category['name'] !!}</option>
                                          @endforeach
                                        @endif
                                    </select>
                                    @if($errors->has('category_id'))
                                        <span class="invalid-feedback">{{ $errors->first('category_id') }}</span>
                                    @endif
                                  </div>

                                  <div class="form-group">
                                      <label class="form-control-label" for="type">Posting Date <strong class="text-danger">*</strong></label>
                                      <input type="date" class="form-control @if($errors->has('posted_at')) is-invalid @endif" id="posted_at" name="posted_at" placeholder="Posting Date" value="{{old('posted_at', !empty($content->posted_at) ? date('Y-m-d', strtotime($content->posted_at)) : '')}}">
                                      @if($errors->has('posted_at'))
                                          <span class="invalid-feedback">{{ $errors->first('posted_at') }}</span>
                                      @endif
                                  </div>

                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="tags">Tags</label><br>
                                    <input type="text" class="form-control" id="tags" name="tags" value="{{old('tags', $contentTags)}}" data-toggle="tags" />
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-12">
                                <div class="form-group">
                                  <label class="form-control-label" for="example4cols3Input">Description/Summary</label>
                                  <textarea name="description" id="description" class="form-control" rows="10">{{old('description', $content->description)}}</textarea>
                                </div>
                              </div>
                            </div>

                            <div class="row length-field image-length-field">

                              <div class="col-sm-2">
                                  <div class="form-group">
                                      <label class="form-control-label" for="number_of_images">Number Of Images</label>
                                      <div class="input-group mb-3">
                                        <input type="number" class="form-control" id="number_of_images" name="number_of_images" placeholder="Enter Number Of Images" value="{{old('number_of_images', $content->number_of_images)}}">
                                      </div>
                                  </div>
                              </div>
                            </div>

                            <div class="row length-field word-length-field">
                              <div class="col-sm-2">
                                  <div class="form-group">
                                      <label class="form-control-label" for="number_of_words">Number Of Words</label>
                                      <div class="input-group mb-3">
                                        <input type="number" class="form-control" id="number_of_words" name="number_of_words" placeholder="Enter Number Of Words" value="{{old('number_of_words', $content->number_of_words)}}">
                                      </div>
                                  </div>
                              </div>
                            </div>

                            <div class="row length-field video-length-field">

                              <div class="col-sm-12">
                                <label class="form-control-label" for="video_length">Video Length</label>
                              </div>

                              <div class="col-sm-2">
                                  <div class="form-group">
                                      <label class="form-control-label" for="video_length_h">Hours</label>
                                      <div class="input-group mb-3">
                                        <input type="number" min="0" class="form-control" id="video_length_h" name="video_length_h" placeholder="Hours" value="{{old('video_length_h', $content->video_length_h)}}">
                                      </div>
                                  </div>
                              </div>

                              <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="video_length_m">Minutes</label>
                                    <div class="input-group mb-3">
                                      <input type="number" min="0" class="form-control" id="video_length_m" name="video_length_m" placeholder="Minutes" value="{{old('video_length_m', $content->video_length_m)}}">
                                    </div>
                                </div>
                              </div>

                              <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="video_length_s">Seconds</label>
                                    <div class="input-group mb-3">
                                      <input type="number" min="0" class="form-control" id="video_length_s" name="video_length_s" placeholder="Seconds" value="{{old('video_length_s', $content->video_length_s)}}">
                                    </div>
                                </div>
                              </div>

                            </div>

                            <div class="row length-field podcast-length-field">

                              <div class="col-sm-12">
                                <label class="form-control-label" for="podcast_length">Audio Length</label>
                              </div>

                              <div class="col-sm-2">
                                <div class="form-group">
                                  <label class="form-control-label" for="podcast_length_h">Hours</label>
                                  <div class="input-group mb-3">
                                  <input type="number" min="0" class="form-control" id="podcast_length_h" name="podcast_length_h" placeholder="Hours" value="{{old('podcast_length_h', $content->podcast_length_h)}}">
                                  </div>
                                </div>
                              </div>

                              <div class="col-sm-2">
                                <div class="form-group">
                                  <label class="form-control-label" for="podcast_length_m">Minutes</label>
                                  <div class="input-group mb-3">
                                    <input type="number" min="0" class="form-control" id="podcast_length_m" name="podcast_length_m" placeholder="Minutes" value="{{old('podcast_length_m', $content->podcast_length_m)}}">
                                  </div>
                                </div>
                              </div>

                              <div class="col-sm-2">
                                <div class="form-group">
                                  <label class="form-control-label" for="podcast_length_s">Seconds</label>
                                  <div class="input-group mb-3">
                                    <input type="number" min="0" class="form-control" id="podcast_length_s" name="podcast_length_s" placeholder="Seconds" value="{{old('podcast_length_s', $content->podcast_length_s)}}">
                                  </div>
                                </div>
                              </div>

                            </div>

                            <div class="row">
                              <div class="col-sm-12">
                                  <div class="form-group">
                                      <label class="form-control-label" for="external_link" id="external_link_label">Link</label>
                                      <div class="input-group mb-3">
                                        <input type="url" class="form-control" id="external_link" name="external_link" placeholder="Enter URL " value="{{old('external_link', $content->external_link)}}">
                                      </div>
                                  </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12 text-center">
                                  <a href="javascript:void(0);" class="btn btn-info" id="go-to-previous-step">Previous</a>
                                  <input type="submit" class="btn btn-success" name="submit" value="Save">
                                  <a href="{{route('admin.content.list')}}" class="btn btn-primary">Cancel</a>
                              </div>
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
              {{-- Tabs : End --}}

            </form>

        </div>
      </div>


    </div>
<style type="text/css">
  .main-img .dz-default.dz-message{
    height: 300px;
    padding: 8rem 1rem;
  }
  .dropzone-multiple .dz-default.dz-message{
    height: 150px;
  }
  .dropzone-multiple .dz-message{
    padding-top: 4rem;
  }
  .dz-size{
    display: none;
  }
</style>

@endsection
@section('pagewise_js')
<script type="text/javascript">
var content_id= '{{$content->id}}';
$(document).ready(function() {

    $( "#user_id" ).change(function() {
      var user_id = $(this).val();

      if(user_id != '')
      {
          var url = '{{route('admin.user.get-account', ':id')}}';

            url = url.replace(":id", user_id);

            $.ajax(
            {
                url: url,
                type: "get",
                datatype: "json",
            }).done(function(data){

              if(data.status)
              {
                var accounts = JSON.parse(data.accounts);

                $('#social_account_id').empty().trigger('change');

                var newOption = new Option('Please select account', '', false, false);
                $('#social_account_id').append(newOption).trigger('change');

                if(accounts.length > 0)
                {
                  for (i in accounts) {

                    var newOption = new Option(accounts[i].name, accounts[i].id, false, false);
                    $('#social_account_id').append(newOption).trigger('change');
                  }
                }

              }

            }).fail(function(jqXHR, ajaxOptions, thrownError){


            });
      }


    });


    $( "#add_new_account" ).click(function() {

      swal({
          title: "Account Name",
          html: '<input class="form-control" type="text" name="acc_name" id="acc_name" />',
          confirmButtonText: "Save",
          showCancelButton: true
      }).then((value) => {
          var acc_name = $('#acc_name').val();
          var newOption = new Option(acc_name, acc_name, false, false);
          $('#social_account_id').append(newOption).trigger('change');
      });

    });

    $( "#go-to-next-step" ).click(function() {
      $('#tabs-icons-text-2-tab').trigger('click');
    });

    $( "#go-to-previous-step" ).click(function() {
        $('#tabs-icons-text-1-tab').trigger('click');
    });

    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
        var id = $(this).attr('id');

        if(id == 'tabs-icons-text-2-tab')
        {
          var validate = validateStep1();

          if(validate)
          {
            initSecondTab();
          }
          else
          {
            return false;
          }
        }
    });

    @if($content->main_image)
        $(".dz-preview.dz-preview-single").html('<div class="dz-preview-cover dz-processing dz-image-preview dz-success dz-complete"><img class="dz-preview-img" src="{{asset($content->main_image_url)}}"></div>');
        $(".dropzone.dropzone-single").addClass('dz-clickable dz-max-files-reached');
    @endif

    $('.js-example-basic-single').select2();

});

function initSecondTab()
{
  var type = $('#type').val();

  $('.length-field').hide();

  switch (type) {
    case '1':
      $('.image-length-field').show();
      break;
    case '2':
      $('.video-length-field').show();
      break;
    case '3':
      $('.podcast-length-field').show();
      break;
    case '4':
      $('.word-length-field').show();
      break;
  }
}

function validateStep1()
{
    var type              = $('#type').val();
    var user_id           = $('#user_id').val();
    var social_account_id = $('#social_account_id').val();
    var errCount          = 0;
    var errorStr          = '<div class="pull-left offset-4">';

    if(type == '')
    {
      errorStr += '<p class="text-left">Please select content type.</p>';
      errCount++;
    }

    if(user_id == '')
    {
      errorStr += '<p class="text-left">Please select creator.</p>';
      errCount++;
    }

    if(social_account_id == '')
    {
      errorStr += '<p class="text-left">Please select account.</p>';
      errCount++;
    }

    errorStr += '</div>';

    if(errCount > 0)
    {
      swal({
          type  : 'error',
          title : 'Error!',
          html  : errorStr,
      });

      return false;
    }

    return true;
}

function validateStep2()
{
  var main_title  = $('#main_title').val();
  var category_id = $('#category_id').val();
  var posted_at   = $('#posted_at').val();
  var errorStr = '<div class="pull-left offset-4">';
  var errCount = 0;
  if(main_title == '')
  {
    errorStr += '<p class="text-left">Please enter main title.</p>';
    errCount++;
  }

  if(category_id == '')
  {
    errorStr += '<p class="text-left">Please select category.</p>';
    errCount++;
  }

  if(posted_at == '')
  {
    errorStr += '<p class="text-left">Please enter posted date.</p>';
    errCount++;
  }

  errorStr += '</div>';

  if(errCount > 0)
  {
    swal({
        type  : 'error',
        title : 'Error!',
        html  : errorStr,
    });

    return false;
  }

}

</script>
@endsection