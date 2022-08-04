<!-- Admin Dashboard Page -->
@extends('layouts.app')
@section('content')

<!-- Page content -->
<main class="main">
  <article class="container">
      <div class="header-body">
          <div class="row align-items-center">
              <div class="col-lg-6 col-7">
                  <span class="Small-Title mb-0">Add/Edit Content</span>
                  <p class="text-muted">You can create or edit your content listing here.</p>
              </div>
          </div>
          <div class="row">

              <div class="col-sm-12 col-md-12 col-lg-12">
                <form action="{{ route('user.content.update',$content->hashid) }}" onsubmit="return validateStep2()"  method="post" enctype="multipart/form-data">
                  @csrf
                  {{ method_field('PUT') }}

                      <div class="card shadow mt-3">
                          <div class="card-body">
                              <div class="" id="myTabContent">

                                  <div class="" id="tabs-icons-text-2" >

                                      <div class="row">
                                      <div class="col-md-5 main-img">
                                        <div class="form-group">
                                          <label class="form-control-label" for="content_main_image">Thumbnail <strong class="text-danger">*</strong></label>

                                          <div class="dropzone dropzone-single mb-3" data-toggle="dropzone" data-dropzone-url="{{route('user.content.mainupload',['id' => $content->id])}}">
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

                                        <div class="form-group text-align-right">
                                            <a href="{{route('user.account.contents', [$content->content_account->hashid, Auth::user()->id])}}" class="btn btn-primary  text-uppercase float-right ml-2 ">Back</a>
                                        </div>

                                          <div class="form-group ">
                                              <label class="form-control-label" for="example3cols2Input">Main Title <strong class="text-danger">*</strong></label>
                                              <input type="text" name="main_title" class="form-control @if($errors->has('main_title')) is-invalid @endif" id="main_title" value="{{old('main_title', $content->main_title)}}" maxlength="120">
                                              @if($errors->has('main_title'))
                                                  <span class="invalid-feedback">{{ $errors->first('main_title') }}</span>
                                              @endif
                                          </div>

                                          <div class="form-group @if($errors->has('type')) has-danger @endif">
                                            <label class="form-control-label" for="type">Type <strong class="text-danger">*</strong></label><br>
                                            <select class="js-example-basic-single form-control @if($errors->has('type')) is-invalid @endif" id="type" name="type" onchange="bindType()">
                                              <option value="">Please Select Type</option>
                                              <option @if($content->type ==1) selected @endif value="1">Images</option>
                                              <option selected @if($content->type ==2) selected @endif value="2">Video</option>
                                              <option @if($content->type ==3) selected @endif value="3">Audio</option>
                                              <option @if($content->type ==4) selected @endif value="4">Text/Blog</option>
                                            </select>
                                            <span class="invalid-feedback">{{ $errors->first('type') }}</span>
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

                                          <div class="form-group ">
                                              <label class="form-control-label" for="example3cols2Input">Enter a subcategory or an instance of a subcategory </label>
                                              <input type="text" name="sub_category" class="form-control @if($errors->has('sub_category')) is-invalid @endif" id="sub_category" value="{{old('sub_category', $content->sub_category)}}" maxlength="18">
                                              @if($errors->has('sub_category'))
                                                  <span class="invalid-feedback">{{ $errors->first('sub_category') }}</span>
                                              @endif
                                          </div>

                                          <div class="form-group">
                                              <label class="form-control-label" for="type">Posting Date <strong class="text-danger">*</strong></label>
                                              <input type="text" class="form-control @if($errors->has('posted_at')) is-invalid @endif" id="posted_at" autocomplete="off" name="posted_at" placeholder="Posting Date" value="{{old('posted_at', !empty($content->posted_at) ? date('Y-m-d', strtotime($content->posted_at)) : '')}}">
                                              @if($errors->has('posted_at'))
                                                  <span class="invalid-feedback">{{ $errors->first('posted_at') }}</span>
                                              @endif
                                          </div>

                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="category_tags">Keywords</label><br>
                                            <input type="text" class="form-control" id="category_tags" name="category_tags" value="{{old('category_tags', $contentCategoryTags)}}" data-role="tagsinput" />
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="tags">Tags <strong class="text-danger">*</strong></label><br>
                                            <input type="text" class="form-control" id="tags" name="tags" value="{{old('tags', $contentTags)}}" />
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-sm-12">
                                        <div class="form-group">
                                          <label class="form-control-label" for="example4cols3Input">Description/Summary <strong class="text-danger">*</strong></label>
                                          <textarea name="description" placeholder="400 character limit" id="description" class="form-control" rows="6" maxlength="400">{{old('description', $content->description)}}</textarea>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row length-field image-length-field">

                                      <div class="col-sm-2">
                                          <div class="form-group">
                                              <label class="form-control-label" for="number_of_images">Number Of Images <strong class="text-danger">*</strong></label>
                                              <div class="input-group mb-3">
                                                <input type="number" class="form-control" min="0" id="number_of_images" name="number_of_images" placeholder="Enter Number Of Images" value="{{old('number_of_images', ($content->number_of_images == 0) ? 0 : $content->number_of_images)}}">
                                              </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="row length-field word-length-field">
                                      <div class="col-sm-2">
                                          <div class="form-group">
                                              <label class="form-control-label" for="number_of_words">Number Of Words <strong class="text-danger">*</strong></label>
                                              <div class="input-group mb-3">
                                                <input type="number" class="form-control" id="number_of_words" name="number_of_words" placeholder="Enter Number Of Words" value="{{old('number_of_words', $content->number_of_words)}}">
                                              </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="row length-field video-length-field">

                                      <div class="col-sm-12">
                                        <label class="form-control-label" for="video_length">Video Length <strong class="text-danger">*</strong></label>
                                      </div>

                                      <div class="col-sm-2">
                                          <div class="form-group">
                                              <label class="form-control-label" for="video_length_h">Hours</label>
                                              <div class="input-group mb-3">
                                                <input type="number" min="0" max="99" onKeyUp="if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" class="form-control" id="video_length_h" name="video_length_h" placeholder="Hours" value="{{old('video_length_h', $content->video_length_h)}}">
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="video_length_m">Minutes</label>
                                            <div class="input-group mb-3">
                                              <input type="number" min="0" max="59" onKeyUp="if(this.value>59){this.value='59';}else if(this.value<0){this.value='0';}" class="form-control" id="video_length_m" name="video_length_m" placeholder="Minutes" value="{{old('video_length_m', $content->video_length_m)}}">
                                            </div>
                                        </div>
                                      </div>

                                      <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="video_length_s">Seconds</label>
                                            <div class="input-group mb-3">
                                              <input type="number" min="0" max="59" onKeyUp="if(this.value>59){this.value='59';}else if(this.value<0){this.value='0';}" class="form-control" id="video_length_s" name="video_length_s" placeholder="Seconds" value="{{ old('video_length_s', $content->video_length_s)}}">
                                            </div>
                                        </div>
                                      </div>

                                    </div>

                                    <div class="row length-field podcast-length-field">

                                      <div class="col-sm-12">
                                        <label class="form-control-label" for="podcast_length">Audio Length <strong class="text-danger">*</strong></label>
                                      </div>

                                      <div class="col-sm-2">
                                        <div class="form-group">
                                          <label class="form-control-label" for="podcast_length_h">Hours</label>
                                          <div class="input-group mb-3">
                                          <input type="number" min="0" max="99" onKeyUp="if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" class="form-control" id="podcast_length_h" name="podcast_length_h" placeholder="Hours" value="{{old('podcast_length_h', $content->podcast_length_h)}}">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-sm-2">
                                        <div class="form-group">
                                          <label class="form-control-label" for="podcast_length_m">Minutes</label>
                                          <div class="input-group mb-3">
                                            <input type="number" min="0" max="59" onKeyUp="if(this.value>59){this.value='59';}else if(this.value<0){this.value='0';}" class="form-control" id="podcast_length_m" name="podcast_length_m" placeholder="Minutes" value="{{old('podcast_length_m', $content->podcast_length_m)}}">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-sm-2">
                                        <div class="form-group">
                                          <label class="form-control-label" for="podcast_length_s">Seconds</label>
                                          <div class="input-group mb-3">
                                            <input type="number" min="0" max="59" onKeyUp="if(this.value>59){this.value='59';}else if(this.value<0){this.value='0';}" class="form-control" id="podcast_length_s" name="podcast_length_s" placeholder="Seconds" value="{{old('podcast_length_s', $content->podcast_length_s)}}">
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <label class="form-control-label" for="external_link" id="external_link_label">Link <strong class="text-danger">*</strong></label>
                                              <div class="input-group mb-3">
                                                <input type="url" class="form-control" id="external_link" name="external_link" placeholder="Enter URL " value="{{old('external_link', $content->external_link)}}">
                                              </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-12 text-center">
                                          <input type="submit" class="btn btn-primary  text-uppercase float-left " name="submit" value="Save">
                                          <a href="{{route('user.account.contents', [$content->content_account->hashid, Auth::user()->id])}}" class="btn btn-default  text-uppercase float-left ml-2 ">Cancel</a>
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
</div>
</article>
</main>
<!--End main Part-->
<!-- Start Modal -->
<div class="modal fade" id="content-terms" style="top:35px;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title">Listing Rules</h5>
          <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body" id="">
          <ul>
              <li> - Do not create listings for content you do not own</li>
              <li> - Do not list illegal content</li>
              <li> - Do not list meaningless, short text tweets</li>
              <li> - Do not list singular images (minimum is 2 images)</li>
              <li> - Do not list pornography content</li>
              <li> - Do not list abusive content</li>
              <li> - Do not list content where there is direct selling of a product or service (no commercial
                  content)</li>
              <li> - Do not spam or create a misleading listing</li>
              <li> - Do not create the same exact listing (with the same link) more than once</li>
              <li> - No links allowed in the description area of a content listing</li>
          </ul>
      </div>
      <div class="modal-footer">
          <button type="button" id="confirm-create-content" class="btn btn-primary">Ok</button>
          <button type="button" id="cancel-create-content" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Page content -->

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
var main_title= '{{$content->main_title}}';
$(document).ready(function() {


  var date = new Date();

  $('#posted_at').datepicker({
    endDate: date,
    format:'yyyy-mm-dd'
  });

  // Content Terms
  if(main_title == '')
  {
      $('#content-terms').modal({
          show: true
      });
  }

  $(document).on('click','#cancel-create-content',function(event)
  {
      window.history.back();
  });

  $(document).on('click','#confirm-create-content',function(event)
  {
      $('#content-terms').modal('hide');
  });

  $('#tags').tagsinput({maxChars:25});

  $('#tags').on('beforeItemAdd', function(event) {
      var item = event.item;


      if(!item.match("^#"))
      {
        event.cancel=true;
        event.preventDefault=true;
        item = item.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '');
        item=item.replace(" ", "");
        item='#'+item;
        $('#tags').tagsinput('add', item);
      }
  });

    bindType();

    @if($content->main_image)
        $(".dz-preview.dz-preview-single").html('<div class="dz-preview-cover dz-processing dz-image-preview dz-success dz-complete"><img class="dz-preview-img" src="{{asset($content->main_image_url)}}"></div>');
        $(".dropzone.dropzone-single").addClass('dz-clickable dz-max-files-reached');
    @endif

    $('.js-example-basic-single').select2({
      'width': '100%'
    });
});

