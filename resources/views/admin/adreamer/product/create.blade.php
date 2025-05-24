@extends('layouts.app')
@section('title', 'Create Product')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Product Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Product Creation</span>

       @include('admin.adreamer.product.form')
    </div>
@endsection

@section('scripts')
    <script>
        Dropzone.autoDiscover = false;
        let product_images = []
        let attributes = {!! json_encode($attributes) !!}
    </script>
    <script src="{{asset('js/adreamer/product.js')}}"></script>
@endsection
