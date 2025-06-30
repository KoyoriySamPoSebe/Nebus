<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_numbers' => $this->phone_numbers,
            'building' => [
                'id' => $this->building->id,
                'address' => $this->building->address,
            ],
            'activities' => $this->activities->map(fn ($activity) => [
                'id' => $activity->id,
                'name' => $activity->name,
            ]),
        ];
    }
}
