@extends('layouts.app')
@section('title', 'Create Series')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Series Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Series Creation</span>

       @include('admin.product_management.series.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/product-management/series.js')}}"></script>
@endsection
