<form id="{{request()->is('admin/xppen/xppen-products/create') ? 'xppen_product_create_form' : 'xppen_product_edit_form'}}">
    @csrf
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <input type="hidden" name="xppen_product_id" id="xppen_product_id" value="{{isset($xppen_product) ? $xppen_product->id : null}}">
            <div class="form-group mb-4">
                <label for="">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control name" value="{{ old('name', isset($xppen_product) ? $xppen_product->name : null) }}">
                <span class="text-danger name_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Category <span class="text-danger">*</span></label>
                <select name="category_id" id="" class="form-select select2 category_id" data-placeholder="---Please Select---">
                    <option value=""></option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{isset($xppen_product) && $xppen_product->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                    @endforeach
                </select>
                <span class="text-danger category_id_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Series</label>
                <select name="series_id"  id="" class="form-select select2 series_id" data-placeholder="---Please Select---">
                    <option value=""></option>
                    @foreach ($series as $ser)
                        <option value="{{$ser->id}}" {{isset($xppen_product) && $xppen_product->series_id == $ser->id ? 'selected' : ''}}>{{$ser->name}}</option>
                    @endforeach
                </select>
                <span class="text-danger series_id_err"></span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group mb-4">
                <label for="">Product Images <span class="text-danger">*</span></label>
                <div class="needslick dropzone" id="product-image-dropzone">

                </div>
                <span class="text-danger images_err"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Quantity <span class="text-danger">*</span></label>
                <input type="number" min="0" name="qty" class="form-control qty" value="{{ old('qty', isset($xppen_product) ? $xppen_product->qty : 0) }}">
                <span class="text-danger qty_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Price MMK </label>
                <input type="number" min="0" name="price_mmk" class="form-control price_mmk" value="{{ old('price_mmk', isset($xppen_product) ? $xppen_product->price_mmk : 0) }}">
                <span class="text-danger price_mmk_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Price USD</label>
                <input type="number" min="0" name="price_usd" class="form-control price_usd" value="{{ old('price_usd', isset($xppen_product) ? $xppen_product->price_us : 0) }}">
                <span class="text-danger price_usd_err"></span>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12 col-lg-8">
            <div class="form-group mb-4">
                <label for="">Specification <span class="text-danger">*</span></label>
                <textarea name="specification" id="" cols="30" rows="5" class="form-control specification" placeholder="Write specification ...">{{isset($xppen_product) ? $xppen_product->specification : ''}}</textarea>
                <span class="text-danger specification_err"></span>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <div class="form-group mb-4">
                <label for="">Description </label>
                <textarea name="description" class="form-control" id="description" placeholder="Write description ..." cols="30" rows="8">{{isset($xppen_product) ? $xppen_product->description : ''}}</textarea>
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
