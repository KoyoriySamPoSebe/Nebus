<?php

namespace App\Interfaces;

use App\Models\Organization;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrganizationInterface
{
    public function find(int $id): Organization;
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator;
    public function getWithinRadius(float $latitude, float $longitude, float $radius, int $perPage = 15): LengthAwarePaginator;
}
