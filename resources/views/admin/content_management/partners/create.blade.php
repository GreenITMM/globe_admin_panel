@extends('layouts.app')
@section('title', 'Create New Partner')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-briefcase-alt' style="color: rgb(71, 146, 52);"></i>
        <div>New Partner Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">New Partner Creation</span>

       @include('admin.content_management.partners.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content-management/partner.js')}}"></script>
@endsection
