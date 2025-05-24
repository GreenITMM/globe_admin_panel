@extends('layouts.app')
@section('title', 'Promotion')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-dollar-circle' style="color: rgb(71, 146, 52);"></i>
        <div>Promotions</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Promotions List</span>
            {{-- @can('brand_create') --}}
                <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary text-decoration-none text-white"><i
                        class='bx bxs-plus-circle me-2'></i>
                    Create New Promotion</a>
            {{-- @endcan --}}
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Is Publish</th>
                    <th class="no-sort text-nowrap">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content-management/promotion.js')}}"></script>
@endsection
