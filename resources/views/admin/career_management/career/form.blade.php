<form id="{{request()->is('admin/career-management/careers/create') ? 'career_create_form' : 'career_edit_form'}}">
    @csrf
    <div class="row">
        <input type="hidden" name="career_id" id="career_id" value="{{isset($career) ? $career->id : null}}">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Position <span class="text-danger">*</span></label>
                <select name="position_id" id="" class="form-select select2 position_id" data-placeholder="---Please Select---">
                    <option value=""></option>
                    @foreach ($positions as $position)
                        <option value="{{$position->id}}" {{isset($career) && $career->position_id == $position->id ? 'selected' : ''}}>{{$position->name}}</option>
                    @endforeach
                </select>
                <span class="text-danger position_id_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Department <span class="text-danger">*</span></label>
                <select name="department_id" id="" class="form-select select2 department_id" data-placeholder="---Please Select---">
                    <option value=""></option>
                    @foreach ($departments as $department)
                        <option value="{{$department->id}}" {{isset($career) && $career->department_id == $department->id ? 'selected' : ''}}>{{$department->name}}</option>
                    @endforeach
                </select>
                <span class="text-danger department_id_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Salary (default is negotiable)</label>
                <input type="number" min="0" name="salary" id="salary" value="{{isset($career) ? $career->salary : 0}}" class="form-control">
                <span class="text-danger salary_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Contact Mail</label>
                <input type="text" name="contact_mail" id="contact_mail" value="{{isset($career) ? $career->contact_mail : 'hr@greenitmm.com'}}" class="form-control">
                <span class="text-danger contact_mail_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Contact Phone</label>
                <input type="text" name="call_phone" id="call_phone" value="{{isset($career) ? $career->call_phone : '09880441215'}}" class="form-control">
                <span class="text-danger call_phone_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Viber Phone</label>
                <input type="text" name="viber_phone" id="viber_phone" value="{{isset($career) ? $career->viber_phone : '09769733646'}}" class="form-control">
                <span class="text-danger viber_phone_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Office Location</label>
                <textarea class="form-control office_location" name="office_location" id="" cols="30" rows="2">{{isset($career) ? $career->office_location : 'Kyeemyindaing Township'}}</textarea>
                <span class="text-danger office_location_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Working Time</label>
                <textarea class="form-control working_time" name="working_time" id="" cols="30" rows="2">{{isset($career) ? $career->working_time : '9:00 AM to 5:00 PM (Mon to Friday) '}}</textarea>
                <span class="text-danger working_time_err"></span>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Off Days</label>
                <textarea class="form-control off_days" name="off_days" id="" cols="30" rows="2">{{isset($career) ? $career->off_days : 'Saturday Half, Sunday & Public Holidays'}}</textarea>
                <span class="text-danger off_days_err"></span>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-8 col-md-6 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Job Responsibility <span class="text-danger">*</span></label>
                <textarea name="job_responsibility" id="job_responsibility" cols="30" rows="5" class="form-control cke-editor job_responsibility">{{isset($career) ? $career->job_responsibility : ''}}</textarea>
                <span class="text-danger job_responsibility_err"></span>
            </div>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Job Requirement <span class="text-danger">*</span></label>
                <textarea name="job_requirement" id="job_requirement" cols="30" rows="5" class="form-control cke-editor job_requirement">{{isset($career) ? $career->job_requirement : ''}}</textarea>
                <span class="text-danger job_requirement_err"></span>
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
