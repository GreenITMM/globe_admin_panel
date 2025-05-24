<?php

namespace App\Http\Resources\AdreamerManagement;

use App\Models\CurrencyRate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdreamerProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $usdToMmkRate = CurrencyRate::where('from_currency', 'USD')
                        ->where('to_currency', 'MMK')
                        ->latest('created_at')
                        ->value('rate');

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
            'rate' => $usdToMmkRate,
            'qty' => count($this->variations) > 0 ? $this->variations->max('qty') : $this->qty,
            'rating' => $this->rating,
            'product_type' => 'adreamer',
            'is_attribute' => count($this->variations) > 0 ? true : false,
            'currency' => $this->variations->max('price_us') == 0 ? 'MMK' : 'USD',
            'price_range' => count($this->variations) > 0 ? ($this->variations->max('price_us') == 0 ?  $this->variations->min('price_mmk').'-'.$this->variations->max('price_mmk') : $this->variations->min('price_us') .'-'.$this->variations->max('price_us')) : null,
            'variations' => AdreamerVariationResource::collection($this->whenLoaded('variations')),
            // 'attributes' => AttributeResource::collection($this->whenLoaded('attributes')),
            'images' => $this->whenLoaded('images', fn() => AdreamerProductImageResource::collection($this->images)),
            'preview_images' => $this->whenLoaded('images', fn() => AdreamerProductImageResource::collection($this->images()->limit(2)->get())),
        ];
    }
}
