<?php

namespace Database\Seeders;

use App\Models\Building;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    public function run()
    {
        Building::create([
            'address' => 'г. Москва, ул. Ленина 1, офис 1',
            'location' => Point::makeGeodetic(55.7558, 37.6173),
        ]);

        Building::create([
            'address' => 'г. Москва, ул. Тверская 12, офис 2',
            'location' => Point::makeGeodetic(37.6156, 55.7522),
        ]);
    }
}
