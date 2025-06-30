<?php

namespace App\DTO;

use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'Building', title: 'Building DTO')]
final class BuildingDTO
{
    #[OA\Property(type: 'integer', format: 'int64')]
    public int $id;

    #[OA\Property(type: 'string')]
    public string $address;

    #[OA\Property(ref: '#/components/schemas/GeographyPoint')]
    public GeographyPointDto $location;
}
