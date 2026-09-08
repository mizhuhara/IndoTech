<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            [
                'npsn' => '20109988', 'name' => 'SMK Telkom Jakarta', 'institution_type' => 'SMK IT',
                'city' => 'Jakarta Barat', 'province' => 'DKI Jakarta', 'location' => 'Jakarta Barat, DKI Jakarta',
                'address' => 'Jl. Daan Mogot, Cengkareng, Jakarta Barat, 11730', 'status' => 'Active',
                'logo_url' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'TELKOM', 'logo_bg' => 'bg-blue-600', 'email' => 'info@smktelkomjakarta.sch.id',
                'website' => 'https://smktelkomjakarta.sch.id', 'phone' => '021-56957111',
                'description' => 'SMK Telkom Jakarta is a premier vocational high school focusing on Information Technology and Telecommunications. We prepare students for the modern tech workforce with a specialized curriculum in Network Engineering, Software Development, and Multimedia.',
                'tags' => ['TKJ', 'RPL', 'Broadcasting'], 'total_students' => 1850, 'industry_partners' => 72,
                'founded' => 1989, 'accreditation' => 'A',
            ],
            [
                'npsn' => '20211234', 'name' => 'SMK Negeri 1 Bandung', 'institution_type' => 'SMK IT',
                'city' => 'Bandung', 'province' => 'Jawa Barat', 'location' => 'Bandung, Jawa Barat',
                'address' => 'Jl. Wastukencana No.3, Bandung, Jawa Barat 40117', 'status' => 'Active',
                'logo_url' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'SMK 1', 'logo_bg' => 'bg-sky-600', 'email' => 'info@smkn1bandung.sch.id',
                'website' => 'https://smkn1bandung.sch.id', 'phone' => '022-4203974',
                'description' => 'SMK Negeri 1 Bandung is a premier vocational high school in West Java providing top education in Software Development, Computer Networks, and Digital Media.',
                'tags' => ['RPL', 'TKJ', 'Multimedia'], 'total_students' => 2100, 'industry_partners' => 85,
                'founded' => 1950, 'accreditation' => 'A',
            ],
            [
                'npsn' => '70012555', 'name' => 'SMK IT Bali Koding', 'institution_type' => 'SMK IT',
                'city' => 'Denpasar', 'province' => 'Bali', 'location' => 'Denpasar, Bali',
                'address' => 'Jl. Raya Kuta No.88, Denpasar, Bali 80361', 'status' => 'Active',
                'logo_url' => '', 'logo_text' => 'BK', 'logo_bg' => 'bg-emerald-600',
                'email' => 'info@balikoding.sch.id', 'website' => 'https://balikoding.sch.id', 'phone' => '0361-900800',
                'description' => 'SMK IT Bali Koding focuses on software engineering and digital creative industries, preparing Bali students for the global IT workforce.',
                'tags' => ['RPL', 'Multimedia'], 'total_students' => 520, 'industry_partners' => 25,
                'founded' => 2015, 'accreditation' => 'A',
            ],
            [
                'npsn' => '20301122', 'name' => 'SMK Raden Umar Said', 'institution_type' => 'SMK IT',
                'city' => 'Kudus', 'province' => 'Jawa Tengah', 'location' => 'Kudus, Jawa Tengah',
                'address' => 'Jl. Kudus–Colo Km.5, Kudus, Jawa Tengah 59353', 'status' => 'Active',
                'logo_url' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'RUS', 'logo_bg' => 'bg-purple-700', 'email' => 'hello@smkrus.sch.id',
                'website' => 'https://smkrus.sch.id', 'phone' => '0291-434876',
                'description' => 'SMK Raden Umar Said (RUS) Kudus is an internationally recognized 3D animation and software development school with cutting-edge production pipelines.',
                'tags' => ['3D Animation', 'RPL'], 'total_students' => 980, 'industry_partners' => 45,
                'founded' => 1998, 'accreditation' => 'A',
            ],
            [
                'npsn' => '20501987', 'name' => 'SMK Negeri 1 Denpasar', 'institution_type' => 'SMK IT',
                'city' => 'Denpasar', 'province' => 'Bali', 'location' => 'Denpasar, Bali',
                'address' => 'Jl. Hos Cokroaminoto No.84, Denpasar, Bali 80119', 'status' => 'Active',
                'logo_url' => '', 'logo_text' => 'SMK 1', 'logo_bg' => 'bg-teal-700', 'email' => 'info@smkn1denpasar.sch.id',
                'website' => 'https://smkn1denpasar.sch.id', 'phone' => '0361-262375',
                'description' => 'SMK Negeri 1 Denpasar is a center of vocational excellence in Bali focused on IT solutions, programming, and networking infrastructure.',
                'tags' => ['RPL', 'TKJ', 'Multimedia'], 'total_students' => 1350, 'industry_partners' => 40,
                'founded' => 1970, 'accreditation' => 'A',
            ],
            [
                'npsn' => '20601543', 'name' => 'SMK Telkom Medan', 'institution_type' => 'SMK IT',
                'city' => 'Medan', 'province' => 'Sumatera Utara', 'location' => 'Medan, Sumatera Utara',
                'address' => 'Jl. Jamin Ginting No.485, Medan, Sumatera Utara 20156', 'status' => 'Active',
                'logo_url' => '', 'logo_text' => 'TLK MDN', 'logo_bg' => 'bg-red-600', 'email' => 'info@smktelkommdn.sch.id',
                'website' => 'https://smktelkom-mdn.sch.id', 'phone' => '061-7364855',
                'description' => 'SMK Telkom Medan offers specialized training in telecommunication, enterprise network engineering, and modern web application development.',
                'tags' => ['TKJ', 'RPL', 'Broadcasting'], 'total_students' => 1400, 'industry_partners' => 60,
                'founded' => 2002, 'accreditation' => 'A',
            ],
            [
                'npsn' => '20701321', 'name' => 'SMK Negeri 2 Makassar', 'institution_type' => 'SMK IT',
                'city' => 'Makassar', 'province' => 'Sulawesi Selatan', 'location' => 'Makassar, Sulawesi Selatan',
                'address' => 'Jl. Perintis Kemerdekaan Km.12, Makassar, Sulawesi Selatan 90245', 'status' => 'Active',
                'logo_url' => '', 'logo_text' => 'SMK 2', 'logo_bg' => 'bg-sky-700', 'email' => 'contact@smkn2makassar.sch.id',
                'website' => 'https://smkn2makassar.sch.id', 'phone' => '0411-324567',
                'description' => 'SMK Negeri 2 Makassar provides top-tier education in computer informatics, cloud services, and enterprise software engineering.',
                'tags' => ['RPL', 'TKJ', 'SIJA'], 'total_students' => 1250, 'industry_partners' => 35,
                'founded' => 1967, 'accreditation' => 'A',
            ],
        ];

        foreach ($schools as $school) {
            School::updateOrCreate(['npsn' => $school['npsn']], $school);
        }
    }
}