@extends('layouts.app')
@section('title', 'Create New XP Pen Product')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-pencil' style="color: rgb(128, 7, 133);"></i>
        <div>New XP Pen Product Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">New XP Pen Product Creation</span>

       @include('admin.xp_pen.products.form')
    </div>
@endsection

@section('scripts')
    <script>
        Dropzone.autoDiscover = false;
        let product_images = []
    </script>
    <script src="{{asset('js/xp-pen/xppen_product.js')}}"></script>
@endsection
