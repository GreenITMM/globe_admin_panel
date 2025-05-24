@extends('layouts.app')
@section('title', 'Create New Promotion')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-dollar-circle' style="color: rgb(71, 146, 52);"></i>
        <div>New Promotion Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">New Promotion Creation</span>

       @include('admin.content_management.promotion.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content-management/promotion.js')}}"></script>
@endsection
