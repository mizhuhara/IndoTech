<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => Hash::make('password')]
        );

        // Super admin bersama (proyek tim). Password dari .env, fallback default.
        User::updateOrCreate(
            ['email' => User::ADMIN_EMAIL],
            [
                'name' => 'Super Admin',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'IndoTech#2026!Admin')),
                'role' => 'super_admin',
                'status' => 'active',
            ]
        );
        $this->call(UniversitySeeder::class);
    }
}
