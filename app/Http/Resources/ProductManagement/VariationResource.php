<?php

namespace App\Http\Resources\ProductManagement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariationResource extends JsonResource
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
            'price_mmk' => $this->price_mmk,
            'price_us' => $this->price_us,
            'qty' => $this->qty,
            'sku' => $this->sku,
            'attributes' => json_decode($this->attributes),
        ];
    }
}
