<?php

namespace App\Http\Controllers\Admin\Solar;

use Illuminate\Http\Request;
use App\Models\SolarCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class SolarCategoryController extends Controller
{
    public function index() {
        return view('admin.solar.category.index');
    }

    public function categoryLists()
    {
        $data = SolarCategory::with('parent')->latest();

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()
            ->editColumn('parent_category', function($each) {
                return $each->parent ? $each->parent->name : '-';
            })
            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                // if (auth()->user()->can('user_show')) {
                //     $show_icon = '<a href="' . route('admin.users.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                // }

                // if (auth()->user()->can('brand_edit')) {
                    $edit_icon = '<a href="' . route('admin.solar-categories.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
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
        $parent_categories = SolarCategory::where('parent_id', null)->get();

        return view('admin.solar.category.create', compact('parent_categories'));
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {

            $solar_category = new SolarCategory();
            $solar_category->name = $request->name;
            $solar_category->parent_id = $request->parent_id;
            $solar_category->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function edit(SolarCategory $solarCategory) {
        $parent_categories = SolarCategory::where('parent_id', null)->get();

        return view('admin.solar.category.edit', compact('solarCategory', 'parent_categories'));
    }

    public function updateCategory(Request $request, SolarCategory $solarCategory) {
        DB::beginTransaction();

        try {

            $solarCategory->name = $request->name;
            $solarCategory->parent_id = $request->parent_id;
            $solarCategory->update();

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function destroy(SolarCategory $solarCategory){
        {
            DB::beginTransaction();
            try {
                $solarCategory->delete();
                DB::commit();
                return 'success';
            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage());
                return 'error';
            }
        }
    }

    public function getChildCategory(SolarCategory $solarCategory) {
        $children = SolarCategory::select('id','name', 'slug')->where('parent_id', $solarCategory->id)->get();
        return response()->json($children);
    }
}
