<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\OrganizationInterface;
use App\Models\Organization;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class OrganizationRepository implements OrganizationInterface
{
    public function find(int $id): Organization
    {
        return Organization::with(['building', 'activities'])->findOrFail($id);
    }

    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Organization::with(['building', 'activities']);

        if (!empty($filters['building_id'])) {
            $query->where('building_id', $filters['building_id']);
        }

        if (!empty($filters['activity_ids'])) {
            $query->whereHas('activities', fn ($q) => $q->whereIn('activities.id', $filters['activity_ids']));
        }

        if (!empty($filters['name'])) {
            $query->where('name', 'ilike', "%{$filters['name']}%");
        }

        return $query->paginate(perPage: $perPage);
    }

    public function getWithinRadius(
        float $latitude,
        float $longitude,
        float $radius,
        int $perPage = 15
    ): LengthAwarePaginator {
        return Organization::with(['building', 'activities'])
            ->whereHas('building', function ($q) use ($latitude, $longitude, $radius) {
                $q->whereRaw(
                    'ST_DWithin(location::geography, ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography, ?)',
                    [$longitude, $latitude, $radius]
                );
            })
            ->paginate($perPage);
    }
}
