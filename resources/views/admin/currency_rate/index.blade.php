@extends('layouts.app')
@section('title', 'Currency Rate')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-dollar-circle' style="color: rgb(15, 155, 27);" ></i>
        <div>Currency Rate</div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5 class="fw-bold">USD-MMK Rate</h5>
            <div class="d-flex align-items-center gap-3">
                <div>
                    <label for="">USD</label>
                    <input type="text" class="form-control" id="usd" name="usd" value="1 USD" readonly>
                </div>
                <div>
                    <i class='bx bx-code fs-3 pt-4'></i>
                </div>
                <div>
                    <label for="">MMK</label>
                    <input type="number" min="0" class="form-control" id="mmk" name="mmk" value="{{$rate}}" {{($rate && $rate > 0) ? 'readonly' : ''}}>
                </div>
                <div class="pt-4 d-flex gap-2">
                    <div class="save-group">
                        <button type="button" style="background: green;" class="px-2 py-2 border-0 rounded-2 d-flex justify-content-center align-items-center save-btn"><i class='bx bxs-check-circle fs-4 text-white'></i></button>
                    </div>
                    <div class="edit-group">
                        <button type="button" style="background: rgb(189, 147, 10);" class="px-2 py-2 border-0 rounded-2 d-flex justify-content-center align-items-center edit-btn"><i class='bx bxs-edit-alt fs-4 text-white' ></i></button>
                    </div>
                    <div class="d-flex gap-2 update-group">
                        <button type="button" style="background: green;" class="px-2 py-2 border-0 rounded-2 d-flex justify-content-center align-items-center update-btn"><i class='bx bxs-check-circle fs-4 text-white'></i></button>
                        <button type="button" style="background: rgb(226, 18, 18);" class="px-2 py-2 border-0 rounded-2 d-flex justify-content-center align-items-center cancel-btn"><i class='bx bx-x-circle fs-4 text-white'></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let rate = {!!  json_encode($rate) !!};
    </script>
    <script src="{{asset('js/currency/currency_rate.js')}}"></script>
@endsection
