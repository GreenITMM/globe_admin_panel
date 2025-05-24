<?php

namespace App\Http\Resources\ContentManagement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
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
            'image' => asset('/storage' . $this->image),
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ];
    }
}
