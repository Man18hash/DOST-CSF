<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnitProvider;

class UnitProviderSeeder extends Seeder
{
    public function run()
    {
        UnitProvider::firstOrCreate(['unit_name' => 'ORD']);
        UnitProvider::firstOrCreate(['unit_name' => 'FASS']);
        UnitProvider::firstOrCreate(['unit_name' => 'TOS']);
        UnitProvider::firstOrCreate(['unit_name' => 'PSTO Batanes']);
        UnitProvider::firstOrCreate(['unit_name' => 'PSTO Cagayan']);
        UnitProvider::firstOrCreate(['unit_name' => 'PSTO Isabela']);
        UnitProvider::firstOrCreate(['unit_name' => 'PSTO Quirino']);
        UnitProvider::firstOrCreate(['unit_name' => 'PSTO Nueva Vizcaya']);
    }
}
