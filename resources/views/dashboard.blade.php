@extends('layouts.app')

@section('content')
    <div class="content-wrapper dashboard">
        <!-- Content -->
        <div class="card" style="min-height: 75vh;">
            <div class="card-body p-4">
                <div class="banner">
                    <img class="banner" src="{{ asset('assets/images/welcome.jpg') }}" alt="">
                    <div class="d-flex justify-content-between align-items-center position-absolute top-0 w-100 h-100 px-5 ">
                        <div>
                            <h3 class="fw-bold">Welcome to</h3>
                            <h2 class="fw-bold">GLOBE ADMIN DASHBOARD</h2>
                            <button class="btn btn-dark mt-3">Explore</button>
                        </div>
                        <div class="banner-img">
                            <img class="w-100" src="{{ asset('assets/images/man.png ') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
@endsection
