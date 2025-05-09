<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Office; // ←✅ This is the missing import

class OfficeSeeder extends Seeder
{
    public function run(): void
    {
        $offices = ['ORD', 'FASS', 'TOS', 'FOS'];

        foreach ($offices as $office) {
            Office::firstOrCreate(['name' => $office], ['status' => 'Active']);
        }

        echo "✅ Offices Seeded Successfully!\n";
    }
}
