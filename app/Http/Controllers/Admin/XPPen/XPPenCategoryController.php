<?php

namespace App\Http\Controllers\Admin\XPPen;

use App\Models\XpPenCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class XPPenCategoryController extends Controller
{
    public function index() {
        return view('admin.xp_pen.category.index');
    }

    public function categoryLists()
    {
        $data = XpPenCategory::latest();

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()
            ->editColumn('image', function($each) {
                $imagePath = $each->image ? $each->image : 'images/default.jpg';
                return '<img src="' . asset('storage/' . $imagePath ) . '" width="100" height="80" />';
            })
            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                // if (auth()->user()->can('user_show')) {
                //     $show_icon = '<a href="' . route('admin.users.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                // }

                // if (auth()->user()->can('brand_edit')) {
                    $edit_icon = '<a href="' . route('admin.xppen-categories.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                // }

                // if (auth()->user()->can('brand_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                // }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);

    }

    public function create() {
        return view('admin.xp_pen.category.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            $fileName = null;
            if ($request->file('image')) {
                $fileName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/xppen', $fileName);
            }
            $xppen_category = new XpPenCategory();
            $xppen_category->name = $request->name;
            $xppen_category->image = $fileName ? '/images/xppen/' . $fileName : null;
            $xppen_category->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function edit(XpPenCategory $xppen_category) {

        return view('admin.xp_pen.category.edit', compact('xppen_category'));
    }

    public function updateCategory(Request $request, XpPenCategory $xppen_category) {
        DB::beginTransaction();
        logger($request->all());

        try {
            $fileName = null;
            if ($request->file('image')) {
                //delete old file
                \File::delete(public_path('/storage' . $xppen_category->image));

                $fileName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/xppen', $fileName);

            }

            $xppen_category->name = $request->name;
            $xppen_category->image = $fileName ? '/images/xppen/' . $fileName : $xppen_category->image;
            $xppen_category->update();

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function destroy(XpPenCategory $xppen_category){
        {
            DB::beginTransaction();
            try {
                if($xppen_category->image) {
                    \File::delete(public_path('/storage' . $xppen_category->image));
                }
                $xppen_category->delete();
                DB::commit();
                return 'success';
            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage());
                return 'error';
            }
        }
    }
}
