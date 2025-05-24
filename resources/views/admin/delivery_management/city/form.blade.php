<form id="{{request()->is('admin/delivery-management/cities/create') ? 'city_create_form' : 'city_edit_form'}}">
    @csrf
    <div class="row">
        <input type="hidden" name="city_id" id="city_id" value="{{isset($city) ? $city->id : null}}">

        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">State <span class="text-danger">*</span></label>
                <select name="state_id" id="" class="form-select select2 state_id" data-placeholder="---Please Select---">
                    <option value=""></option>
                    @foreach ($states as $state)
                        <option value="{{$state->id}}" {{isset($city) && $city->state_id == $state->id ? 'selected' : ''}}>{{$state->name}}</option>
                    @endforeach
                </select>
                <span class="text-danger state_id_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control name" value="{{ old('name', isset($city) ? $city->name : null) }}">
                <span class="text-danger name_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Delivery Charges <span class="text-danger">*</span></label>
                <input type="text" name="delivery_charges" class="form-control delivery_charges" value="{{ old('delivery_charges', isset($city) ? $city->delivery_charges : null) }}">
                <span class="text-danger delivery_charges_err"></span>
            </div>
        </div>

    </div>
    <div class="mt-5">
        <div class="d-flex  gap-2">
            <button class="btn btn-secondary back-btn">Cancel</button>
            <button class="btn btn-primary">Save</button>
        </div>
    </div>
</form>
