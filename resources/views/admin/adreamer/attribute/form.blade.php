<form id="{{request()->is('admin/adreamer/adreamer-attributes/create') ? 'adreamer_attribute_create_form' : 'adreamer_attribute_edit_form'}}">
    @csrf
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <input type="hidden" name="adreamer_attribute_id" id="adreamer_attribute_id" value="{{isset($adreamerAttribute) ? $adreamerAttribute->id : null}}">
            <div class="form-group mb-4">
                <label for="">AttributeName <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control name" placeholder="eg. Color, Size" value="{{ old('name', isset($adreamerAttribute) ? $adreamerAttribute->name : null) }}">
                <span class="text-danger name_err"></span>
            </div>
        </div>
        <div class="col-lg-3 col-md-5 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Attribute Values <span class="text-danger">*</span></label>
                <div class="attr-value-container" style="max-height: 500px; overflow-y: scroll;">
                    @if(isset($adreamerAttribute))
                        @foreach($adreamerAttribute->values as $value)
                            <div class="d-flex gap-2 mb-2 attr-value">
                                <input type="text" name="value[]" class="form-control value" placeholder="eg. White, Black" value="{{$value->name}}">
                                @if ($loop->first)
                                    <button class="btn btn-primary add-attr-value" type="button"><i class='bx bx-plus'></i></button>
                                @else
                                    <button class="btn btn-danger remove-attr-balue" type="button"><i class='bx bx-trash ' ></i></button>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="d-flex gap-2 mb-2">
                            <input type="text" name="value[]" class="form-control value" placeholder="eg. White, Black" >
                            <button class="btn btn-primary add-attr-value" type="button"><i class='bx bx-plus'></i></button>
                        </div>
                    @endif
                </div>
                <span class="text-danger attr_value_err"></span>
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
