<?php

namespace App\Http\Controllers\Admin\ContentManagement;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class SliderController extends Controller
{
    public function index() {
        return view('admin.content_management.slider.index');
    }

    public function sliderLists()
    {
        $data = Slider::orderBy('image_order_no', 'asc');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()
            ->editColumn('image', function($each) {
                return '<img src="' . asset('storage/' . $each->image ) . '" width="200" />';
            })
            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                // if (auth()->user()->can('user_show')) {
                //     $show_icon = '<a href="' . route('admin.users.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                // }

                // if (auth()->user()->can('brand_edit')) {
                    $edit_icon = '<a href="' . route('admin.slider.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
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
        return view('admin.content_management.slider.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            if ($request->file('image')) {
                $fileName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/sliders', $fileName);
            }

            $slider = new Slider();
            $slider->image = $fileName ? '/images/sliders/' . $fileName : null;
            $slider->image_order_no = $request->image_order_no;
            $slider->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            return 'error';
        }
    }

    public function edit(Slider $slider) {
        return view('admin.content_management.slider.edit', compact('slider'));
    }

    public function updateSlider (Request $request, Slider $slider) {
        DB::beginTransaction();

        try {
            $fileName = null;
            if ($request->file('image')) {
                //delete old file
                \File::delete(public_path('/storage' . $slider->image));

                $fileName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/sliders', $fileName);

            }

            $slider->image = $fileName ? '/images/sliders/' . $fileName : $slider->image;
            $slider->image_order_no = $request->image_order_no;
            $slider->update();

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function destroy(Slider $slider) {
        DB::beginTransaction();
        try {
            \File::delete(public_path('/storage' . $slider->image));
            $slider->delete();
            DB::commit();
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }
}
