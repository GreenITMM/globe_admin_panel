<form id="{{request()->is('admin/solar/solar-categories/create') ? 'solar_category_create_form' : 'solar_category_edit_form'}}">
    @csrf
    <div class="row">
        <input type="hidden" name="solar_category_id" id="solar_category_id" value="{{isset($solarCategory) ? $solarCategory->id : null}}">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" >
            <div class="form-group mb-4">
                <label for="">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control name" value="{{ old('name', isset($solarCategory) ? $solarCategory->name : null) }}" placeholder="Enter category name">
                <span class="text-danger name_err"></span>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Parent Category </label>
                <select name="parent_id" id="" class="form-select select2 parent_id" data-placeholder="---Please Select---">
                    <option value=""></option>
                    @foreach ($parent_categories as $category)
                        <option value="{{$category->id}}" {{isset($solarCategory) && $solarCategory->parent_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                    @endforeach
                </select>
                <span class="text-danger parent_id_err"></span>
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
