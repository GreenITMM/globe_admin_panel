<?php

namespace App\Http\Resources\OrderManagement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'product_type' => $this->product_type,
            'image_url' => match($this->product_type) {
                'normal' => asset('/storage' . $this->product->images[0]['image'] ?? ''),
                'solar' => asset('/storage' . $this->solar_product->images[0]['image'] ?? ''),
                'adreamer' => asset('/storage' . $this->adreamer_product->images[0]['image'] ?? ''),
                'xp_pen' => asset('/storage' . $this->xp_pen_product->images[0]['image'] ?? ''),
                default => null,
            },
            'name' => match($this->product_type) {
                'normal' => $this->product->name ?? '',
                'solar' => $this->solar_product->name ?? '',
                'adreamer' => $this->adreamer_product->name ?? '',
                'xp_pen' => $this->xp_pen_product->name ?? '',
                default => '',
            },
            'variation_attributes' => match($this->product_type) {
                'normal' => $this->product_variation ? json_decode($this->product_variation->attributes, true) : null,
                'solar' => $this->solar_product_variation ? json_decode($this->solar_product_variation->attributes, true) : null,
                'adreamer' => $this->adreamer_product_variation ? json_decode($this->adreamer_product_variation->attributes, true) : null,
                'xp_pen' => $this->xp_pen_product_variation ? json_decode($this->xp_pen_product_variation->attributes, true) : null,
                default => null,
            },
            'qty' => $this->qty,
            'price' => $this->price_us == 0
                ? 'ks ' . number_format($this->price_mmk)
                : '$ ' . number_format($this->price_us),

            'rate' => $this->price_us == 0
                ? '-'
                : number_format($this->rate),

            'total_price' => $this->price_us == 0
                ? 'ks ' . number_format($this->price_mmk * $this->qty)
                : 'ks ' . number_format($this->price_us * $this->qty * $this->rate),
        ];
    }
}
