<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnitProvider;

class UnitProviderSeeder extends Seeder
{
    public function run()
    {
        $unitProviders = [
            'ORD', 'FASS', 'TOS',
            'PSTO Batanes', 'PSTO Cagayan',
            'PSTO Isabela', 'PSTO Quirino', 'PSTO Nueva Vizcaya'
        ];

        foreach ($unitProviders as $unit) {
            UnitProvider::firstOrCreate(
                ['unit_name' => $unit],
                ['status' => 'Active'] // Ensuring a default status
            );
        }

        echo "✅ Unit Providers Seeded Successfully!\n";
    }
}
