@extends('layouts.app')
@section('title', 'Product Detail')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Product Detail</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Product Detail</span>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="DataTable">
                <tr>
                    <th>Name</th>
                    <td>{{ $xppen_product->name }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $xppen_product->category->name }}</td>
                </tr>
                <tr>
                    <th>Series</th>
                    <td>{{ $xppen_product->series ? $xppen_product->series->name : '' }}</td>
                </tr>
                <tr>
                    <th>Price MK</th>
                    <td>{{ $xppen_product->price_mmk }}</td>
                </tr>
                <tr>
                    <th>Price USD</th>
                    <td>{{ $xppen_product->price_us }}</td>
                </tr>
                <tr>
                    <th>Images</th>
                    <td>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($xppen_product->images as $file)
                                <img style="width: 120px; object-fit: cover;" src="{{asset('storage/'. $file->image)}}" alt="">
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Specification</th>
                    <td>{!! $xppen_product->specification !!}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $xppen_product->description }}</td>
                </tr>
            </table>
            <button class="btn btn-outline-secondary mt-3 back-btn">Back to List</button>
        </div>
    </div>
@endsection
