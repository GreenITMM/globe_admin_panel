<?php

namespace App\Http\Controllers\Admin\ContentManagement;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class PartnerController extends Controller
{
    public function index()
    {
        return view('admin.content_management.partners.index');
    }

    public function partnerLists()
    {
        $data = Partner::orderBy('created_at', 'desc');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()
            ->editColumn('logo', function($each) {
                return '<img src="' . asset('storage/' . $each->logo ) . '" width="60" />';
            })

            ->editColumn('website_url', function($each) {
                return $each->website_url ?? '-';
            })

            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                // if (auth()->user()->can('user_show')) {
                //     $show_icon = '<a href="' . route('admin.users.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                // }

                // if (auth()->user()->can('brand_edit')) {
                    $edit_icon = '<a href="' . route('admin.partners.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                // }

                // if (auth()->user()->can('brand_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                // }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['logo',  'action'])
            ->make(true);

    }

    public function create() {
        return view('admin.content_management.partners.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            if ($request->file('logo')) {
                $fileName = uniqid() . $request->file('logo')->getClientOriginalName();
                $request->file('logo')->storeAs('public/images/partners', $fileName);
            }

            $partner = new Partner();
            $partner->name = $request->name;
            $partner->logo = $fileName ? '/images/partners/' . $fileName : null;
            $partner->website_url = $request->website_url;
            $partner->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function edit(Partner $partner) {
        return view('admin.content_management.partners.edit', compact('partner'));
    }

    public function updatePartner(Request $request, Partner $partner) {
        DB::beginTransaction();

        try {
            $fileName = null;
            if ($request->file('logo')) {
                //delete old file
                \File::delete(public_path('/storage' . $partner->logo));

                $fileName = uniqid() . $request->file('logo')->getClientOriginalName();
                $request->file('logo')->storeAs('public/images/partners', $fileName);
            }

            $partner->name = $request->name;
            $partner->logo = $fileName ? '/images/partners/' . $fileName : $partner->logo;
            $partner->website_url = $request->website_url;
            $partner->update();

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function destroy(Partner $partner) {
        DB::beginTransaction();
        try {
            \File::delete(public_path('/storage' . $partner->logo));
            $partner->delete();
            DB::commit();
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }
}
