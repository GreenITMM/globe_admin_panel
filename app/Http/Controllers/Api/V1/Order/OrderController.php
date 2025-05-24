<?php

namespace App\Http\Controllers\Api\V1\Order;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use App\Models\SolarProduct;
use App\Models\XpPenProduct;
use Illuminate\Http\Request;
use App\Models\AdreamerProduct;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SolarProductVariation;
use App\Models\AdreamerProductVariation;
use App\Http\Resources\OrderManagement\OrderResource;

class OrderController extends Controller
{
    public function index($user_id) {
        $orders = OrderResource::collection(Order::with('items', 'shipping_city.state')->where('user_id', $user_id)->latest()->get());

        return response()->json(['ok' => true, 'orders' => $orders]);
    }

    public function store(Request $request) {
        DB::beginTransaction();

        // logger(json_decode($request->cart_items, true));
        // return 'gg';

        try {

            $fileName = null;
            if ($request->hasFile('kpay_slip')) {
                $fileName = uniqid() . $request->file('kpay_slip')->getClientOriginalName();
                $request->file('kpay_slip')->storeAs('public/images/order', $fileName);
            }


            $order = new Order();
            $order->user_id = $request->user_id;
            $order->name = $request->name;
            $order->phone = $request->phone;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->zip_code = $request->zip_code;
            $order->address = $request->address;
            $order->city_id = $request->city_id;
            $order->total_item_qty = $request->total_qty;
            $order->sub_total = $request->subtotal_mmk;
            $order->shipping_fee = $request->shipping_fee;
            $order->total = (int)$request->subtotal_mmk + (int)$request->shipping_fee;
            $order->payment_method = $request->payment_method;
            $order->slip = $fileName ? '/images/order/' . $fileName : null;
            $order->save();

            $random = strtoupper(Str::random(4));
            $order->order_code = 'ORD-' . $random . '-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
            $order->save();

            $cartItems = json_decode($request->cart_items, true);

            foreach ($cartItems as $cartItem) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_type = $cartItem['product_type'];
                $orderItem->is_attribute = $cartItem['is_attribute'];
                $orderItem->product_id = $cartItem['id'];
                $orderItem->product_variation_id = $cartItem['product_type'] == 'normal' && $cartItem['is_attribute'] ? $cartItem['variations']['id'] : null;
                $orderItem->xp_pen_product_id = $cartItem['product_type'] == 'xp_pen' ? $cartItem['id'] : null;
                $orderItem->solar_product_id = $cartItem['product_type'] == 'solar' ? $cartItem['id'] : null;
                $orderItem->solar_product_variation_id = $cartItem['product_type'] == 'solar' && $cartItem['is_attribute'] ? $cartItem['variations']['id'] : null;
                $orderItem->adreamer_product_id = $cartItem['product_type'] == 'adreamer' ? $cartItem['id'] : null;
                $orderItem->adreamer_product_variation_id = $cartItem['product_type'] == 'adreamer' && $cartItem['is_attribute'] ? $cartItem['variations']['id'] : null;
                $orderItem->qty = $cartItem['quantity'];
                $orderItem->price_mmk = $cartItem['is_attribute'] ? $cartItem['variations']['price_mmk'] : $cartItem['price_mmk'];
                $orderItem->price_us = $cartItem['is_attribute'] ? $cartItem['variations']['price_us'] : $cartItem['price_us'];
                $orderItem->rate = $request->rate;
                $orderItem->save();


                // control stock for product
                if($cartItem['product_type'] == 'normal') {
                    if(isset($cartItem['is_attribute']) && $cartItem['is_attribute']) {
                        $productVariation = ProductVariation::find($cartItem['variations']['id']);
                        $productVariation->qty -= $cartItem['quantity'];
                        $productVariation->save();
                    } else {
                        $product = Product::find($cartItem['id']);
                        $product->qty -= $cartItem['quantity'];
                        $product->save();
                    }
                }

                // control stock for solar product
                if($cartItem['product_type'] == 'solar') {
                    if(isset($cartItem['is_attribute']) && $cartItem['is_attribute']) {
                        $productVariation = SolarProductVariation::find($cartItem['variations']['id']);
                        $productVariation->qty -= $cartItem['quantity'];
                        $productVariation->save();
                    } else {
                        $product = SolarProduct::find($cartItem['id']);
                        $product->qty -= $cartItem['quantity'];
                        $product->save();
                    }
                }

                // control stock for adreamer product
                if($cartItem['product_type'] == 'adreamer') {
                    if(isset($cartItem['is_attribute']) && $cartItem['is_attribute']) {
                        $productVariation = AdreamerProductVariation::find($cartItem['variations']['id']);
                        $productVariation->qty -= $cartItem['quantity'];
                        $productVariation->save();
                    } else {
                        $product = AdreamerProduct::find($cartItem['id']);
                        $product->qty -= $cartItem['quantity'];
                        $product->save();
                    }
                }

                // control stock for xp pen product
                if($cartItem['product_type'] == 'xp_pen') {
                    $product = XpPenProduct::find($cartItem['id']);
                    $product->qty -= $cartItem['quantity'];
                    $product->save();
                }
            }

            DB::commit();

            return response()->json([
                'ok' => true,
                'message' => 'Order created successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());

            return response()->json([
                'ok' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
