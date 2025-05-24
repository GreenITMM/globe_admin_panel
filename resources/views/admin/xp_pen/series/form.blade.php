<form id="{{request()->is('admin/xppen/xppen-series/create') ? 'xppen_series_create_form' : 'xppen_series_edit_form'}}">
    @csrf
    <div class="row">
        <input type="hidden" name="xppen_series_id" id="xppen_series_id" value="{{isset($xppen_series) ? $xppen_series->id : null}}">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control name" value="{{ old('name', isset($xppen_series) ? $xppen_series->name : null) }}" placeholder="eg. Deco Pro Series ...">
                <span class="text-danger name_err"></span>
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
