@extends('layouts.app')
@section('title', 'Create Department')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Department Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Department Creation</span>

       @include('admin.career_management.department.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/career-management/department.js')}}"></script>
@endsection
