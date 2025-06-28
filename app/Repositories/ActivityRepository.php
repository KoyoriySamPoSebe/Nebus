<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\ActivityInterface;
use App\Models\Activity;

final class ActivityRepository implements ActivityInterface
{
    public function getDescendantIds(int $activityId, ?int $maxDepth = null): array
    {
        $activity = Activity::findOrFail($activityId);

        $descendantsQuery = $activity->descendants();

        if ($maxDepth !== null) {
            $descendantsQuery->depth($maxDepth);
        }

        return $descendantsQuery
            ->pluck('id')
            ->push($activity->id)
            ->unique()
            ->toArray();
    }
}
