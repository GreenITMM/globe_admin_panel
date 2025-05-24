@extends('layouts.app')
@section('title', 'Partner')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-briefcase-alt' style="color: rgb(71, 146, 52);"></i>
        <div>Partners</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Partners List</span>
            {{-- @can('brand_create') --}}
                <a href="{{ route('admin.partners.create') }}" class="btn btn-primary text-decoration-none text-white"><i
                        class='bx bxs-plus-circle me-2'></i>
                    Create New Partner</a>
            {{-- @endcan --}}
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th>Partner Name</th>
                    <th>Logo</th>
                    <th>Website URL</th>
                    <th class="no-sort text-nowrap">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content-management/partner.js')}}"></script>
@endsection
