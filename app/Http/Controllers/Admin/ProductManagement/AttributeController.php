<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class AttributeController extends Controller
{
    public function index() {
        return view('admin.product_management.attribute.index');
    }

    public function attributeLists()
    {
        $data = Attribute::with(['values'])->latest();

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()


            ->editColumn('values', function($each) {
                $elements = [];
                foreach($each->values as $value) {
                    $elements[] = "<span class='badge bg-info me-2 rounded-pill'>{$value->name}</span>";
                }

                return implode('', $elements);
            })


            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                // if (auth()->user()->can('user_show')) {
                // }

                // if (auth()->user()->can('brand_edit')) {
                    $edit_icon = '<a href="' . route('admin.attributes.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                // }

                // if (auth()->user()->can('brand_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                // }

                return '<div class="action-icon text-nowrap">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['values', 'action'])
            ->make(true);

    }

    public function create() {
        return view('admin.product_management.attribute.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {

            $attribute = new Attribute();
            $attribute->name = $request->name;
            $attribute->save();

            foreach($request->value as $attr_value) {
                AttributeValue::firstOrCreate([
                    'name' => strtolower($attr_value),
                    'attribute_id' => $attribute->id
                ]);
            }

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function edit(Attribute $attribute) {
        return view('admin.product_management.attribute.edit', compact('attribute'));
    }

    public function updateAttribute(Request $request, Attribute $attribute) {
        DB::beginTransaction();

        try {

            $attribute->name = $request->name;
            $attribute->save();

            if(!empty($request->value)) {
                AttributeValue::where('attribute_id', $attribute->id)->delete();

                foreach($request->value as $value) {
                    AttributeValue::firstOrCreate([
                        'name' => strtolower($value),
                        'attribute_id' => $attribute->id
                    ]);
                }
            }

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function destroy(Attribute $attribute) {
        DB::beginTransaction();
        try {
            $attribute->values()->delete();
            $attribute->delete();
            DB::commit();
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }
}
