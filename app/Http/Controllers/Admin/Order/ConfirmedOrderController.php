<?php

namespace App\Http\Controllers\Admin\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class ConfirmedOrderController extends Controller
{
    public function index()
    {
        return view('admin.order.confirmed_order.index');
    }

    public function confirmedOrderLists()
    {
        $data = Order::with('items', 'shipping_city')->where('status', 'confirmed')->orderBy('id', 'desc');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()

            ->editColumn('city_id', function($each) {
                return $each->shipping_city->name;
            })

            ->filterColumn('city_id', function($query, $keyword) {
                $query->whereHas('shipping_city', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })

            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';
                $show_icon = '<a href="' . route('admin.confirmed-orders.show', $each->id) . '" class="text-info me-3"><i class="bx bxs-show fs-3"></i></a>';
                return '<div class="action-icon text-nowrap">' . $show_icon  . '</div>';
            })
            ->rawColumns([ 'action'])
            ->make(true);
    }

    public function show($id) {
        $order = Order::with('user', 'items', 'shipping_city')->find($id);
        return view('admin.order.confirmed_order.show', compact('order'));
    }
}
