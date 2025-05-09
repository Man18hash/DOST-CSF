<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Office;
use App\Models\UnitProvider;

class UnitProviderSeeder extends Seeder
{
    public function run(): void
    {
        $officeUnits = [
            'ORD' => ['ORD', 'PSTO Batanes', 'PSTO Cagayan', 'PSTO Isabela', 'PSTO Nueva Vizcaya', 'PSTO Quirino', 'Records Management Unit', 'GIA', 'MIS'],
            'FASS' => ['FASS', 'ABC', 'Purchasing', 'Scholarship', 'Human Resource', 'Maintenance'],
            'TOS'  => ['TOS', 'Redim', 'SETUP', 'S&T Information and Promotion', 'CEST', 'Startbook', 'DRRM', 'GAD', 'RML', 'RSTL'],
            'FOS'  => ['SETUP RPMO', 'Packaging and labelling'],
        ];

        foreach ($officeUnits as $officeName => $units) {
            $office = Office::where('name', $officeName)->first();

            if (!$office) {
                echo "❌ Office '{$officeName}' not found. Skipping units...\n";
                continue;
            }

            foreach ($units as $unitName) {
                UnitProvider::firstOrCreate(
                    ['unit_name' => $unitName],
                    ['office_id' => $office->id, 'status' => 'Active']
                );
            }
        }

        echo "✅ Unit Providers Seeded Successfully!\n";
    }
}
