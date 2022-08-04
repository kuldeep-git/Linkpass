@if($items && count($items)>0)
    @include('content-rows')
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end pt-2 content-pagination">
            {!! $items->links() !!}
        </ul>
    </nav>
@else
<article class="PopupCardBox">
    <div class="card col-md-12 text-center">
        <!-- Card body -->
        <div class="card-body">
            <span class="card-title mb-0 text-center">No listings found</span>
        </div>
    </div>
</article>
@endif