@extends('layouts.app')
@section('title', 'Edit Attribute')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Attribute Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Attribute Edition</span>

       @include('admin.solar.attribute.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/solar/attribute.js')}}"></script>
@endsection
