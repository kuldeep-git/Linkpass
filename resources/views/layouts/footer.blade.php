<!--Start footer-->
<footer class="footer">
  <article class="container">
    <ul class="footer-mennu">
      @php
          $cms_page = \App\CmsPage::where('status','1')->get();
          @endphp
          @if($cms_page->count() > 0)
            @foreach($cms_page as $page)
              <li class="nav-item">
                <a href="{{asset($page->url_slug)}}" target="_blank">{{$page->title}}</a>
              </li>
            @endforeach
          @endif
    </ul>
    <!--Start Footer copyright Section-->
    <section class="copy"> &copy; {{date('Y')}} LinkPasser. All Rights Reserved. </section>
    <!--End Footer copyright Section-->
  </article>
</footer>
<!--End footer-->