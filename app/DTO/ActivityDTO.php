<?php

namespace App\DTO;

use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'Activity', title: 'Activity DTO')]
final class ActivityDTO
{
    #[OA\Property(type: 'integer', format: 'int64')]
    public int $id;

    #[OA\Property(type: 'string')]
    public string $name;

    #[OA\Property(type: 'integer', format: 'int64')]
    public int $parent_id;
}
