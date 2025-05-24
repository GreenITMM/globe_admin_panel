<form id="{{request()->is('admin/content-management/partners/create') ? 'partner_create_form' : 'partner_edit_form'}}">
    @csrf
    <div class="row">
        <input type="hidden" name="partner_id" id="partner_id" value="{{isset($partner) ? $partner->id : null}}">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Partner Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" value="{{isset($partner) ? $partner->name : ''}}" class="form-control name">
                <span class="text-danger name_err"></span>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Partner Logo <span class="text-danger">*</span></label>
                <input type="file" name="logo" class="form-control logo" value="" >
                <span class="text-danger logo_err"></span>
                <img src="{{isset($partner) ? asset('storage'.$partner->logo) :  ''}}" class="mt-2" width="150"  style="object-fit: cover;" alt="" id="preview_img">
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Partner Website <span class="font-italic ">(optional)</span></label>
                <input type="text" name="website_url" id="website_url" value="{{isset($partner) ? $partner->website_url : ''}}" class="form-control website_url">
                <span class="text-danger website_url_err"></span>
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
