@extends('layouts.app')
@section('title', 'Adreamer Category')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-pencil' style="color: rgb(128, 7, 133);"></i>

        <div>Adreamer Category</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Adreamer Category List</span>
            {{-- @can('brand_create') --}}
                <a href="{{ route('admin.adreamer-categories.create') }}" class="btn btn-primary text-decoration-none text-white"><i
                        class='bx bxs-plus-circle me-2'></i>
                    Create New Adreamer Category</a>
            {{-- @endcan --}}
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th>Name</th>
                    <th>Image</th>
                    <th class="no-sort text-nowrap">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/adreamer/category.js')}}"></script>
@endsection
