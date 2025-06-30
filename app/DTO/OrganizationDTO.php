<?php

namespace App\DTO;

use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'Organization', title: 'Organization DTO')]
final class OrganizationDTO
{
    #[OA\Property(type: 'integer', format: 'int64')]
    public int $id;

    #[OA\Property(type: 'string')]
    public string $name;

    #[OA\Property(
        type: 'array',
        description: 'Массив телефонных номеров в формате E.164',
        items: new OA\Items(type: 'string', format: 'phone')
    )]
    public array $phone_numbers;

    #[OA\Property(type: 'integer', format: 'int64')]
    public int $building_id;

    #[OA\Property(type: 'array', items: new OA\Items(ref: '#/components/schemas/Activity'))]
    public array $activities;

    #[OA\Property(ref: '#/components/schemas/Building')]
    public BuildingDto $building;
}
