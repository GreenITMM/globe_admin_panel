@extends('layouts.app')
@section('title', 'Create Department')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-map-alt' style="color: rgb(53, 133, 7);"></i>
        <div>Department Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Department Creation</span>

       @include('admin.delivery_management.state.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/delivery-management/state.js')}}"></script>
@endsection
