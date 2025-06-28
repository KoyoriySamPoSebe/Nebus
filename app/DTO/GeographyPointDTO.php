<?php

namespace App\DTO;

use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'GeographyPoint', title: 'GeographyPoint DTO')]
final class GeographyPointDTO
{
    #[OA\Property(type: 'string', enum: ['Point'], example: 'Point')]
    public string $type;

    #[OA\Property(
        type: 'array',
        items: new OA\Items(type: 'number'),
        example: [37.6173, 55.7558]
    )]
    public array $coordinates;
}
