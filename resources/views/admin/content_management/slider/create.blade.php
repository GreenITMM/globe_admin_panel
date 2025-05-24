@extends('layouts.app')
@section('title', 'Create New Slider')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>New Slider Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">New Slider Creation</span>

       @include('admin.content_management.slider.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content-management/slider.js')}}"></script>
@endsection
