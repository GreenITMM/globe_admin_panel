@extends('layouts.app')
@section('title', 'Edit XP Pen Product')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-pencil' style="color: rgb(128, 7, 133);"></i>
        <div>XP Pen Product Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">XP Pen Product Edition</span>

        @include('admin.xp_pen.products.form')
    </div>
@endsection

@section('scripts')
    <script>
        Dropzone.autoDiscover = false;
        let product_images = {!! json_encode($product_images) !!};
    </script>
    <script src="{{asset('js/xp-pen/xppen_product.js')}}"></script>
@endsection
