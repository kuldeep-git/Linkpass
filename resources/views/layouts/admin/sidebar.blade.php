<!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand main-logo" href="{{route('admin.dashboard')}}">
          <img src="{{asset('assets/img/logo.svg')}}" class="navbar-brand-img" alt="...">
        </a>
        <div class="ml-auto">
          <!-- Sidenav toggler -->
          <!-- <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div> -->
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" href="{{route('admin.dashboard')}}">
                <i class="ni ni-shop text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link {{ Request::routeIs('admin.user.*') ? 'active' : '' }}" href="#navbar-forms-user" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-forms-user">
                <i class="fas fa-users text-green"></i>
                <span class="nav-link-text">Users</span>
              </a>
              <div class="collapse {{ Request::routeIs('admin.user.*') ? 'show' : '' }}" id="navbar-forms-user" style="">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{route('admin.user.list')}}" class="nav-link {{ Request::routeIs('admin.user.list') ? 'active' : '' }}">All Users</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('admin.user.create')}}" class="nav-link {{ Request::routeIs('admin.user.create') ? 'active' : '' }}">Add New User</a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link {{ Request::routeIs('admin.creator.*') ? 'active' : '' }}" href="#navbar-forms-creator" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-forms-user">
                <i class="fas fa-users text-green"></i>
                <span class="nav-link-text">Creators</span>
              </a>
              <div class="collapse {{ Request::routeIs('admin.creator.*') ? 'show' : '' }}" id="navbar-forms-creator" style="">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{route('admin.creator.list')}}" class="nav-link {{ Request::routeIs('admin.creator.list') ? 'active' : '' }}">All Creators</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('admin.creator.create')}}" class="nav-link {{ Request::routeIs('admin.creator.create') ? 'active' : '' }}">Add New Creator</a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link {{ Request::routeIs('admin.cms.page.*') ? 'active' : '' }}" href="{{route('admin.cms.page.list')}}">
                <i class="ni ni-single-copy-04 text-pink"></i>
                <span class="nav-link-text">CMS Pages</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link {{ Request::routeIs('admin.content.*') ? 'active' : '' }}" href="#navbar-forms-content" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-forms-content">
                <i class="ni ni-collection text-orange"></i>
                <span class="nav-link-text">Content</span>
              </a>
              <div class="collapse {{ Request::routeIs('admin.content.*') ? 'show' : '' }}" id="navbar-forms-content" style="">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{route('admin.content.list')}}" class="nav-link {{ Request::routeIs('admin.content.list') ? 'active' : '' }}">All Content</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('admin.content.create')}}" class="nav-link {{ Request::routeIs('admin.content.create') ? 'active' : '' }}">Add New Content</a>
                  </li>
                </ul>
              </div>
            </li>


            <li class="nav-item">
              <a class="nav-link {{ Request::routeIs('admin.category.*') ? 'active' : '' }}" href="{{route('admin.category.list')}}">
                <i class="ni ni-ungroup text-info"></i>
                <span class="nav-link-text">Categories</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link {{ Request::routeIs('admin.enquiry.*') ? 'active' : '' }}" href="{{route('admin.enquiry.list')}}">
                <i class="ni ni-ungroup text-info"></i>
                <span class="nav-link-text">Enquiries</span>
              </a>
            </li>

          </ul>

        </div>
      </div>
    </div>
  </nav>