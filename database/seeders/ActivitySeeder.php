<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run()
    {
        $food = Activity::create(['name' => 'Еда']);
        Activity::create(['name' => 'Мясная продукция', 'parent_id' => $food->id]);
        Activity::create(['name' => 'Молочная продукция', 'parent_id' => $food->id]);

        $vehicles = Activity::create(['name' => 'Автомобили']);
        Activity::create(['name' => 'Грузовые', 'parent_id' => $vehicles->id]);
        Activity::create(['name' => 'Легковые', 'parent_id' => $vehicles->id]);
    }
}
