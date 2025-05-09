<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminLogin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminLogin::firstOrCreate(
            ['email' => 'admin@example.com'],  // lookup by email
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
