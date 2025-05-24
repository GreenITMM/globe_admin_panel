<form id="{{request()->is('admin/product-management/series/create') ? 'series_create_form' : 'series_edit_form'}}">
    @csrf
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <input type="hidden" name="series_slug" id="series_slug" value="{{isset($series) ? $series->slug : null}}">
            <div class="form-group mb-4">
                <label for="">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control name" value="{{ old('name', isset($series) ? $series->name : null) }}">
                <span class="text-danger name_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Brand <span class="text-danger">*</span></label>
                <select name="brand_id" id="" class="form-select select2 brand_id" data-placeholder="---Please Select---">
                    <option value=""></option>
                    @foreach ($brands as $brand)
                        <option value="{{$brand->id}}" {{isset($series) && $series->brand_id == $brand->id ? 'selected' : ''}} >{{$brand->name}}</option>
                    @endforeach
                </select>
                <span class="text-danger brand_id_err"></span>
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
