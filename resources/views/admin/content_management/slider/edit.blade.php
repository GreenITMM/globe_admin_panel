@extends('layouts.app')
@section('title', 'Edit Slider')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Slider Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Slider Edition</span>

       @include('admin.content_management.slider.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content-management/slider.js')}}"></script>
@endsection
