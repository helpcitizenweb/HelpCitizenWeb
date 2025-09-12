<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $admin = [
            'id' => 1,
            'name' => 'super admin',
            'email' => 'superadmin@example.com',
            'role' => 'admin',
            'password' => '$2y$12$Gto4aW1MRF3ooHFzPXbt/uet40MTvqrYVD5Hrqr4TGVMcoYCJwP.O',
            'remember_token' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if (DB::table('users')->where('id', 1)->exists()) {
            DB::table('users')->where('id', 1)->update($admin);
        } else {
            DB::table('users')->insert($admin);
        }

        if (!DB::table('users')->where('role', 'user')->exists()) {
            DB::table('users')->insert([
                'name' => 'default user',
                'email' => 'user@example.com',
                'role' => 'resident',
                'password' => '$2y$12$Gto4aW1MRF3ooHFzPXbt/uet40MTvqrYVD5Hrqr4TGVMcoYCJwP.O',
                'remember_token' => '',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('users')
            ->whereIn('email', ['superadmin@example.com', 'user@example.com'])
            ->delete();
    }
};
