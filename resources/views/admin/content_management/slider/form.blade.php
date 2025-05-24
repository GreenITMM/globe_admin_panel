<form id="{{request()->is('admin/content-management/slider/create') ? 'slider_create_form' : 'slider_edit_form'}}">
    @csrf
    <div class="row">
        <input type="hidden" name="slider_id" id="slider_id" value="{{isset($slider) ? $slider->id : null}}">
        <div class="col-md-4 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Image <span class="text-danger">*</span></label>
                <input type="file" name="image" class="form-control image" value="" >
                <span class="text-danger image_err"></span>
                <img src="{{isset($slider) ? asset('storage'.$slider->image) :  ''}}" class="mt-2" width="150"  style="object-fit: cover;" alt="" id="preview_img">
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Image Order No <span class="text-danger">*</span></label>
                <input type="number" min="1" name="image_order_no" id="image_order_no" value="{{isset($slider) ? $slider->image_order_no : 0}}" class="form-control image_order_no">
                <span class="text-danger image_order_no_err"></span>
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
