<?php

namespace App\Http\Resources\SolarManagement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SolarManagement\SolarSubCategoryResource;

class SolarCategoryResource extends JsonResource
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
            'children' => SolarSubCategoryResource::collection($this->children)
        ];
    }
}
