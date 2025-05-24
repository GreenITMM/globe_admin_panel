@extends('layouts.app')
@section('title', 'XP Pen Product')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-pencil' style="color: rgb(128, 7, 133);"></i>

        <div>XP Pen Product</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>XP Pen Product List</span>
            {{-- @can('brand_create') --}}
                <a href="{{ route('admin.xppen-products.create') }}" class="btn btn-primary text-decoration-none text-white"><i
                        class='bx bxs-plus-circle me-2'></i>
                    Create New XP Pen Product</a>
            {{-- @endcan --}}
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th>Name</th>
                    <th class="no-sort">Images</th>
                    <th>Category</th>
                    <th>Series</th>
                    <th>Stock</th>
                    <th class="no-sort text-nowrap">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/xp-pen/xppen_product.js')}}"></script>
@endsection
