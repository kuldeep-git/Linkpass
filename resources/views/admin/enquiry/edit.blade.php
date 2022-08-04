@extends('layouts.adminapp')

@section('content')
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Enquiries</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="{{route('admin.enquiry.list')}}">Category List</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="{{route('admin.enquiry.list')}}" class="btn btn-sm btn-neutral">Back</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="card mb-4">
            <!-- Card header -->
            <div class="card-header">
              <h3 class="mb-0">{{$title}}</h3>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <!-- Form groups used in grid -->
                <form class="form" action="{{ route('admin.enquiry.update',$enquirydata->hashid) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group @if($errors->has('subject')) has-danger @endif ">
                                  <label class="form-control-label" for="subject">Subject&nbsp;<strong class="text-danger">*</strong></label>
                                  <input type="text" class="form-control  @if($errors->has('subject')) is-invalid @endif maxlength" name="subject" id="subject" placeholder="Subject" value="{{old('subject',$enquirydata->subject)}}">
                                  @if($errors->has('subject'))
                                      <span class="invalid-feedback">{{ $errors->first('subject') }}</span>
                                  @endif
                              </div>
                          </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if($errors->has('message')) has-danger @endif ">
                                <label class="form-control-label" for="subject">Message&nbsp;<strong class="text-danger">*</strong></label>
                                <textarea rows="5" type="text" class="form-control  @if($errors->has('subject')) is-invalid @endif maxlength" name="message" id="message" placeholder="Message">{{$enquirydata->message}}</textarea>
                                @if($errors->has('message'))
                                    <span class="invalid-feedback">{{ $errors->first('message') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr>
                    <button class="btn btn-primary" type="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('pagewise_js')
<script type="text/javascript">
$(document).ready(function() {

});
</script>
@endsection