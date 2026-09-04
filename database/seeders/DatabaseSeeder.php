<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Super admin bersama (proyek tim). Password dari .env, fallback default.
        \App\Models\User::updateOrCreate(
            ['email' => \App\Models\User::ADMIN_EMAIL],
            [
                'name' => 'Super Admin',
                'password' => \Illuminate\Support\Facades\Hash::make(env('ADMIN_PASSWORD', 'IndoTech#2026!Admin')),
                'role' => 'super_admin',
                'status' => 'active',
            ]
        );
    }
}
