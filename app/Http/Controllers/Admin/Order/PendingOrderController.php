<?php

namespace App\Http\Controllers\Admin\Order;

use DataTables;
use App\Models\Order;
use App\Models\Product;
use App\Models\SolarProduct;
use App\Models\XpPenProduct;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SolarProductVariation;

class PendingOrderController extends Controller
{
    public function index()
    {
        return view('admin.order.pending_order.index');
    }

    public function pendingOrderLists()
    {
        $data = Order::with('items', 'shipping_city')->where('status', 'pending')->orderBy('id', 'desc');

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
                $show_icon = '<a href="' . route('admin.pending-orders.show', $each->id) . '" class="text-info me-3"><i class="bx bxs-show fs-3"></i></a>';
                return '<div class="action-icon text-nowrap">' . $show_icon  . '</div>';
            })
            ->rawColumns([ 'action'])
            ->make(true);
    }

    public function show($id) {
        $order = Order::with('user', 'items', 'shipping_city')->find($id);
        return view('admin.order.pending_order.show', compact('order'));
    }

    public function confirmOrder($order_id) {
        logger($order_id);
        $order = Order::find($order_id);
        $order->status = 'confirmed';
        $order->save();

        session()->flash('success', 'Order confirmed successfully');
        return 'success';
    }

    public function cancelOrder($order_id)
    {
        logger($order_id);

        $order = Order::with('items')->find($order_id);

        if ($order) {
            logger($order);

            DB::transaction(function () use ($order) {
                foreach ($order->items as $item) {
                    $cartItem = $item->toArray(); // Convert to array if needed

                    if ($cartItem['product_type'] == 'normal') {
                        if (isset($cartItem['is_attribute']) && $cartItem['is_attribute']) {
                            $productVariation = ProductVariation::find($cartItem['variations']['id'] ?? null);
                            if ($productVariation) {
                                $productVariation->qty += $cartItem['qty'];
                                $productVariation->save();
                            }
                        } else {
                            $product = Product::find($cartItem['product_id']);
                            if ($product) {
                                $product->qty += $cartItem['qty'];
                                $product->save();
                            }
                        }
                    }

                    if ($cartItem['product_type'] == 'solar') {
                        if (isset($cartItem['is_attribute']) && $cartItem['is_attribute']) {
                            $productVariation = SolarProductVariation::find($cartItem['variations']['id'] ?? null);
                            if ($productVariation) {
                                $productVariation->qty += $cartItem['qty'];
                                $productVariation->save();
                            }
                        } else {
                            $product = SolarProduct::find($cartItem['product_id']);
                            if ($product) {
                                $product->qty += $cartItem['qty'];
                                $product->save();
                            }
                        }
                    }

                    if ($cartItem['product_type'] == 'adreamer') {
                        if (isset($cartItem['is_attribute']) && $cartItem['is_attribute']) {
                            $productVariation = ProductVariation::find($cartItem['variations']['id'] ?? null);
                            if ($productVariation) {
                                $productVariation->qty += $cartItem['qty'];
                                $productVariation->save();
                            }
                        } else {
                            $product = Product::find($cartItem['product_id']);
                            if ($product) {
                                $product->qty += $cartItem['qty'];
                                $product->save();
                            }
                        }
                    }

                    if ($cartItem['product_type'] == 'xp_pen') {
                        $product = XpPenProduct::find($cartItem['product_id']);
                        if ($product) {
                            $product->qty += $cartItem['qty'];
                            $product->save();
                        }
                    }
                }

                // Now cancel the order
                $order->status = 'cancelled';
                $order->save();
            });

            session()->flash('success', 'Order cancelled and stock restored successfully.');
            return 'success';
        }

        session()->flash('error', 'Order not found.');
        return 'error';
    }

}
