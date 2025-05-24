@extends('layouts.app')
@section('title', 'Create Brand')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Brand Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Brand Creation</span>

       @include('admin.product_management.brand.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/product-management/brand.js')}}"></script>
@endsection
