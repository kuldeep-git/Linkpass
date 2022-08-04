<!-- Admin Dashboard Page -->
@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->name,
        'description' => __('This is your profile page. You can edit your name, email, or profile picture from here.'),
        'class' => 'col-lg-12'
    ])

    <!-- Page content -->
    <div class="container-fluid mt--7 pb-5">
      <!-- Table -->
      @foreach (['danger', 'warning', 'success', 'info'] as $msg)
          @if(Session::has('alert-' . $msg))
              <div class="alert alert-custom alert-{{ $msg }} alert-dismissible fade show mb-2" role="alert">
                  <div class="alert-text">{{ Session::get('alert-' . $msg) }}</div>
                  <div class="alert-close">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                      </button>
                  </div>
              </div>
          @endif
      @endforeach
      <div class="row">
        <div class="col-xl-4 order-xl-1 mb-5 mb-xl-0">
            @include('profile.left-bar-links')
        </div>
        <div class="col-xl-8 order-xl-2">

          <div class="card shadow">
            <!-- Card header -->
            <div class="bg-white border-0">
                <div class="row align-items-center ">
                   <div class="col-md-8">
                     <h4 class="mb-0 ml-3">{{ __('Social Accounts') }}</h4>
                   </div>
                   <div class="col-md-4">
                     <a href="{{route('user.social-account.create')}}" class="btn btn-warning mt-4">Add New Account</a>
                   </div>
                </div>
            </div>
            <div class="table-responsive py-4 px-4">
              <table class="table table-flush" id="datatable-social-accounts" style="font-size: 11px;">
                <thead class="thead-light">
                  <tr>
                    <th class="w-10">No.</th>
                    <th class="w-10">Image</th>
                    <th class="w-20">Name</th>
                    <th>URL</th>
                    <th>Account URL</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>


<style type="text/css">

td.details-control {
    /*background: url('assets/img/icons/details_open.png') no-repeat center center;*/
    cursor: pointer;
    text-align: center;
}
tr.shown td.details-control {
    /*background: url('assets/img/icons/details_close.png') no-repeat center center;*/
}

table.message_list td, table.message_list th{
  word-wrap: break-word !important;
    white-space: break-spaces !important;
}
.message_list .left-message .message_content{
  max-width: 85%;
  float: left;
  background: #ECECEC;
  padding: 15px;
  border-radius: 15px;
  border-bottom-left-radius: 0;
   position: relative;
}
.message_list .right-message .message_content{
  max-width: 85%;
  float: right;
  background: #579FFB;
  color: #fff;
  padding: 15px;
  border-radius: 15px;
  border-bottom-right-radius: 0;
  position: relative;
  min-width: 170px;
}
.message_list .left-message,
.message_list .right-message {
    width: 100%;
    display: inline;
    position: relative;
    float: left;
    margin-top: 30px;
}
.message_list .message_content p{
  margin-bottom:0;
}

.msger-inputarea {
    display: flex;
    padding: 10px;
    border-top: var(--border);
    background: #eee;
}
.msger-input {
    flex: 1;
    background: #ddd;
}
.msger-inputarea * {
    padding: 10px;
    border: none;
    border-radius: 3px;
    font-size: 1em;
}
.msger-send-btn {
    margin-left: 10px;
    background: rgb(0, 196, 65);
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.23s;
}
.scroll-wrapper > .message_list.scroll-content {
    width: 100% !important;
    padding: 10px !important;
    box-sizing: border-box !important;
    position: static !important;
}
.message_list {
    width: 100%;
    border: 1px solid #eee;
    flex: 1;
    overflow-y: auto;
    padding: 10px;
    background-color: #fcfcfe;
    background-image: url('assets/img/theme/chat-bg.svg');
    height: 450px;
    display: inline-block;
    padding: 10px !important;
    white-space: normal;
}

.message-info-time-left {
    position: absolute;
    left: 0px;
    color: #000;
    margin-top: 18px;
}
.message-info-time-right
{
    position: absolute;
    bottom: -22px;
    right: 0px;
    color: #000;
}
.message_list tr:last-child > td {
    padding-bottom: 30px !important;
}

.comments-listing-loader .fa.fa-spinner{

    position: relative;
    top: 50%;
}
.message_comment_content{
    float: left;
    width: 100%;
}
</style>
@endsection
@section('pagewise_js')
<script>
    $(document).ready(function () {
        var table = $('#datatable-social-accounts').DataTable({
            "processing": true,
            "serverSide": true,
            "destroy": true,
            "searching": false,
            responsive: true,
            language: {
              paginate: {
                previous: "<i class='fas fa-angle-left'>",
                next: "<i class='fas fa-angle-right'>"
              }
            },
            "ajax":{
                "url": "{{ route('user.social-account.listdata') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d, settings){

                    var api = new $.fn.dataTable.Api(settings);

                     // Convert starting record into page number
                    d.pageNumber = Math.min(
                        Math.max(0, Math.round(d.start / api.page.len())),
                        api.page.info().pages
                    );
                    d._token = "{{ csrf_token() }}";
                }
            },
            'columnDefs': [{
                "targets": 0,
                "orderable": false
            }],
            "columns": [
                { "data": "srnumber" },
                {
                  "orderable"      : false,
                  "data"           : 'image'
                },
                { "data": "name" },
                { "data": "url" },
                { "data": "account_url" },
                {
                  "className"      : 'details-control',
                  "orderable"      : false,
                  "data"           : 'actions',
                  "defaultContent" : ''
                },
            ]

        });

        table.order( [[ 1, 'asc' ]] ).draw();
});

function deleteConfirm(event){
  var id = $(event).attr('id');

  swal({
    title: "Are you sure?",
    text: "Would you like to delete this Listing Group?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Yes, Delete it!',
    cancelButtonText: "No, Cancel it!"
  }).then((result) => {
    if (result.value) {
      $("#frm_"+id).submit();
    }
  });
}



</script>
@endsection