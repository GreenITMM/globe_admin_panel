<?php

namespace App\Http\Controllers\Admin\CareerManagement;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class PositionController extends Controller
{
    public function index() {
        return view('admin.career_management.position.index');
    }

    public function positionLists()
    {
        $data = Position::orderBy('id', 'desc');

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
                    $edit_icon = '<a href="' . route('admin.positions.edit', $each->slug) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
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
        return view('admin.career_management.position.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            $position = new Position();
            $position->name = $request->name;
            $position->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return $e->getMessage();
        }
    }

    public function edit(Position $position) {
        return view('admin.career_management.position.edit', compact('position'));
    }

    public function updatePosition(Request $request, Position $position) {
        DB::beginTransaction();

        try {
            $position->name = $request->name;
            $position->update();

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return $e->getMessage();
        }
    }

    public function destroy(Position $position) {
        DB::beginTransaction();
        try {
            $position->delete();
            DB::commit();
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

}
