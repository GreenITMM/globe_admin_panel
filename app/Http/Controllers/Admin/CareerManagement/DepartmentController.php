<?php

namespace App\Http\Controllers\Admin\CareerManagement;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class DepartmentController extends Controller
{
    public function index() {
        return view('admin.career_management.department.index');
    }

    public function departmentLists()
    {
        $data = Department::orderBy('id', 'desc');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()

            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';


                // if (auth()->user()->can('brand_edit')) {
                    $edit_icon = '<a href="' . route('admin.departments.edit', $each->slug) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                // }

                // if (auth()->user()->can('brand_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-slug="' . $each->slug . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                // }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns([ 'action'])
            ->make(true);

    }

    public function create() {
        return view('admin.career_management.department.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            $department = new Department();
            $department->name = $request->name;
            $department->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function edit(Department $department) {

        return view('admin.career_management.department.edit', compact('department'));
    }

    public function updateDepartment(Request $request, Department $department) {

        $department->name = $request->name;
        $department->update();

        session()->flash('success', 'Successfully Updated !');
        return 'success';
    }

    public function destroy(Department $department) {
        $department->delete();
        return 'success';
    }
}
