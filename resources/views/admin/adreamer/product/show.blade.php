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
                    <td>{{ $adreamerProduct->name }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $adreamerProduct->category->name }}</td>
                </tr>
                <tr>
                    <th>Images</th>
                    <td>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($adreamerProduct->images as $file)
                                <img style="width: 120px; object-fit: cover;" src="{{asset('storage/'. $file->image)}}" alt="">
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $adreamerProduct->description }}</td>
                </tr>
                <tr>
                    <th>Specification</th>
                    <td>{!! $adreamerProduct->specification !!}</td>
                </tr>

            </table>
            <button class="btn btn-outline-secondary mt-3 back-btn">Back to List</button>
        </div>
    </div>
@endsection
