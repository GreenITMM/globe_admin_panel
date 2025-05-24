@extends('layouts.app')
@section('title', 'Edit Product')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Product Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Product Edition</span>

       @include('admin.product_management.product.form')
    </div>
@endsection

@section('scripts')
    <script>
        Dropzone.autoDiscover = false;
        let product_images = {!! json_encode($product_images) !!};
        let attributes = {!! json_encode($attributes) !!}

    </script>
    <script src="{{asset('js/product-management/product.js')}}"></script>
@endsection
