<?php

namespace App\Http\Controllers\Admin\XPPen;

use App\Models\XpPenSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class XPPenSeriesController extends Controller
{
    public function index() {
        return view('admin.xp_pen.series.index');
    }

    public function seriesLists()
    {
        $data = XpPenSeries::latest();

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()

            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                // if (auth()->user()->can('user_show')) {
                //     $show_icon = '<a href="' . route('admin.users.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                // }

                // if (auth()->user()->can('brand_edit')) {
                    $edit_icon = '<a href="' . route('admin.xppen-series.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                // }

                // if (auth()->user()->can('brand_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                // }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create() {
        return view('admin.xp_pen.series.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            $xppen_series = new XpPenSeries();
            $xppen_series->name = $request->name;
            $xppen_series->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function edit(XpPenSeries $xppen_series) {
        return view('admin.xp_pen.series.edit', compact('xppen_series'));
    }

    public function updateSeries(Request $request, XpPenSeries $xppen_series) {
        DB::beginTransaction();

        try {
            $xppen_series->name = $request->name;
            $xppen_series->update();

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';
        } catch(\Exception $err) {
            DB::rollback();
            logger($err->getMessage());
            return $err->getMessage();
        }
    }

    public function destroy(XpPenSeries $xppen_series) {
        DB::beginTransaction();
        try {
            $xppen_series->delete();
            DB::commit();
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }
}
