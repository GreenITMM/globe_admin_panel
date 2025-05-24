@extends('layouts.app')
@section('title', 'Pending Order')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-cart' style="color: rgb(128, 7, 133);"></i>
        <div>Pending Orders</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Pending Orders List</span>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th>Order Code</th>
                    <th>Customer</th>
                    <th>Delivery City</th>
                    <th>Payment Method</th>
                    <th>Total Qty</th>
                    <th>Total Amount</th>
                    <th class="no-sort text-nowrap">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/order-management/pending_order.js')}}"></script>
@endsection
