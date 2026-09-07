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

        $sampleUsers = [
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.n@sekolah.edu',
                'role' => 'school_admin',
                'status' => 'active',
                'org_contact' => 'Siti Nurhaliza',
                'org_phone' => '081234567890',
                'org_address' => 'Jakarta Barat',
            ],
            [
                'name' => 'Budi Utama',
                'email' => 'budi@universitas.ac.id',
                'role' => 'university_rep',
                'status' => 'pending',
                'org_contact' => 'Budi Utama',
                'org_phone' => '081987654321',
                'org_address' => 'Bandung',
            ],
            [
                'name' => 'Agus Pratama',
                'email' => 'agus.p@perusahaan.co.id',
                'role' => 'company_hr',
                'status' => 'inactive',
                'org_contact' => 'Agus Pratama',
                'org_phone' => '085678901234',
                'org_address' => 'Surabaya',
            ],
            [
                'name' => 'Dewi Anggraini',
                'email' => 'dewi.a@smk1jkt.sch.id',
                'role' => 'school_admin',
                'status' => 'active',
                'org_contact' => 'Dewi Anggraini',
                'org_phone' => '081211223344',
                'org_address' => 'Jakarta Selatan',
            ],
            [
                'name' => 'Rizky Kurnia',
                'email' => 'rizky.k@techcorp.co.id',
                'role' => 'company_hr',
                'status' => 'active',
                'org_contact' => 'Rizky Kurnia',
                'org_phone' => '087788990011',
                'org_address' => 'Tangerang',
            ],
        ];

        foreach ($sampleUsers as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                array_merge($u, [
                    'password' => Hash::make('password123'),
                ])
            );
        }

        if (class_exists('Database\\Seeders\\JobListingSeeder')) {
            $this->call('Database\\Seeders\\JobListingSeeder');
        }
        if (class_exists('Database\\Seeders\\SchoolSeeder')) {
            $this->call('Database\\Seeders\\SchoolSeeder');
        }
    }
}
