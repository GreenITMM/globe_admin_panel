<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use DataTables;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index() {
        return view('admin.product_management.category.index');
    }

    public function categoryLists()
    {
        $data = Category::latest();

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
                    $edit_icon = '<a href="' . route('admin.categories.edit', $each->slug) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                // }

                // if (auth()->user()->can('brand_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-slug="' . $each->slug . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                // }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);

    }

    public function create() {
        return view('admin.product_management.category.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            $fileName = null;
            if ($request->file('image')) {
                $fileName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/category', $fileName);
            }
            $category = new Category();
            $category->name = $request->name;
            $category->image = $fileName ? '/images/category/' . $fileName : null;
            $category->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function edit(Category $category) {
        return view('admin.product_management.category.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        DB::beginTransaction();
        logger($request->all());

        try {
            $fileName = null;
            if ($request->file('image')) {
                //delete old file
                File::delete(public_path('/storage' . $category->image));

                $fileName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/category', $fileName);

            }

            $category->name = $request->name;
            $category->image = $fileName ? '/images/category/' . $fileName : $category->image;
            $category->update();

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function destroy(Category $category){
        {
            DB::beginTransaction();
            try {
                if($category->image) {
                    File::delete(public_path('/storage' . $category->image));
                }
                $category->delete();
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
