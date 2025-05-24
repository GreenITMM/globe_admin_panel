@extends('layouts.app')
@section('title', 'Position')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Positions</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Positions List</span>
            {{-- @can('brand_create') --}}
                <a href="{{ route('admin.positions.create') }}" class="btn btn-primary text-decoration-none text-white"><i
                        class='bx bxs-plus-circle me-2'></i>
                    Create New Position</a>
            {{-- @endcan --}}
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th>Name</th>
                    <th class="no-sort text-nowrap">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/career-management/position.js')}}"></script>
@endsection
