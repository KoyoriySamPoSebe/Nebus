<?php

namespace App\Interfaces;

interface ActivityInterface
{
    public function getDescendantIds(int $activityId, int $maxDepth = 3): array;
}
