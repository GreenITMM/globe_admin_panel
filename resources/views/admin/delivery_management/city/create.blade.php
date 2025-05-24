@extends('layouts.app')
@section('title', 'Create City')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-map-pin' style="color: rgb(22, 133, 7);"></i>
        <div>City Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">City Creation</span>

       @include('admin.delivery_management.city.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/delivery-management/city.js')}}"></script>
@endsection
