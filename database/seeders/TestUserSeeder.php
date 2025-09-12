<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Test Resident',
            'email' => 'resident2@example.com',
            'password' => bcrypt('resident123'),
            'role' => 'resident',
            'email_verified_at' => now(),
        ]);
    }
}