function bindType()
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


function validateStep2()
{
  var main_title    = $('#main_title').val();
  var category_id   = $('#category_id').val();
  var posted_at     = $('#posted_at').val();
  var tags          = $('#tags').val();
  var external_link = $('#external_link').val();
  var description   = $('#description').val();
  var image         = $('.dz-preview-img').length;
  var errorStr      = '<div class="pull-left offset-4">';
  var errCount      = 0;

  var type             = $('#type').val();
  var podcast_length_h = $('#podcast_length_h').val();
  var podcast_length_m = $('#podcast_length_m').val();
  var podcast_length_s = $('#podcast_length_s').val();
  var number_of_images = $('#number_of_images').val();
  var video_length_h   = $('#video_length_h').val();
  var video_length_m   = $('#video_length_m').val();
  var video_length_s   = $('#video_length_s').val();
  var number_of_words  = $('#number_of_words').val();


  if(image == 0)
  {
    errorStr += '<p class="text-left">Please upload Thumbnail.</p>';
    errCount++;
  }

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

  if(tags == '')
  {
    errorStr += '<p class="text-left">Please enter tags.</p>';
    errCount++;
  }


  if(description == '')
  {
    errorStr += '<p class="text-left">Please enter description.</p>';
    errCount++;
  }

  if(type == 1 && number_of_images < 2)
  {
    errorStr += '<p class="text-left">Please enter number images (minimum 2).</p>';
    errCount++;
  }

  if(type == 2 && video_length_h <= 0 && video_length_m <= 0 && video_length_s <= 0)
  {
    errorStr += '<p class="text-left">Please enter video length.</p>';
    errCount++;
  }

  if(type == 3 && podcast_length_h <= 0 && podcast_length_m <= 0 && podcast_length_s <= 0)
  {
    errorStr += '<p class="text-left">Please enter audio length.</p>';
    errCount++;
  }

  if(type == 4 && number_of_words <= 0)
  {
    errorStr += '<p class="text-left">Please enter number of words.</p>';
    errCount++;
  }

  if(external_link == '')
  {
    errorStr += '<p class="text-left">Please enter external link.</p>';
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