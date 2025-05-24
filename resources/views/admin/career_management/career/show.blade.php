@extends('layouts.app')
@section('title', 'Career Detail')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-laptop' style="color: rgb(128, 7, 133);"></i>
        <div>Career Detail</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Career Detail</span>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="DataTable">
                <tr>
                    <th>Position</th>
                    <td>{{ $career->position->name }}</td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td>{{ $career->department->name }}</td>
                </tr>
                <tr>
                    <th>Job Responsibility</th>
                    <td>{!! $career->job_responsibility !!}</td>
                </tr>
                <tr>
                    <th>Job Requirement</th>
                    <td>{!! $career->job_requirement !!}</td>
                </tr>

            </table>
            <button class="btn btn-outline-secondary mt-3 back-btn">Back to List</button>
        </div>
    </div>
@endsection
