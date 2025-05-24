<?php

namespace App\Http\Resources\ContentManagement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'image_order_no' => $this->image_order_no,
            'image' => asset('/storage' . $this->image),
        ];
    }
}
