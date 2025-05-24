@extends('layouts.app')
@section('title', 'Create New Adreamer Category')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-pencil' style="color: rgb(128, 7, 133);"></i>
        <div>New Adreamer Category Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">New Adreamer Category Creation</span>

       @include('admin.adreamer.category.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/adreamer/category.js')}}"></script>
@endsection
