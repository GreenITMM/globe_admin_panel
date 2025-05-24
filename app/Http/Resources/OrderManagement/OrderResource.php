<?php

namespace App\Http\Resources\OrderManagement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_code' => $this->order_code,
            'total_item_qty' => $this->total_item_qty,
            'sub_total' => $this->sub_total,
            'shipping_fee' => $this->shipping_fee,
            'total' => $this->total,
            'payment_method' => $this->payment_method,
            'slip' => $this->slip ? asset('/storage'.  $this->slip) : null,
            'status' => $this->status,
            'shipping_state' => $this->shipping_city->state->name,
            'shipping_city' => $this->shipping_city->name,
            'item' => OrderItemResource::collection($this->items)
        ];
    }
}
