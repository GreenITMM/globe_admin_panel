@extends('layouts.app')
@section('title', 'Edit City')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>City Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">City Edition</span>

       @include('admin.delivery_management.city.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/delivery-management/city.js')}}"></script>
@endsection
