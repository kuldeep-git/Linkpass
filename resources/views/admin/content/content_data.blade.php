@if($content && count($content)>0)
    @foreach($content as $selfdiagnos)
        <div class="col-lg-4 pb-5">
            <!-- Image-Text card -->
            <div class="card custom_card">
                <!-- Card image -->
                <img class="card-img-top" src="{{asset($selfdiagnos->main_image_url)}}" alt="Image placeholder">
                <!-- Card body -->
                <div class="card-body">
                    <h5 class="h2 card-title mb-0">{{ucfirst($selfdiagnos->main_title)}}</h5>
                    @php
                        $category_name = !empty($selfdiagnos->content_category->name) ? $selfdiagnos->content_category->name : '';
                    @endphp
                    <p class="card-text mt-4 text-uppercase text-muted h5">
                        {{$category_name}}
                    </p>
                    <p><a href="javascript:void(0);"><strong>{{$selfdiagnos->completion_content_count}} people viewed this content</strong></a></p>
                    <div class="footer-button">

                        <a href="{{route('admin.content.show',$selfdiagnos->hashid)}}" class="btn btn-success btn-sm">View</a>
                        <a href="{{route('admin.content.edit',$selfdiagnos->hashid)}}" class="btn btn-info btn-sm">Edit</a>
                        <form action="{{route('admin.content.destroy',$selfdiagnos->hashid)}}" method='POST' style='display: contents;' id="frm_{{$selfdiagnos->id}}">
                            @csrf
                            <input type='hidden' name='_method' value='DELETE'>
                            <a type="submit" class="btn btn-danger btn-sm" style="color: white;" onclick="return deleteConfirm(this);" id="{{$selfdiagnos->id}}">Delete</a>
                        </form>
                    </div>
                </div>
            </div>
            @if($selfdiagnos->status == '3')
            <div class="ribbon-wrapper">
                <div class="ribbon red">Draft</div>
            </div>
            @endif
        </div>
    @endforeach
@else
    <!-- Image-Text card -->
    <div class="card">
        <!-- Card body -->
        <div class="card-body">
            <h5 class="h3 card-title mb-0 text-center">No records available.</h5>
        </div>
    </div>
@endif
