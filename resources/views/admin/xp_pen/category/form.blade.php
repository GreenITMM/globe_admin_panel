<form id="{{request()->is('admin/xppen/xppen-categories/create') ? 'xppen_category_create_form' : 'xppen_category_edit_form'}}">
    @csrf
    <div class="row">
        <input type="hidden" name="xppen_category_id" id="xppen_category_id" value="{{isset($xppen_category) ? $xppen_category->id : null}}">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control name" value="{{ old('name', isset($xppen_category) ? $xppen_category->name : null) }}" placeholder="eg. Drawing Tablets ...">
                <span class="text-danger name_err"></span>
            </div>
        </div>

        <div class="col-md-4 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Image <span class="fst-italic"> (optional)</span></label>
                <input type="file" name="image" class="form-control image" value="" >
                <span class="text-danger image_err"></span>
                <img src="{{isset($xppen_category) ? asset('storage'.$xppen_category->image) :  ''}}" class="mt-2" width="150"  style="object-fit: cover;" alt="" id="preview_img">
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
