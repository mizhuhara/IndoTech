<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'npsn' => 'CMP001',
                'name' => 'PT. Telekomunikasi Indonesia Tbk',
                'type' => 'BUMN',
                'industry' => 'Telekomunikasi',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'location' => 'Bandung, Jawa Barat',
                'address' => 'Jl. Japati No.1, Cibaduyut, Kec. Bojongloa Kidul, Kota Bandung, Jawa Barat 40212',
                'status' => 'Active',
                'logo_name' => 'Telkom_Logo.png',
                'logo_url' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'TELKOM',
                'logo_bg' => 'bg-blue-700',
                'email' => 'corporate@telkom.co.id',
                'website' => 'https://www.telkom.co.id',
                'phone' => '022-7510000',
                'description' => 'PT. Telekomunikasi Indonesia Tbk (Telkom) adalah perusahaan telekomunikasi dan jasa jaringan terbesar di Indonesia.',
                'tags' => ['Telekomunikasi', 'Digital', 'Infrastruktur', 'BUMN'],
                'total_employees' => 24000,
                'founded' => 1965,
                'gallery' => [
                    'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&w=800&q=80',
                ],
                'map_link' => 'https://maps.google.com/maps?q=Jl.+Japati+No.1,+Bandung&t=&z=13&ie=UTF8&iwloc=&output=embed',
            ],
            [
                'npsn' => 'CMP002',
                'name' => 'PT. Bank Rakyat Indonesia (Persero) Tbk',
                'type' => 'BUMN',
                'industry' => 'Perbankan',
                'city' => 'Jakarta Pusat',
                'province' => 'DKI Jakarta',
                'location' => 'Jakarta Pusat, DKI Jakarta',
                'address' => 'Jl. Jenderal Sudirman Kav.44-46, Jakarta Pusat',
                'status' => 'Active',
                'logo_name' => 'BRI_Logo.png',
                'logo_url' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'BRI',
                'logo_bg' => 'bg-yellow-600',
                'email' => 'callcenter@bri.co.id',
                'website' => 'https://www.bri.co.id',
                'phone' => '14017',
                'description' => 'PT. Bank Rakyat Indonesia (Persero) Tbk (BRI) adalah salah satu bank terbesar di Indonesia yang berfokus pada segmentasi UMKM.',
                'tags' => ['Perbankan', 'UMKM', 'BUMN', 'Keuangan'],
                'total_employees' => 58000,
                'founded' => 1895,
                'gallery' => [],
                'map_link' => 'https://maps.google.com/maps?q=Gedung+BRI+Jalan+Sudirman+Jakarta&t=&z=13&ie=UTF8&iwloc=&output=embed',
            ],
            [
                'npsn' => 'CMP003',
                'name' => 'PT. Gojek Indonesia',
                'type' => 'Swasta',
                'industry' => 'Teknologi & Transportasi',
                'city' => 'Jakarta Selatan',
                'province' => 'DKI Jakarta',
                'location' => 'Jakarta Selatan, DKI Jakarta',
                'address' => 'Gedung GoTo Tower, Pasar Minggu, Jakarta Selatan',
                'status' => 'Active',
                'logo_name' => 'Gojek_Logo.png',
                'logo_url' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'GOJEK',
                'logo_bg' => 'bg-green-600',
                'email' => 'support@gojek.com',
                'website' => 'https://www.gojek.com',
                'phone' => '021-50884444',
                'description' => 'PT. Gojek Indonesia adalah platform teknologi terkemuka di Asia Tenggara yang menyediakan layanan transportasi dan pembayaran.',
                'tags' => ['Teknologi', 'Transportasi', 'Fintech', 'Startup'],
                'total_employees' => 8000,
                'founded' => 2010,
                'gallery' => [],
                'map_link' => 'https://maps.google.com/maps?q=GoTo+Tower+Jakarta&t=&z=13&ie=UTF8&iwloc=&output=embed',
            ],
        ];

        foreach ($companies as $company) {
            Company::updateOrCreate(['name' => $company['name']], $company);
        }
    }
}
