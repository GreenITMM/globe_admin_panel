<?php

namespace App\Http\Resources\SolarManagement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolarProductImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'image_url' => asset('/storage'.  $this->image),
         ];
    }
}
