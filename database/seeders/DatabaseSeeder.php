<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed default user
        User::firstOrCreate(
            ['email' => 'test@example.com'], // Ensures uniqueness
            [
                'name' => 'Test User',
                'password' => bcrypt('password'), // Ensure password is hashed
            ]
        );

        // Call additional seeders
        $this->call([
            AdminSeeder::class,
            OfficeSeeder::class,
            UnitProviderSeeder::class,
            DOSTEmployeeSeeder::class,
        ]);
    }
}
