<?php

namespace App\Http\Controllers\Admin\Adreamer;

use App\Models\AdreamerCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class AdreamerCategoryController extends Controller
{
    public function index() {
        return view('admin.adreamer.category.index');
    }

    public function categoryLists()
    {
        $data = AdreamerCategory::latest();

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
                    $edit_icon = '<a href="' . route('admin.adreamer-categories.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
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
        return view('admin.adreamer.category.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            $fileName = null;
            if ($request->file('image')) {
                $fileName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/adreamer', $fileName);
            }
            $adreamer_category = new AdreamerCategory();
            $adreamer_category->name = $request->name;
            $adreamer_category->image = $fileName ? '/images/adreamer/' . $fileName : null;
            $adreamer_category->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function edit(AdreamerCategory $adreamerCategory) {
        return view('admin.adreamer.category.edit', compact('adreamerCategory'));
    }

    public function updateCategory(Request $request, AdreamerCategory $adreamerCategory) {
        DB::beginTransaction();

        try {
            $fileName = null;
            if ($request->file('image')) {
                //delete old file
                \File::delete(public_path('/storage' . $adreamerCategory->image));

                $fileName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/adreamer', $fileName);

            }

            $adreamerCategory->name = $request->name;
            $adreamerCategory->image = $fileName ? '/images/adreamer/' . $fileName : $adreamerCategory->image;
            $adreamerCategory->update();

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function destroy(AdreamerCategory $adreamerCategory){
        {
            DB::beginTransaction();
            try {
                if($adreamerCategory->image) {
                    \File::delete(public_path('/storage' . $adreamerCategory->image));
                }
                $adreamerCategory->delete();
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
