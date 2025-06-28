<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    public function run()
    {
        $buildings = Building::all();
        $activities = Activity::all();

        Organization::create([
            'name' => 'ООО Рога и Копыта',
            'phone_numbers' => json_encode(['2-222-222', '3-333-333']),
            'building_id' => $buildings->first()->id,
        ]);

        Organization::create([
            'name' => 'ООО Молоко Сити',
            'phone_numbers' => json_encode(['8-923-666-13-13']),
            'building_id' => $buildings->last()->id,
        ]);

        Organization::create([
            'name' => 'ООО АвтоТех',
            'phone_numbers' => json_encode(['2-999-999']),
            'building_id' => $buildings->first()->id,
        ]);

        $org1 = Organization::firstWhere('name', 'ООО Рога и Копыта');
        $org1->activities()->attach($activities->pluck('id')->toArray());

        $org2 = Organization::firstWhere('name', 'ООО Молоко Сити');
        $org2->activities()->attach($activities->pluck('id')->toArray());

        $org3 = Organization::firstWhere('name', 'ООО АвтоТех');
        $org3->activities()->attach($activities->pluck('id')->toArray());
    }
}
