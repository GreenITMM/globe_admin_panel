<?php

namespace App\Http\Resources\SolarManagement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SolarManagement\SolarVariationResource;
use App\Http\Resources\SolarManagement\SolarProductImageResource;

class SolarProductResource extends JsonResource
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
            'description' => $this->description,
            'specification' => $this->specification,
            'price_mmk' => $this->price_mmk,
            'price_us' => $this->price_us,
            'qty' => count($this->variations) > 0 ? $this->variations->max('qty') : $this->qty,
            'rating' => $this->rating,
            'product_type' => 'solar',
            'is_attribute' => count($this->variations) > 0 ? true : false,
            'currency' => $this->variations->max('price_us') == 0 ? 'MMK' : 'USD',
            'price_range' => count($this->variations) > 0 ? ($this->variations->max('price_us') == 0 ?  $this->variations->min('price_mmk').'-'.$this->variations->max('price_mmk') : $this->variations->min('price_us') .'-'.$this->variations->max('price_us')) : null,
            'variations' => SolarVariationResource::collection($this->whenLoaded('variations')),
            // 'attributes' => AttributeResource::collection($this->whenLoaded('attributes')),
            'images' => $this->whenLoaded('images', fn() => SolarProductImageResource::collection($this->images)),
            'preview_images' => $this->whenLoaded('images', fn() => SolarProductImageResource::collection($this->images()->limit(2)->get())),
        ];
    }
}
