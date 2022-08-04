@if($item->tags()->count())
    @foreach ($item->tags as $tag)
        <span class="label-info-tag "><a href="javascript:void(0);">#{{$tag->name}}</a></span>
    @endforeach
@else
    <span class="label-info-tag no-tags">No tags found</span>
@endif