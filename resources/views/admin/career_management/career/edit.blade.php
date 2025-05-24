@extends('layouts.app')
@section('title', 'Edit Career')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Career Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Career Edition</span>

       @include('admin.career_management.career.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/career-management/career.js')}}"></script>
@endsection
