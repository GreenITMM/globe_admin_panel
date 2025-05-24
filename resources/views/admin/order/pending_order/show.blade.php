@extends('layouts.app')
@section('title', 'Order Detail')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-cart' style="color: rgb(128, 7, 133);"></i>
        <div>Order Detail</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Order Detail</span>

        </div>
        <div class="card-body px-5">
            <input type="hidden" id="order_id" value="{{$order->id}}">
            <div>
                <h4 class="fw-bold">{{$order->order_code}}</h4>
                <p>Order Date: {{date('d-m-Y', strtotime($order->created_at))}}</p>
            </div>
            <hr>
            <div>
                <p>{{$order->name}}</p>
                <p>{{$order->user->email}}</p>
                <p>{{$order->city}}, {{$order->state}}, {{$order->zip_code}}</p>
                <p>{{$order->phone}}</p>
                <p>{{$order->address}}</p>
                <p><span class="fw-bold">Shipping</span> - {{$order->shipping_city->state->name}}, {{$order->shipping_city->name}}</p>
            </div>
            <hr>
            <table class="table table-bordered table-striped">
                <tr>
                    <th width="20%">Product</th>
                    <th class="text-center" width="10%">Qty</th>
                    <th class="text-center" width="10%">Price</th>
                    <th class="text-center" width="10%">Rate</th>
                    <th class="text-center" width="10%">Total</th>
                </tr>
                @foreach ($order->items as $item)
                    <tr>
                        <td>
                            <div class="d-flex gap-3">
                                @if($item->product_type == 'normal')
                                    <div>
                                        <img style="width: 90px; object-fit: cover;" src="{{asset('storage/'.$item->product->images[0]['image'])}}" alt="">
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">{{$item->product->name}}</h5>
                                        @if ($item->product_variation)
                                            <div class="bg-info d-inline-block px-2  rounded fs-6 text-white fw-bold">
                                                @foreach(json_decode($item->product_variation->attributes, true) as $key => $value)
                                                    <span>{{$value}}</span>,
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @elseif($item->product_type == 'adreamer')
                                    <div>
                                        <img style="width: 90px; object-fit: cover;" src="{{asset('storage/'.$item->adreamer_product->images[0]['image'])}}" alt="">
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">{{$item->adreamer_product->name}}</h5>
                                        @if ($item->adreamer_product_variation)
                                            <div class="bg-info d-inline-block px-2  rounded fs-6 text-white fw-bold">
                                                @foreach(json_decode($item->adreamer_product_variation->attributes, true) as $key => $value)
                                                    <span>{{$value}}</span>,
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @elseif($item->product_type == 'solar')
                                    <div>
                                        <img style="width: 90px; object-fit: cover;" src="{{asset('storage/'.$item->solar_product->images[0]['image'])}}" alt="">
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">{{$item->solar_product->name}}</h5>
                                        @if ($item->solar_product_variation)
                                            <div class="bg-info d-inline-block px-2  rounded fs-6 text-white fw-bold">
                                                @foreach(json_decode($item->solar_product_variation->attributes, true) as $key => $value)
                                                    <span>{{$value}}</span>,
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @elseif($item->product_type == 'xp_pen')
                                    <div>
                                        <img style="width: 90px; object-fit: cover;" src="{{asset('storage/'.$item->xp_pen_product->images[0]['image'])}}" alt="">
                                    </div>
                                    <h5 class="fw-bold mb-1">{{$item->xp_pen_product->name}}</h5>
                                @endif
                            </div>
                        </td>
                        <td class="text-center fw-bold">
                            {{$item->qty}}
                        </td>
                        <td class="text-center fw-bold">
                            @if($item->price_us == 0)
                                <span class="text-muted">ks</span> {{number_format($item->price_mmk)}}
                            @else
                                <span class="text-muted">$</span> {{number_format($item->price_us)}}
                            @endif
                        </td>
                        <td class="text-center fw-bold">
                            @if($item->price_us == 0)
                                -
                            @else
                                 {{number_format($item->rate)}}
                            @endif
                        </td>
                        <td class="text-end fw-bold">
                            @if ($item->price_us == 0)
                                <span class="text-muted">ks</span> {{number_format($item->price_mmk * $item->qty)}}
                            @else
                                <span class="text-muted">ks</span> {{number_format($item->price_us * $item->qty * $item->rate)}}
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="text-center fw-bold">Sub Total</td>
                    <td class="text-end fw-bold">
                        <span class="text-muted">ks</span> {{number_format($order->sub_total)}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-center fw-bold">Shipping Fee</td>
                    <td class="text-end fw-bold">
                        <span class="text-muted">ks</span> {{number_format($order->shipping_fee)}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-center fw-bold">Grand Total</td>
                    <td class="text-end fw-bold">
                        <span class="text-muted">ks</span> {{number_format($order->total)}}
                    </td>
                </tr>
            </table>

            <div class="{{$order->payment_method == 'cod' ? 'w-25' : 'w-75'}}">
                <table class="table  mt-5">
                    <tr>
                        <td>Payment Method</td>
                        <td class="fw-bold">{{ ucwords($order->payment_method) }}</td>
                    </tr>
                    @if ($order->payment_method != 'cod')
                        <tr>
                            <td>Slip</td>
                            <td>
                                <img style="width: 60%; object-fit: cover;" src="{{asset('storage/'.$order->slip)}}" alt="">
                            </td>
                        </tr>
                    @endif
                </table>
            </div>

            <div class="mt-5 d-flex justify-content-between">
                <button class="btn btn-outline-secondary  back-btn">Back to List</button>
                <div>
                    <button class="btn btn-danger  cancel-order-btn">Cancel Order</button>
                    <button class="btn btn-primary  confirm-order-btn">Confirm Order</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/order-management/pending_order.js')}}"></script>
@endsection
