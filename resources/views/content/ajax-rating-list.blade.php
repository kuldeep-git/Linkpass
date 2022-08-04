@if($contentRatings && count($contentRatings)>0)
    @include('content.content_rating_data')
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end pt-2 ratings-pagination">
            {!! $contentRatings->links() !!}
        </ul>
    </nav>
@else
<article class="PopupCardBox">
    <div class="card col-md-12 text-center">
        <!-- Card body -->
        <div class="card-body">
            <span class="card-title mb-0 text-center">No matching records found</span>
        </div>
    </div>
</article>
@endif