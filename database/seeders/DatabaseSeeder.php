<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            ['name' => 'Test User', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );

        // Super admin bersama (proyek tim). Password dari .env; generate jika kosong.
        $adminPassword = env('ADMIN_PASSWORD') ?: Str::password(16);

        User::updateOrCreate(
            ['email' => User::ADMIN_EMAIL],
            [
                'name' => 'Super Admin',
                'password' => Hash::make($adminPassword),
                'role' => 'super_admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        if (! env('ADMIN_PASSWORD')) {
            $this->command?->warn("ADMIN_PASSWORD kosong. Password super admin: {$adminPassword}");
        }

        $this->call([
            UniversitySeeder::class,
            JobListingSeeder::class,
            SchoolSeeder::class,
            CompanySeeder::class,
            EventSeeder::class,
            CommunitySeeder::class,
        ]);
    }
}
