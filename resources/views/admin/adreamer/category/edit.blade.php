@extends('layouts.app')
@section('title', 'Edit Adreamer Category')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Adreamer Category Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Adreamer Category Edition</span>

       @include('admin.adreamer.category.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/adreamer/category.js')}}"></script>
@endsection
