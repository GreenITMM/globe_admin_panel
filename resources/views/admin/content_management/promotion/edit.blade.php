@extends('layouts.app')
@section('title', 'Edit Promotion')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Promotion Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Promotion Edition</span>

       @include('admin.content_management.promotion.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content-management/promotion.js')}}"></script>
@endsection
