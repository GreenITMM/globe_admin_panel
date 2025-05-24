@extends('layouts.app')
@section('title', 'City')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-map-pin' style="color: rgb(22, 133, 7);"></i>
        <div>Cities</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Cities List</span>
            {{-- @can('brand_create') --}}
                <a href="{{ route('admin.cities.create') }}" class="btn btn-primary text-decoration-none text-white"><i
                        class='bx bxs-plus-circle me-2'></i>
                    Create New City</a>
            {{-- @endcan --}}
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th>Name</th>
                    <th>State</th>
                    <th>Delivery Charges</th>
                    <th class="no-sort text-nowrap">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/delivery-management/city.js')}}"></script>
@endsection
