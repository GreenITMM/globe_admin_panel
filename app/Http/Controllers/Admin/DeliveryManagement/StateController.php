<?php

namespace App\Http\Controllers\Admin\DeliveryManagement;

use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class StateController extends Controller
{
    public function index() {
        return view('admin.delivery_management.state.index');
    }

    public function stateLists()
    {
        $data = State::orderBy('id', 'desc');

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
                    $edit_icon = '<a href="' . route('admin.states.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                // }

                // if (auth()->user()->can('brand_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                // }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns([ 'action'])
            ->make(true);

    }

    public function create() {
        return view('admin.delivery_management.state.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            $state = new State();
            $state->name = $request->name;
            $state->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function edit(State $state) {

        return view('admin.delivery_management.state.edit', compact('state'));
    }

    public function updateState(Request $request, State $state) {

        $state->name = $request->name;
        $state->update();

        session()->flash('success', 'Successfully Updated !');
        return 'success';
    }

    public function destroy(State $state) {
        $state->delete();
        return 'success';
    }
}
