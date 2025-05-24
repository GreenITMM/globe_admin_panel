<?php

namespace App\Http\Controllers\Admin\CareerManagement;

use App\Models\Career;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class CareerController extends Controller
{
    public function index() {
        return view('admin.career_management.career.index');
    }

    public function careerLists()
    {
        $data = Career::with('position', 'department')->orderBy('id', 'desc');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()

            ->editColumn('position_id', function($each) {
                return $each->position->name;
            })

            ->filterColumn('position_id', function($query, $keyword) {
                $query->whereHas('position', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })

            ->editColumn('department_id', function($each) {
                return $each->department->name;
            })

            ->filterColumn('department_id', function($query, $keyword) {
                $query->whereHas('department', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })

            ->editColumn('job_responsibility', function($each) {
                return substr(strip_tags($each->job_responsibility), 0,150) . ' ...';
            })

            ->editColumn('job_requirement', function($each) {
                return substr(strip_tags($each->job_requirement), 0,150) . ' ...';
            })

            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                $show_icon = '<a href="' . route('admin.careers.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';

                // if (auth()->user()->can('brand_edit')) {
                    $edit_icon = '<a href="' . route('admin.careers.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                // }

                // if (auth()->user()->can('brand_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-slug="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                // }

                return '<div class="action-icon text-nowrap">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns([ 'action'])
            ->make(true);

    }

    public function create() {
        $positions = Position::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->get();

        return view('admin.career_management.career.create', compact('positions', 'departments'));
    }

    public function show(Career $career) {
        return view('admin.career_management.career.show', compact('career'));
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            $career = new Career();
            $career->position_id = $request->position_id;
            $career->department_id = $request->department_id;
            $career->salary = $request->salary;
            $career->contact_mail = $request->contact_mail;
            $career->call_phone = $request->call_phone;
            $career->viber_phone = $request->viber_phone;
            $career->office_location = $request->office_location;
            $career->working_time = $request->working_time;
            $career->off_days = $request->off_days;
            $career->job_responsibility = $request->job_responsibility;
            $career->job_requirement = $request->job_requirement;
            $career->save();

            DB::commit();
            session()->flash('success', 'Successfully Created');
            return 'success';
        } catch(\Exception $e) {
            DB::rollback();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function edit(Career $career) {
        $positions = Position::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->get();

        return view('admin.career_management.career.edit',compact('career', 'positions', 'departments'));
    }

    public function updateCareer(Request $request, Career $career) {
        DB::beginTransaction();

        try {
            $career->position_id = $request->position_id;
            $career->department_id = $request->department_id;
            $career->salary = $request->salary;
            $career->contact_mail = $request->contact_mail;
            $career->call_phone = $request->call_phone;
            $career->viber_phone = $request->viber_phone;
            $career->office_location = $request->office_location;
            $career->working_time = $request->working_time;
            $career->off_days = $request->off_days;
            $career->job_responsibility = $request->job_responsibility;
            $career->job_requirement = $request->job_requirement;
            $career->update();

            DB::commit();
            session()->flash('success', 'Successfully Updated');
            return 'success';
        } catch(\Exception $e) {
            DB::rollback();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function destroy(Career $career) {
        $career->delete();

        return 'success';
    }


}
