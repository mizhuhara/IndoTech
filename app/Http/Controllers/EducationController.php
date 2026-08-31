<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EducationController extends Controller
{
    private function getSchoolsData()
    {
        return [
            [
                'id' => 'smk-negeri-4-jakarta',
                'numeric_id' => 1,
                'name' => 'SMK Negeri 4 Jakarta',
                'verified' => true,
                'category_badge' => 'Vocational High School',
                'location' => 'North Jakarta, DKI Jakarta',
                'location_full' => 'North Jakarta, DKI Jakarta, Indonesia',
                'province' => 'DKI Jakarta',
                'tags' => ['RPL', 'TKJ', 'Multimedia'],
                'status_badge' => 'Enrollment Open',
                'status_badge_type' => 'green',
                'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1000&q=80',
                'logo_bg_class' => 'bg-sky-600',
                'logo_text' => 'SMK 4',
                'website' => 'https://smkn4jakarta.sch.id',
                'email' => 'info@smkn4jakarta.sch.id',
                'map_link' => 'https://maps.google.com/?q=SMK+Negeri+4+Jakarta',
                'about' => 'SMK Negeri 4 Jakarta is a premier vocational high school located in North Jakarta. Focused on IT excellence, software engineering, and computer networking, the school prepares students for modern digital careers through industry-aligned curricula and state-of-the-art facilities.',
                'mission' => 'Our mission is to foster technical expertise, creative problem solving, and work readiness. Through strong partnerships with leading technology firms, we empower students to excel in national and international tech ecosystems.',
                'stats' => [
                    'placement_rate' => '88%',
                    'industry_partners' => '65+',
                    'active_students' => '1450',
                    'modern_labs' => '18'
                ],
                'competencies' => [
                    [
                        'name' => 'Software Engineering (RPL)',
                        'icon' => 'code',
                        'desc' => 'Focused on software engineering, web development, mobile app creation, and modern programming paradigms.'
                    ],
                    [
                        'name' => 'Computer Network Engineering (TKJ)',
                        'icon' => 'server',
                        'desc' => 'Covers network infrastructure, cloud computing, cybersecurity, and system administration.'
                    ],
                    [
                        'name' => 'Multimedia & Graphic Design',
                        'icon' => 'palette',
                        'desc' => 'Training in UI/UX design, 2D/3D animation, video production, and digital graphic design.'
                    ]
                ]
            ],
            [
                'id' => 'smk-telkom-bandung',
                'numeric_id' => 2,
                'name' => 'SMK Telkom Bandung',
                'verified' => true,
                'category_badge' => 'Vocational High School',
                'location' => 'Bandung, West Java',
                'location_full' => 'Bandung, West Java, Indonesia',
                'province' => 'West Java',
                'tags' => ['TKJ', 'Broadcasting'],
                'status_badge' => 'Teaching Factory',
                'status_badge_type' => 'gray',
                'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=1000&q=80',
                'logo_bg_class' => 'bg-rose-600',
                'logo_text' => 'TELKOM',
                'website' => 'https://smktelkom-bdg.sch.id',
                'email' => 'contact@smktelkom-bdg.sch.id',
                'map_link' => 'https://maps.google.com/?q=SMK+Telkom+Bandung',
                'about' => 'SMK Telkom Bandung is a renowned telecommunication and Information Technology vocational school in West Java. Built under the Telkom Education Foundation, it delivers top-tier networking and digital media skills.',
                'mission' => 'We aim to produce tech-savvy innovators equipped with telecommunication mastery, networking expertise, and digital media skills ready for national industry standards.',
                'stats' => [
                    'placement_rate' => '92%',
                    'industry_partners' => '80+',
                    'active_students' => '1600',
                    'modern_labs' => '20'
                ],
                'competencies' => [
                    [
                        'name' => 'Computer Network Engineering (TKJ)',
                        'icon' => 'server',
                        'desc' => 'Comprehensive Cisco networking, fiber optics, server administration, and cloud operations.'
                    ],
                    [
                        'name' => 'Digital Broadcasting & Media',
                        'icon' => 'video',
                        'desc' => 'Mastery in audio-visual broadcasting, streaming technology, and digital media production.'
                    ]
                ]
            ],
            [
                'id' => 'smk-raden-umar-said',
                'numeric_id' => 3,
                'name' => 'SMK Raden Umar Said',
                'verified' => true,
                'category_badge' => 'Vocational High School',
                'location' => 'Kudus, Central Java',
                'location_full' => 'Kudus, Central Java, Indonesia',
                'province' => 'Central Java',
                'tags' => ['3D Animation', 'RPL'],
                'status_badge' => 'Center of Excellence',
                'status_badge_type' => 'purple',
                'image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1000&q=80',
                'logo_bg_class' => 'bg-purple-700',
                'logo_text' => 'RUS',
                'website' => 'https://smkrus.sch.id',
                'email' => 'hello@smkrus.sch.id',
                'map_link' => 'https://maps.google.com/?q=SMK+Raden+Umar+Said+Kudus',
                'about' => 'SMK Raden Umar Said (RUS) Kudus is a world-class animation and creative technology vocational school supported by Djarum Foundation. Equipped with Pixar-level animation pipelines and 3D software.',
                'mission' => 'Our mission is to cultivate international-caliber animators and software engineers, fostering artistic vision paired with cutting-edge technical execution.',
                'stats' => [
                    'placement_rate' => '95%',
                    'industry_partners' => '45+',
                    'active_students' => '980',
                    'modern_labs' => '12'
                ],
                'competencies' => [
                    [
                        'name' => '3D Animation & VFX',
                        'icon' => 'cube',
                        'desc' => 'Professional 3D modeling, character rigging, lighting, texturing, and digital visual effects.'
                    ],
                    [
                        'name' => 'Software Engineering (RPL)',
                        'icon' => 'code',
                        'desc' => 'Game development, interactive software programming, and mobile app design.'
                    ]
                ]
            ],
            [
                'id' => 'smk-negeri-1-teknologi-inovasi',
                'numeric_id' => 4,
                'name' => 'SMK Negeri 1 Teknologi Inovasi',
                'verified' => true,
                'category_badge' => 'Vocational High School',
                'location' => 'Bandung, West Java',
                'location_full' => 'Bandung, West Java, Indonesia',
                'province' => 'West Java',
                'tags' => ['RPL', 'TKJ', 'Cloud Computing'],
                'status_badge' => 'Verified',
                'status_badge_type' => 'green',
                'image' => 'https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?auto=format&fit=crop&w=1000&q=80',
                'logo_bg_class' => 'bg-blue-600',
                'logo_text' => 'SMK 1',
                'website' => 'https://smkn1teknologiinovasi.sch.id',
                'email' => 'info@techlink.id',
                'map_link' => 'https://maps.google.com/?q=Bandung+West+Java',
                'about' => 'SMK Negeri 1 Teknologi Inovasi is a leading vocational institution dedicated to bridging the gap between Indonesian education and the global IT industry. We focus on producing highly skilled graduates ready to face the challenges of modern software development, network infrastructure, and creative technology.',
                'mission' => 'Our mission is to build a culture of innovation, continuous learning, and practical problem-solving. Through strong industry partnerships and a curriculum aligned with global tech standards, we ensure our students are not only job-ready but future leaders in the tech ecosystem.',
                'stats' => [
                    'placement_rate' => '85%',
                    'industry_partners' => '50+',
                    'active_students' => '1200',
                    'modern_labs' => '15'
                ],
                'competencies' => [
                    [
                        'name' => 'Software Engineering (RPL)',
                        'icon' => 'code',
                        'desc' => 'Focused on software engineering, web development, mobile app creation, and modern programming paradigms.'
                    ],
                    [
                        'name' => 'Computer Network Engineering (TKJ)',
                        'icon' => 'server',
                        'desc' => 'Covers network infrastructure, cloud computing, cybersecurity, and system administration.'
                    ]
                ]
            ],
            [
                'id' => 'smk-negeri-1-denpasar',
                'numeric_id' => 7,
                'name' => 'SMK Negeri 1 Denpasar',
                'verified' => true,
                'category_badge' => 'Vocational High School',
                'location' => 'Denpasar, Bali',
                'location_full' => 'Denpasar, Bali, Indonesia',
                'province' => 'Bali',
                'tags' => ['RPL', 'TKJ', 'Multimedia'],
                'status_badge' => 'Enrollment Open',
                'status_badge_type' => 'green',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1000&q=80',
                'logo_bg_class' => 'bg-teal-700',
                'logo_text' => 'SMK 1 DPN',
                'website' => 'https://smkn1denpasar.sch.id',
                'email' => 'info@smkn1denpasar.sch.id',
                'map_link' => 'https://maps.google.com/?q=SMK+Negeri+1+Denpasar',
                'about' => 'SMK Negeri 1 Denpasar adalah pusat keunggulan pendidikan vokasi teknologi informasi terdepan di Provinsi Bali. Menghasilkan lulusan yang menguasai rekayasa perangkat lunak, sistem jaringan, dan teknologi digital terkini.',
                'mission' => 'Mencetak sumber daya manusia unggul yang kreatif, kompeten di bidang teknologi digital, serta mampu bersaing di tingkat nasional maupun internasional.',
                'stats' => [
                    'placement_rate' => '87%',
                    'industry_partners' => '40+',
                    'active_students' => '1350',
                    'modern_labs' => '14'
                ],
                'competencies' => [
                    [
                        'name' => 'Rekayasa Perangkat Lunak (RPL)',
                        'icon' => 'code',
                        'desc' => 'Pengembangan aplikasi web, pemrograman mobile Android/iOS, serta arsitektur basis data.'
                    ],
                    [
                        'name' => 'Teknik Komputer dan Jaringan (TKJ)',
                        'icon' => 'server',
                        'desc' => 'Administrasi server, administrasi jaringan mikrotik & cisco, dan teknologi cloud.'
                    ]
                ]
            ],
            [
                'id' => 'smk-telkom-medan',
                'numeric_id' => 8,
                'name' => 'SMK Telkom Medan',
                'verified' => true,
                'category_badge' => 'Vocational High School',
                'location' => 'Medan, North Sumatra',
                'location_full' => 'Medan, North Sumatra, Indonesia',
                'province' => 'Sumatera Utara',
                'tags' => ['TKJ', 'RPL', 'Broadcasting'],
                'status_badge' => 'Center of Excellence',
                'status_badge_type' => 'purple',
                'image' => 'https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?auto=format&fit=crop&w=1000&q=80',
                'logo_bg_class' => 'bg-red-600',
                'logo_text' => 'TELKOM MDN',
                'website' => 'https://smktelkom-mdn.sch.id',
                'email' => 'info@smktelkom-mdn.sch.id',
                'map_link' => 'https://maps.google.com/?q=SMK+Telkom+Medan',
                'about' => 'SMK Telkom Medan merupakan sekolah vokasi IT rujukan di Sumatera Utara dengan spesialisasi jaringan telekomunikasi, pemrograman web enterprise, dan media digital.',
                'mission' => 'Membangun generasi muda Indonesia Barat yang berdaya saing global melalui pendidikan berbasis industri IT terkini.',
                'stats' => [
                    'placement_rate' => '91%',
                    'industry_partners' => '60+',
                    'active_students' => '1400',
                    'modern_labs' => '16'
                ],
                'competencies' => [
                    [
                        'name' => 'Teknik Komputer dan Jaringan (TKJ)',
                        'icon' => 'server',
                        'desc' => 'Jaringan komputer terdistribusi, serat optik, dan manajemen infrastruktur data.'
                    ],
                    [
                        'name' => 'Rekayasa Perangkat Lunak (RPL)',
                        'icon' => 'code',
                        'desc' => 'Pemrograman aplikasi berbasis web modern dan teknologi cloud.'
                    ]
                ]
            ],
            [
                'id' => 'smk-negeri-2-makassar',
                'numeric_id' => 9,
                'name' => 'SMK Negeri 2 Makassar',
                'verified' => true,
                'category_badge' => 'Vocational High School',
                'location' => 'Makassar, South Sulawesi',
                'location_full' => 'Makassar, South Sulawesi, Indonesia',
                'province' => 'Sulawesi Selatan',
                'tags' => ['RPL', 'TKJ', 'SIJA'],
                'status_badge' => 'Teaching Factory',
                'status_badge_type' => 'gray',
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1000&q=80',
                'logo_bg_class' => 'bg-sky-700',
                'logo_text' => 'SMK 2 MKS',
                'website' => 'https://smkn2makassar.sch.id',
                'email' => 'contact@smkn2makassar.sch.id',
                'map_link' => 'https://maps.google.com/?q=SMK+Negeri+2+Makassar',
                'about' => 'SMK Negeri 2 Makassar adalah sekolah vokasi terkemuka di Sulawesi Selatan dengan fokus pada Sistem Informasi, Jaringan, dan Aplikasi (SIJA) serta pengembangan perangkat lunak.',
                'mission' => 'Menjadi pusat diklat vokasi teknologi informasi unggulan di Indonesia Timur.',
                'stats' => [
                    'placement_rate' => '86%',
                    'industry_partners' => '35+',
                    'active_students' => '1250',
                    'modern_labs' => '14'
                ],
                'competencies' => [
                    [
                        'name' => 'SIJA (Sistem Informasi, Jaringan, & Aplikasi)',
                        'icon' => 'server',
                        'desc' => 'Program 4 tahun penguasaan cloud computing, DevOps, dan keamanan sistem.'
                    ],
                    [
                        'name' => 'Rekayasa Perangkat Lunak (RPL)',
                        'icon' => 'code',
                        'desc' => 'Pengembangan perangkat lunak skala UKM dan aplikasi industri modern.'
                    ]
                ]
            ],
            [
                'id' => 'smk-negeri-1-yogyakarta',
                'numeric_id' => 10,
                'name' => 'SMK Negeri 1 Yogyakarta',
                'verified' => true,
                'category_badge' => 'Vocational High School',
                'location' => 'Yogyakarta, DI Yogyakarta',
                'location_full' => 'Yogyakarta, DI Yogyakarta, Indonesia',
                'province' => 'DI Yogyakarta',
                'tags' => ['RPL', 'Multimedia', 'Animation'],
                'status_badge' => 'Center of Excellence',
                'status_badge_type' => 'purple',
                'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=1000&q=80',
                'logo_bg_class' => 'bg-violet-600',
                'logo_text' => 'SMK 1 YOG',
                'website' => 'https://smkn1jogja.sch.id',
                'email' => 'info@smkn1jogja.sch.id',
                'map_link' => 'https://maps.google.com/?q=SMK+Negeri+1+Yogyakarta',
                'about' => 'SMK Negeri 1 Yogyakarta berlokasi di pusat kota budaya Yogyakarta, melahirkan talenta digital di bidang rekayasa perangkat lunak, multimedia, dan desain game interaktif.',
                'mission' => 'Mengintegrasikan kearifan lokal dengan inovasi teknologi informasi berstandar dunia.',
                'stats' => [
                    'placement_rate' => '94%',
                    'industry_partners' => '55+',
                    'active_students' => '1100',
                    'modern_labs' => '15'
                ],
                'competencies' => [
                    [
                        'name' => 'Rekayasa Perangkat Lunak (RPL)',
                        'icon' => 'code',
                        'desc' => 'Pengembangan aplikasi bisnis, UI/UX design, dan teknologi front-end/back-end.'
                    ],
                    [
                        'name' => 'Multimedia & Animasi',
                        'icon' => 'palette',
                        'desc' => 'Desain grafis, produksi video digital, dan animasi 2D/3D.'
                    ]
                ]
            ],
            [
                'id' => 'smk-telkom-banjarbaru',
                'numeric_id' => 11,
                'name' => 'SMK Telkom Banjarbaru',
                'verified' => true,
                'category_badge' => 'Vocational High School',
                'location' => 'Banjarbaru, South Kalimantan',
                'location_full' => 'Banjarbaru, South Kalimantan, Indonesia',
                'province' => 'Kalimantan Selatan',
                'tags' => ['TKJ', 'RPL', 'Broadcasting'],
                'status_badge' => 'Enrollment Open',
                'status_badge_type' => 'green',
                'image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1000&q=80',
                'logo_bg_class' => 'bg-rose-600',
                'logo_text' => 'TELKOM BJB',
                'website' => 'https://smktelkom-bjb.sch.id',
                'email' => 'info@smktelkom-bjb.sch.id',
                'map_link' => 'https://maps.google.com/?q=SMK+Telkom+Banjarbaru',
                'about' => 'SMK Telkom Banjarbaru adalah pelopor sekolah vokasi berbasis IT dan telekomunikasi di Kalimantan Selatan dengan laboratorium komputer berstandar industri.',
                'mission' => 'Menghadirkan pendidikan IT berkualitas prima untuk mendukung transformasi digital Kalimantan.',
                'stats' => [
                    'placement_rate' => '89%',
                    'industry_partners' => '42+',
                    'active_students' => '950',
                    'modern_labs' => '12'
                ],
                'competencies' => [
                    [
                        'name' => 'Teknik Komputer & Jaringan (TKJ)',
                        'icon' => 'server',
                        'desc' => 'Manajemen jaringan komputer, sistem operasi server, dan serat optik.'
                    ],
                    [
                        'name' => 'Rekayasa Perangkat Lunak (RPL)',
                        'icon' => 'code',
                        'desc' => 'Pemrograman web modern, basis data relational, dan aplikasi mobile.'
                    ]
                ]
            ],
            [
                'id' => 'smk-negeri-1-jayapura',
                'numeric_id' => 12,
                'name' => 'SMK Negeri 1 Jayapura',
                'verified' => true,
                'category_badge' => 'Vocational High School',
                'location' => 'Jayapura, Papua',
                'location_full' => 'Jayapura, Papua, Indonesia',
                'province' => 'Papua',
                'tags' => ['TKJ', 'RPL', 'Multimedia'],
                'status_badge' => 'Enrollment Open',
                'status_badge_type' => 'green',
                'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1000&q=80',
                'logo_bg_class' => 'bg-emerald-600',
                'logo_text' => 'SMK 1 JPR',
                'website' => 'https://smkn1jayapura.sch.id',
                'email' => 'info@smkn1jayapura.sch.id',
                'map_link' => 'https://maps.google.com/?q=SMK+Negeri+1+Jayapura',
                'about' => 'SMK Negeri 1 Jayapura merupakan sekolah vokasi IT unggulan di Provinsi Papua yang berkomitmen mencetak teknisi jaringan komputer dan pengembang aplikasi handal.',
                'mission' => 'Mencetak SDM digital Papua yang tangguh, mahir teknologi, dan siap memajukan ekosistem IT tanah Papua.',
                'stats' => [
                    'placement_rate' => '85%',
                    'industry_partners' => '30+',
                    'active_students' => '850',
                    'modern_labs' => '10'
                ],
                'competencies' => [
                    [
                        'name' => 'Teknik Komputer & Jaringan (TKJ)',
                        'icon' => 'server',
                        'desc' => 'Dasar infrastruktur internet, administrasi jaringan lokal & nirkabel.'
                    ],
                    [
                        'name' => 'Rekayasa Perangkat Lunak (RPL)',
                        'icon' => 'code',
                        'desc' => 'Pemrograman dasar, pembuatan situs web, dan aplikasi perkantoran.'
                    ]
                ]
            ]
        ];
    }

    public function index()
    {
        $schools = $this->getSchoolsData();
        return view('education.index', compact('schools'));
    }

    public function show($id)
    {
        $schools = $this->getSchoolsData();
        
        // Find school by slug id or numeric id
        $school = collect($schools)->first(function ($s) use ($id) {
            return $s['id'] === $id || (string)$s['numeric_id'] === (string)$id;
        });

        if (!$school) {
            // Default to school 4 (SMK Negeri 1 Teknologi Inovasi) if not found
            $school = $schools[3];
        }

        return view('education.show', compact('school'));
    }
}
