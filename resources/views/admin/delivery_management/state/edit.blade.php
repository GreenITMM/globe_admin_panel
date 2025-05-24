@extends('layouts.app')
@section('title', 'Edit State')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-map-alt' style="color: rgb(53, 133, 7);"></i>
        <div>State Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">State Edition</span>

       @include('admin.delivery_management.state.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/delivery-management/state.js')}}"></script>
@endsection
