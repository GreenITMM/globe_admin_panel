@extends('layouts.app')
@section('title', 'Edit Position')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Position Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Position Edition</span>

       @include('admin.career_management.position.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/career-management/position.js')}}"></script>
@endsection
