@if($content && count($content)>0)
    @foreach($content as $item)
        <div class="col-lg-4 pb-5">
            <!-- Image-Text card -->

            <div class="card custom_card_front">
                <!-- Card image -->
                <img class="card-img-top" src="{{asset($item->main_image_url)}}" alt="Image placeholder" height="250">
                <!-- Card body -->
                <div class="card-body">
                    <a href="{{route('result.get-details',$item->hashid)}}">
                        <span class="content-title mb-0">{{ucfirst($item->main_title)}}</span>
                    </a>
                    @php
                        $category_name = isset($item->content_category->name) ? $item->content_category->name : '';
                    @endphp
                    <p class="card-text mt-2 text-uppercase text-muted font-12">
                        {{$category_name}}
                    </p>
                </div>
                <div class="card-footer text-center">
                    <a href="{{route('user.content.edit', $item->hashid)}}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
                    <a href="javascript:void(0);" data-id={{$item->id}} class="btn btn-sm btn-danger delete-content"><i class="fa fa-trash"></i> Delete</a>
                </div>
            </div>
        </div>
    @endforeach
@else
<div class="col-lg-12">
    <!-- Image-Text card -->
    <div class="card">
        <!-- Card body -->
        <div class="card-body">
            <h5 class="h3 card-title mb-0 text-center">No records available.</h5>
        </div>
    </div>
</div>
@endif
