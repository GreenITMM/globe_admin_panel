@extends('layouts.app')
@section('title', 'Edit Globe Solar Category')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Globe Solar Category Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Globe Solar Category Edition</span>

       @include('admin.solar.category.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/solar/category.js')}}"></script>
@endsection
