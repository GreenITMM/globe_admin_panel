@extends('layouts.app')
@section('title', 'Create Attribute')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Attribute Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Attribute Creation</span>

       @include('admin.adreamer.attribute.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/adreamer/attribute.js')}}"></script>
@endsection
