@extends('layouts.app')
@section('title', 'Edit Partner')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-briefcase-alt' style="color: rgb(71, 146, 52);"></i>
        <div>Partner Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Partner Edition</span>

       @include('admin.content_management.partners.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content-management/partner.js')}}"></script>
@endsection
