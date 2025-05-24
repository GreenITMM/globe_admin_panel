<?php

namespace App\Http\Controllers\Admin\Solar;

use App\Models\SolarAttribute;
use App\Models\SolarAttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class SolarAttributeController extends Controller
{
    public function index() {
        return view('admin.solar.attribute.index');
    }

    public function attributeLists()
    {
        $data = SolarAttribute::with(['values'])->latest();

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
                    $edit_icon = '<a href="' . route('admin.solar-attributes.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
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
        return view('admin.solar.attribute.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {

            $attribute = new SolarAttribute();
            $attribute->name = $request->name;
            $attribute->save();

            foreach($request->value as $attr_value) {
                SolarAttributeValue::firstOrCreate([
                    'name' => strtolower($attr_value),
                    'solar_attribute_id' => $attribute->id
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

    public function edit(SolarAttribute $solarAttribute) {
        return view('admin.solar.attribute.edit', compact('solarAttribute'));
    }

    public function updateAttribute(Request $request, SolarAttribute $solarAttribute) {
        DB::beginTransaction();

        try {

            $solarAttribute->name = $request->name;
            $solarAttribute->save();

            if(!empty($request->value)) {
                SolarAttributeValue::where('solar_attribute_id', $solarAttribute->id)->delete();

                foreach($request->value as $value) {
                    SolarAttributeValue::firstOrCreate([
                        'name' => strtolower($value),
                        'solar_attribute_id' => $solarAttribute->id
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

    public function destroy(SolarAttribute $solarAttribute) {
        DB::beginTransaction();
        try {
            $solarAttribute->values()->delete();
            $solarAttribute->delete();
            DB::commit();
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }
}
