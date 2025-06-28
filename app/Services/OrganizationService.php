<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\OrganizationInterface;
use App\Models\Organization;
use App\Repositories\ActivityRepository;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class OrganizationService
{
    public function __construct(
        private OrganizationInterface $orgRepo,
        private ActivityRepository $activityRepo,
    ) {
    }

    public function getAll(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        if (!empty($filters['activity_id'])) {
            $maxDepth = $filters['level'] ?? null;
            $filters['activity_ids'] = $this->activityRepo->getDescendantIds(
                (int)$filters['activity_id'],
                $maxDepth !== null ? (int) $maxDepth : null
            );

            unset($filters['activity_id']);
        }

        return $this->orgRepo->getAll($filters, $perPage);
    }

    public function find(int $id): Organization
    {
        return $this->orgRepo->find($id);
    }

    public function searchWithinRadius(
        float $latitude,
        float $longitude,
        float $radius,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->orgRepo->getWithinRadius($latitude, $longitude, $radius, $perPage);
    }
}
