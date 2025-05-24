<form id="{{request()->is('admin/product-management/products/create') ? 'product_create_form' : 'product_edit_form'}}">
    @csrf
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <input type="hidden" name="product_slug" id="product_slug" value="{{isset($product) ? $product->slug : null}}">
            <div class="form-group mb-4">
                <label for="">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control name" value="{{ old('name', isset($product) ? $product->name : null) }}">
                <span class="text-danger name_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Category <span class="text-danger">*</span></label>
                <select name="category_id" id="" class="form-select select2 category_id" data-placeholder="---Please Select---">
                    <option value=""></option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{isset($product) && $product->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                    @endforeach
                </select>
                <span class="text-danger category_id_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Brand <span class="text-danger">*</span></label>
                <select name="brand_id" id="" class="form-select select2 brand_id" data-placeholder="---Please Select---">
                    <option value=""></option>
                    @foreach ($brands as $brand)
                        <option value="{{$brand->id}}" {{isset($product) && $product->brand_id == $brand->id ? 'selected' : ''}}>{{$brand->name}}</option>
                    @endforeach
                </select>
                <span class="text-danger brand_id_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Series</label>
                <select name="series_id" {{isset($product) && $product->series_id ? '' : 'disabled'}} id="" class="form-select select2 series_id" data-placeholder="---Please Select---">
                    @if (isset($product) && $product->series_id)
                        <option value=""></option>
                        @foreach ($series as $ser)
                            <option value="{{$ser->id}}" {{isset($product) && $product->series_id == $ser->id ? 'selected' : ''}}>{{$ser->name}}</option>
                        @endforeach

                    @endif
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
    <div class="border rounded p-3">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="form-group mb-4">
                    <label for="">Product Type <span class="text-danger">*</span></label>
                    <select name="product_type_id" id=""  class="form-select select2 product_type_id" data-placeholder="---Please Select---">
                        <option value=""></option>
                        @foreach ($productTypes as $type)
                            <option value="{{$type->id}}" {{isset($product) ? ($product->product_type_id == $type->id ? 'selected' : '') : ($type->id == 1 ? 'selected' : '')}}>{{$type->name}}</option>
                        @endforeach
                    </select>
                    <span class="text-danger product_type_id_err"></span>
                </div>
            </div>
        </div>
        <div class="row simple-product-group {{isset($product) ? ($product->product_type_id == 1 ? '' : 'd-none') : ''}}">
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="form-group mb-4">
                    <label for="">Quantity <span class="text-danger">*</span></label>
                    <input type="number" min="0" name="qty" class="form-control qty" value="{{ old('qty', isset($product) ? $product->qty : null) }}">
                    <span class="text-danger qty_err"></span>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="form-group mb-4">
                    <label for="">Price MMK<span class="text-danger">*</span></label>
                    <input type="number" min="0" name="price_mmk" class="form-control price_mmk" value="{{ old('price_mmk', isset($product) ? $product->price_mmk : 0) }}">
                    <span class="text-danger price_mmk_err"></span>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="form-group mb-4">
                    <label for="">Price US <span class="text-danger">*</span></label>
                    <input type="number" min="0" name="price_us" class="form-control price_us" value="{{ old('price_us', isset($product) ? $product->price_us : 0) }}">
                    <span class="text-danger price_us_err"></span>
                </div>
            </div>
        </div>

        <div class="d-flex attribute-product-group align-items-start mt-4 {{isset($product) ? ($product->product_type_id == 2 ? '' : 'd-none') : 'd-none'}}">
            <div class="nav flex-column nav-pills pe-4" style="border-right: 1px solid #755d5d;" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-attribute-tab" data-bs-toggle="pill" data-bs-target="#v-pills-attribute" type="button" role="tab" aria-controls="v-pills-attribute" aria-selected="true">Attribute</button>
                <button class="nav-link" id="v-pills-variation-tab" data-bs-toggle="pill" data-bs-target="#v-pills-variation" type="button" role="tab" aria-controls="v-pills-variation" aria-selected="false">Variation</button>
            </div>
            <div class="tab-content p-0 m-0 ps-4 w-100" id="v-pills-tabContent">
                <div class="tab-pane fade show active " id="v-pills-attribute" role="tabpanel" aria-labelledby="v-pills-attribute-tab" tabindex="0">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <select name="attributes[]" id="attributes" class="select2 form-control attributes " style="width: 400px;" multiple="multiple" data-placeholder="---Please Select---">
                                @foreach ($attributes as $attribute)
                                    <option value="{{ $attribute->id }}" {{isset($product) && $product->attributes->contains($attribute->id) ? 'selected' : ''}}>{{ $attribute->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- variation  --}}
                <div class="tab-pane fade" id="v-pills-variation" role="tabpanel" aria-labelledby="v-pills-variation-tab" tabindex="0">
                    <button class="btn btn-outline-primary d-flex align-items-center gap-3 add-variation" type="button">Add Variation <i class='bx bx-plus'></i></button>
                    <input type="hidden" id="variation_count" value="{{isset($product) && $product->variations->count() > 0 ? $product->variations->count() : 0}}">
                    <div class="variation-group">
                        @if(isset($product) && $product->variations->count() > 0)
                            @foreach ($product->variations as $vIndex => $variation)
                                @php
                                    $stored_attributes = json_decode($variation->attributes, true);
                                @endphp
                                <div class='border rounded mx-1 mt-3'>
                                    <div class='d-flex justify-content-end px-3 pt-1'>
                                        <i class='bx bx-trash cursor-pointer remove-variation text-danger'></i>
                                    </div>

                                    <div class='row px-3'>
                                        @foreach ($stored_attributes as $attrName => $attrValue)
                                            @php
                                                $attribute = $attributes->firstWhere('name', $attrName);
                                            @endphp

                                            @if($attribute)
                                                <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
                                                    <div class="form-group mb-4">
                                                        <label for="">{{ $attrName }} <span class="text-danger">*</span></label>
                                                        <select name="variation[{{ $vIndex }}][attributes][{{ $attrName }}]" class="form-select select2" data-placeholder="---Please Select---">
                                                            <option value=""></option>
                                                            @foreach($attribute->values as $val)
                                                                <option value="{{ $val->name }}" {{ $val->name == $attrValue ? 'selected' : '' }}>
                                                                    {{ $val->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class="row px-3">
                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                            <div class="form-group mb-4">
                                                <label for="">Price MMK <span class="text-danger">*</span></label>
                                                <input type="number" name="variation[{{ $vIndex }}][price_mmk]" class="form-control" value="{{ $variation->price_mmk }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                            <div class="form-group mb-4">
                                                <label for="">Price US <span class="text-danger">*</span></label>
                                                <input type="number" name="variation[{{ $vIndex }}][price_us]" class="form-control" value="{{ $variation->price_us }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                            <div class="form-group mb-4">
                                                <label for="">Quantity <span class="text-danger">*</span></label>
                                                <input type="number" name="variation[{{ $vIndex }}][qty]" class="form-control" value="{{ $variation->qty }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="form-group mb-4">
                <label for="">Specification <span class="text-danger">*</span></label>
                <textarea name="specification" id="" cols="30" rows="5" class="form-control specification" placeholder="Write specification ...">{{isset($product) ? $product->specification : ''}}</textarea>
                <span class="text-danger specification_err"></span>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group mb-4">
                <label for="">Description </label>
                <textarea name="description" class="form-control" id="description" placeholder="Write description ..." cols="30" rows="8">{{isset($product) ? $product->description : ''}}</textarea>
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
