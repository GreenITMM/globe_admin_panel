<?php

namespace App\Http\Resources\XpPenManagement;

use App\Models\CurrencyRate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductManagement\ProductImageResource;

class XPPenProductResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'category' => $this->whenLoaded('category', fn() => $this->category->name),
            'category_slug' => $this->whenLoaded('category', fn() => $this->category->slug),
            'series' => $this->whenLoaded('series', fn() => $this->series->name),
            'series_slug' => $this->whenLoaded('series', fn() => $this->series->slug),
            'description' => $this->description,
            'specification' => $this->specification,
            'price_mmk' => $this->price_mmk,
            'price_us' => $this->price_us,
            'product_type' => 'xp_pen',
            'qty' => $this->qty,
            'is_attribute' => false,
            'rating' => $this->rating,
            'images' => $this->whenLoaded('images', fn() => ProductImageResource::collection($this->images)),
            'preview_images' => $this->whenLoaded('images', fn() => ProductImageResource::collection($this->images()->limit(2)->get())),
        ];
    }
}
