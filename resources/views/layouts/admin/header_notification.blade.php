<div class="dropdown-menu dropdown-menu-xl dropdown-menu-right py-0 overflow-hidden">
    <!-- Dropdown header -->
    <div class="px-3 py-3">
      <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">13</strong> notifications.</h6>
    </div>
    <!-- List group -->
    <div class="list-group list-group-flush">
        @for ($i = 0; $i < 5; $i++)
            <a href="#!" class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                <div class="col-auto">
                    <!-- Avatar -->
                    <img alt="Image placeholder" src="{{asset('assets/img/theme/defualt-user.png')}}" class="avatar rounded-circle">
                </div>
                <div class="col ml--2">
                    <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0 text-sm">John Snow</h4>
                    </div>
                    <div class="text-right text-muted">
                        <small>3 hrs ago</small>
                    </div>
                    </div>
                    <p class="text-sm mb-0">A new issue has been reported for Argon.</p>
                </div>
                </div>
            </a>
        @endfor
    </div>
    <!-- View all -->
    <a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a>
  </div>