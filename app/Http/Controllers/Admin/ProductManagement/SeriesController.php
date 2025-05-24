<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Models\Brand;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class SeriesController extends Controller
{
    public function index() {
        return view('admin.product_management.series.index');
    }

    public function seriesLists()
    {
        $data = Series::with('brand')->latest();

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()

            ->editColumn('brand_id', function ($each) {
                return $each->brand->name;
            })

            ->filterColumn('brand_id', function($query, $keyword) {
                $query->whereHas('brand', function($q) use ($keyword) {
                    $q->where('name', 'like', "%$keyword%");
                });
            })

            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                // if (auth()->user()->can('user_show')) {
                //     $show_icon = '<a href="' . route('admin.users.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                // }

                // if (auth()->user()->can('brand_edit')) {
                    $edit_icon = '<a href="' . route('admin.series.edit', $each->slug) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                // }

                // if (auth()->user()->can('brand_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-slug="' . $each->slug . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                // }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create() {
        $brands = Brand::select('id', 'name')->get();

        return view('admin.product_management.series.create', compact('brands'));
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            $series = new Series();
            $series->name = $request->name;
            $series->brand_id = $request->brand_id;
            $series->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';
        } catch(\Exception $err) {
            DB::rollback();
            logger($err->getMessage());
            return $err->getMessage();
        }
    }

    public function edit(Series $series) {
        $series = $series->load('brand');
        $brands = Brand::select('id', 'name')->get();

        return view('admin.product_management.series.edit', compact('series', 'brands'));
    }

    public function updateSeries(Request $request, Series $series) {
        DB::beginTransaction();

        try {
            $series->name = $request->name;
            $series->brand_id = $request->brand_id;
            $series->update();

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';
        } catch(\Exception $err) {
            DB::rollback();
            logger($err->getMessage());
            return $err->getMessage();
        }
    }

    public function destroy(Series $series) {
        $series->delete();

        return 'success';
    }
}
