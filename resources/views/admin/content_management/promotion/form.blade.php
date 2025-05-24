<form id="{{request()->is('admin/content-management/promotions/create') ? 'promotion_create_form' : 'promotion_edit_form'}}">
    @csrf
    <div class="row">
        <input type="hidden" name="promotion_id" id="promotion_id" value="{{isset($promotion) ? $promotion->id : null}}">
        <div class="col-md-4 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Image <span class="text-danger">*</span></label>
                <input type="file" name="image" class="form-control image" value="" >
                <span class="text-danger image_err"></span>
                <img src="{{isset($promotion) ? asset('storage'.$promotion->image) :  ''}}" class="mt-2" width="150"  style="object-fit: cover;" alt="" id="preview_img">
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Description <span class="text-danger">*</span></label>
                <input type="text" name="description" id="description" value="{{isset($promotion) ? $promotion->description : ''}}" class="form-control description">
                <span class="text-danger description_err"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Start Date <span class="text-danger">*</span></label>
                <input type="text" name="start_date" id="start_date" value="{{isset($promotion) ? $promotion->start_date : ''}}" placeholder="YYYY-MM-DD" class="form-control date start_date">
                <span class="text-danger start_date_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">End Date <span class="text-danger">*</span></label>
                <input type="text" name="end_date" id="end_date" value="{{isset($promotion) ? $promotion->end_date : ''}}" placeholder="YYYY-MM-DD" class="form-control date end_date">
                <span class="text-danger end_date_err"></span>
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
