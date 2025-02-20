<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'], // Ensures uniqueness
            [
                'name' => 'Test User',
                'password' => bcrypt('password'), // Ensure password is hashed
            ]
        );
    }
}

