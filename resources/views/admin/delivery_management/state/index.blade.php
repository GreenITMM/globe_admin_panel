@extends('layouts.app')
@section('title', 'State')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-map-alt' style="color: rgb(53, 133, 7);"></i>
        <div>States</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>States List</span>
            {{-- @can('brand_create') --}}
                <a href="{{ route('admin.states.create') }}" class="btn btn-primary text-decoration-none text-white"><i
                        class='bx bxs-plus-circle me-2'></i>
                    Create New State</a>
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
    <script src="{{asset('js/delivery-management/state.js')}}"></script>
@endsection
