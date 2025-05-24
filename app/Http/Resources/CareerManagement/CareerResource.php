<?php

namespace App\Http\Resources\CareerManagement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CareerResource extends JsonResource
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
            'position' => $this->whenLoaded('position', fn () => $this->position->name),
            'position_slug' => $this->whenLoaded('position', fn () => $this->position->slug),
            'department' => $this->whenLoaded('department', fn () => $this->department->name),
            'responsibilities' => $this->job_responsibility,
            'requirements' => $this->job_requirement,
            'salary' => $this->salary,
            'contact_mail' => $this->contact_mail,
            'call_phone' => $this->call_phone,
            'viber_phone' => $this->viber_phone,
            'office_location' => $this->office_location,
            'working_time' => $this->working_time,
            'off_days' => $this->off_days
        ];
    }
}
