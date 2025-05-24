<?php

namespace App\Http\Controllers\Admin\Adreamer;

use App\Models\AdreamerAttribute;
use App\Models\AdreamerAttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class AdreamerAttributeController extends Controller
{
    public function index() {
        return view('admin.adreamer.attribute.index');
    }

    public function attributeLists()
    {
        $data = AdreamerAttribute::with(['values'])->latest();

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
                    $edit_icon = '<a href="' . route('admin.adreamer-attributes.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
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
        return view('admin.adreamer.attribute.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {

            $attribute = new AdreamerAttribute();
            $attribute->name = $request->name;
            $attribute->save();

            foreach($request->value as $attr_value) {
                AdreamerAttributeValue::firstOrCreate([
                    'name' => strtolower($attr_value),
                    'adreamer_attribute_id' => $attribute->id
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

    public function edit(AdreamerAttribute $adreamerAttribute) {
        return view('admin.adreamer.attribute.edit', compact('adreamerAttribute'));
    }

    public function updateAttribute(Request $request, AdreamerAttribute $adreamerAttribute) {
        DB::beginTransaction();

        try {

            $adreamerAttribute->name = $request->name;
            $adreamerAttribute->save();

            if(!empty($request->value)) {
                AdreamerAttributeValue::where('adreamer_attribute_id', $adreamerAttribute->id)->delete();

                foreach($request->value as $value) {
                    AdreamerAttributeValue::firstOrCreate([
                        'name' => strtolower($value),
                        'adreamer_attribute_id' => $adreamerAttribute->id
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

    public function destroy(AdreamerAttribute $adreamerAttribute) {
        DB::beginTransaction();
        try {
            $adreamerAttribute->values()->delete();
            $adreamerAttribute->delete();
            DB::commit();
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }
}
