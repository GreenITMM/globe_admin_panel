@extends('layouts.app')
@section('title', 'Create New Globe Solar Category')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-pencil' style="color: rgb(128, 7, 133);"></i>
        <div>New Globe Solar Category Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">New Globe Solar Category Creation</span>

       @include('admin.solar.category.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/solar/category.js')}}"></script>
@endsection
