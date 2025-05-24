@extends('layouts.app')
@section('title', 'Create New XP Pen Category')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-pencil' style="color: rgb(128, 7, 133);"></i>
        <div>New XP Pen Category Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">New XP Pen Category Creation</span>

       @include('admin.xp_pen.category.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/xp-pen/xppen_category.js')}}"></script>
@endsection
