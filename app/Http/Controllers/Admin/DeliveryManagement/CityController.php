<?php

namespace App\Http\Controllers\Admin\DeliveryManagement;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class CityController extends Controller
{
    public function index() {
        return view('admin.delivery_management.city.index');
    }

    public function cityLists()
    {
        $data = City::with('state')->orderBy('id', 'desc');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()

            ->editColumn('state_id', function ($each) {
                return $each->state->name;
            })

            ->filterColumn('state_id', function ($query, $keyword) {
                $query->whereHas('state', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            })

            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';


                // if (auth()->user()->can('brand_edit')) {
                    $edit_icon = '<a href="' . route('admin.cities.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
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
        $states = State::orderBy('id', 'asc')->get();

        return view('admin.delivery_management.city.create', compact('states'));
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            $city = new City();
            $city->name = $request->name;
            $city->state_id = $request->state_id;
            $city->delivery_charges = $request->delivery_charges;
            $city->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return $e->getMessage();
        }
    }

    public function edit(City $city) {
        $states = State::orderBy('id', 'asc')->get();

        return view('admin.delivery_management.city.edit', compact('city', 'states'));
    }

    public function updateCity(Request $request, City $city) {
        DB::beginTransaction();

        try {
            $city->name = $request->name;
            $city->state_id = $request->state_id;
            $city->delivery_charges = $request->delivery_charges;
            $city->update();

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return $e->getMessage();
        }
    }

    public function destroy(City $city) {
        DB::beginTransaction();
        try {
            $city->delete();
            DB::commit();
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }
}
