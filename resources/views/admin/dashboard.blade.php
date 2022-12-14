@extends('layouts.adminapp')

@section('content')
<div class="header bg-primary pb-7">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                  <h6 class="h2 text-white d-inline-block mb-0">Dashboards</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fas fa-home"></i></a></li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Users</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$totalUser}} ({{$totalHybridUser}} Hybrid)</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <a href="{{route('admin.user.list')}}" class="text-nowrap font-weight-600">See Details</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Hybrid Users</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$totalHybridUser}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <a href="{{route('admin.user.list')}}" class="text-nowrap font-weight-600">See Details</a>
                            </p>
                        </div>
                    </div>
                </div> -->

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Creators</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$totalCreator}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <a href="{{route('admin.creator.list')}}" class="text-nowrap font-weight-600">See Details</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Contents</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$totalContent}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        <i class="ni ni-collection"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <a href="{{route('admin.content.list')}}" class="text-nowrap font-weight-600">See Details</a>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Page content -->

<style type="text/css">
    .card{
        height: 100%;
        margin-bottom: 2.5rem;
    }
    .card-stats .card-body{
        display: block;
        flex: 0;
    }
    .card-stats .card-body p{
        position: absolute;
        bottom: 1rem;
    }
</style>

@endsection
