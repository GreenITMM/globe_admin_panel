@extends('layouts.app')
@section('title', 'Create Category')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Category Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Category Creation</span>

       @include('admin.product_management.category.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/product-management/category.js')}}"></script>
@endsection
