<?php

namespace App\Http\Controllers\Admin\ContentManagement;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class PromotionController extends Controller
{
    public function index() {
        return view('admin.content_management.promotion.index');
    }

    public function promotionLists()
    {
        $data = Promotion::orderBy('created_at', 'desc');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()
            ->editColumn('image', function($each) {
                return '<img src="' . asset('storage/' . $each->image ) . '" width="200" />';
            })
            ->editColumn('is_public', function($each) {
                $isActive = $each->is_active == 1 ? 'text-success' : '';
                $icon = '<span data-id="' . $each->id . '" class="cursor-pointer toggle-btn"><i class="bx bxs-toggle-right fs-1 '.$isActive.'"></i></span>';

                return $icon;
            })
            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                // if (auth()->user()->can('user_show')) {
                //     $show_icon = '<a href="' . route('admin.users.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                // }

                // if (auth()->user()->can('brand_edit')) {
                    $edit_icon = '<a href="' . route('admin.promotions.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                // }

                // if (auth()->user()->can('brand_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                // }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['image', 'is_public', 'action'])
            ->make(true);

    }

    public function create() {
        return view('admin.content_management.promotion.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            if ($request->file('image')) {
                $fileName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/promotions', $fileName);
            }

            $promotion = new Promotion();
            $promotion->image = $fileName ? '/images/promotions/' . $fileName : null;
            $promotion->description = $request->description;
            $promotion->start_date = $request->start_date;
            $promotion->end_date = $request->end_date;
            $promotion->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            return 'error';
        }
    }

    public function edit(Promotion $promotion) {
        return view('admin.content_management.promotion.edit', compact('promotion'));
    }

    public function updatePromotion(Request $request, Promotion $promotion) {
        DB::beginTransaction();

        try {
            $fileName = null;
            if ($request->file('image')) {
                //delete old file
                \File::delete(public_path('/storage' . $promotion->image));

                $fileName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/promotions', $fileName);
            }

            $promotion->image = $fileName ? '/images/promotions/' . $fileName : $promotion->image;
            $promotion->description = $request->description;
            $promotion->start_date = $request->start_date;
            $promotion->end_date = $request->end_date;
            $promotion->update();

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function togglePromotion(Promotion $promotion) {
        $promotion->is_active = $promotion->is_active == 1 ? 0 : 1;
        $promotion->save();
        return 'success';
    }

    public function destroy(Promotion $promotion) {
        DB::beginTransaction();
        try {
            \File::delete(public_path('/storage' . $promotion->image));
            $promotion->delete();
            DB::commit();
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }
}
