<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampusController extends Controller
{
    private function getCampusesData()
    {
        return [
            [
                'id' => 'ui-ac-kampus',
                'numeric_id' => 1,
                'name' => 'Universitas Indonesia (UI)',
                'verified' => true,
                'category_badge' => 'Public University',
                'location' => 'Depok, West Java',
                'location_full' => 'Depok, West Java, Indonesia',
                'province' => 'West Java',
                'faculty' => 'Fakultas Ilmu Komputer (FICC)',
                'tags' => ['Computer Science', 'Information Systems', 'Data Science'],
                'status_badge' => 'Center of Excellence',
                'status_badge_type' => 'purple',
                'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1000&q=80',
                'logo_bg_class' => 'bg-indigo-600',
                'logo_text' => 'UI',
                'website' => 'https://ui.ac.id',
                'email' => 'humas-ui@ui.ac.id',
                'map_link' => 'https://maps.google.com/?q=Universitas+Indonesia+Depok',
                'about' => 'Universitas Indonesia (UI) is Indonesia\'s premier national university, consistently ranked as the top university in the country. Its Faculty of Computer Science (FICC) is recognized for excellence in computer science, information systems, and data science education, producing graduates who are highly competitive globally.',
                'mission' => 'To be a leading world-class university that produces excellent, noble, and characterful graduates and contributes to sustainable national and global development through superior education, research, and community service.',
                'stats' => [
                    'national_ranking' => '#1',
                    'it_programs' => '12',
                    'active_students' => '28,500',
                    'research_centers' => '35+'
                ],
                'competencies' => [
                    [
                        'name' => 'Computer Science (Ilmu Komputer)',
                        'icon' => 'code',
                        'desc' => 'Focuses on software engineering, artificial intelligence, algorithms, and computational theory.'
                    ],
                    [
                        'name' => 'Information Systems (Sistem Informasi)',
                        'icon' => 'server',
                        'desc' => 'Covers enterprise systems, business analytics, and IT strategy and management.'
                    ]
                ]
            ],
            [
                'id' => 'binus-kampus',
                'numeric_id' => 2,
                'name' => 'BINUS University',
                'verified' => true,
                'category_badge' => 'Private University',
                'location' => 'Jakarta, DKI Jakarta',
                'location_full' => 'Jakarta, DKI Jakarta, Indonesia',
                'province' => 'DKI Jakarta',
                'faculty' => 'School of Computer Science',
                'tags' => ['Software Engineering', 'Data Science', 'Cybersecurity'],
                'status_badge' => 'Enrollment Open',
                'status_badge_type' => 'green',
                'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=1000&q=80',
                'logo_bg_class' => 'bg-red-600',
                'logo_text' => 'BINUS',
                'website' => 'https://binus.edu',
                'email' => 'admission@binus.edu',
                'map_link' => 'https://maps.google.com/?q=BINUS+University+Jakarta',
                'about' => 'BINUS University is a leading Indonesian private university with a strong reputation in computer science and information technology education. Its School of Computer Science offers internationally recognized, industry-aligned programs.',
                'mission' => 'To become a leading private university in Indonesia that produces graduates with noble character, excellent competence, and strong entrepreneurial spirit, ready to compete globally.',
                'stats' => [
                    'national_ranking' => '#6',
                    'it_programs' => '9',
                    'active_students' => '12,300',
                    'international_partners' => '260+'
                ],
                'competencies' => [
                    [
                        'name' => 'Software Engineering (S1/Informatics)',
                        'icon' => 'code',
                        'desc' => 'Covers software development lifecycle, programming paradigms, and enterprise application design.'
                    ],
                    [
                        'name' => 'Data Science & Cybersecurity',
                        'icon' => 'server',
                        'desc' => 'Specializations in data analytics, machine learning, and information security.'
                    ]
                ]
            ],
            [
                'id' => 'itb-kampus',
                'numeric_id' => 3,
                'name' => 'Institut Teknologi Bandung (ITB)',
                'verified' => true,
                'category_badge' => 'Public University',
                'location' => 'Bandung, West Java',
                'location_full' => 'Bandung, West Java, Indonesia',
                'province' => 'West Java',
                'faculty' => 'School of Computing',
                'tags' => ['Computer Science', 'Information Engineering'],
                'status_badge' => 'Verified',
                'status_badge_type' => 'green',
                'image' => 'https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?auto=format&fit=crop&w=1000&q=80',
                'logo_bg_class' => 'bg-cyan-700',
                'logo_text' => 'ITB',
                'website' => 'https://itb.ac.id',
                'email' => 'humas@itb.ac.id',
                'map_link' => 'https://maps.google.com/?q=Institut+Teknologi+Bandung',
                'about' => 'Institut Teknologi Bandung (ITB) is one of Indonesia\'s leading institutes of technology. Its School of Computing offers rigorous programs in computer science and information systems with strong research output.',
                'mission' => 'To become a world-class university of technology that creates innovative science and technology for humanity.',
                'stats' => [
                    'national_ranking' => '#2',
                    'it_programs' => '8',
                    'active_students' => '24,800',
                    'research_output' => 'Top 1%'
                ],
                'competencies' => [
                    [
                        'name' => 'Computer Science & Information Systems',
                        'icon' => 'code',
                        'desc' => 'Program covers software engineering, artificial intelligence, data engineering, and computational systems.'
                    ],
                    [
                        'name' => 'Information Engineering',
                        'icon' => 'server',
                        'desc' => 'Focuses on network systems, telecommunications, and digital infrastructure.'
                    ]
                ]
            ],
            [
                'id' => 'ugm-kampus',
                'numeric_id' => 4,
                'name' => 'Universitas Gadjah Mada (UGM)',
                'verified' => true,
                'category_badge' => 'Public University',
                'location' => 'Yogyakarta, DI Yogyakarta',
                'location_full' => 'Yogyakarta, DI Yogyakarta, Indonesia',
                'province' => 'DI Yogyakarta',
                'faculty' => 'Faculty of Computer Science and Information Systems',
                'tags' => ['Informatics', 'Information Systems', 'GIS'],
                'status_badge' => 'Center of Excellence',
                'status_badge_type' => 'purple',
                'image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1000&q=80',
                'logo_bg_class' => 'bg-amber-600',
                'logo_text' => 'UGM',
                'website' => 'https://ugm.ac.id',
                'email' => 'humas@ugm.ac.id',
                'map_link' => 'https://maps.google.com/?q=UGM+Yogyakarta',
                'about' => 'Universitas Gadjah Mada (UGM) is a leading public research university in Yogyakarta. Its Faculty of Computer Science and Information Systems offers programs focused on informatics, information systems, and geospatial information technology.',
                'mission' => 'To become a leading world-class university that produces excellent, noble graduates and contributes to the development of science and technology for humanity.',
                'stats' => [
                    'national_ranking' => '#3',
                    'it_programs' => '7',
                    'active_students' => '21,700',
                    'international_ranking' => 'Top 400'
                ],
                'competencies' => [
                    [
                        'name' => 'Informatics Engineering (Teknik Informatika)',
                        'icon' => 'code',
                        'desc' => 'Software engineering, data structures, algorithms, and artificial intelligence.'
                    ],
                    [
                        'name' => 'Information Systems (Sistem Informasi)',
                        'icon' => 'server',
                        'desc' => 'Enterprise systems, information architecture, and business process management.'
                    ]
                ]
            ],
            [
                'id' => 'ipb-kampus',
                'numeric_id' => 5,
                'name' => 'Institut Pertanian Bogor (IPB)',
                'verified' => true,
                'category_badge' => 'Public University',
                'location' => 'Bogor, West Java',
                'location_full' => 'Bogor, West Java, Indonesia',
                'province' => 'West Java',
                'faculty' => 'Faculty of Computer Science and Systems Engineering',
                'tags' => ['Computational Science', 'Agricultural IT', 'Data Analytics'],
                'status_badge' => 'Enrollment Open',
                'status_badge_type' => 'green',
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1000&q=80',
                'logo_bg_class' => 'bg-lime-700',
                'logo_text' => 'IPB',
                'website' => 'https://ipb.ac.id',
                'email' => 'humas@ipb.ac.id',
                'map_link' => 'https://maps.google.com/?q=Institut+Pertanian+Bogor',
                'about' => 'Institut Pertanian Bogor (IPB) is a renowned public university. Its Faculty of Computer Science and Systems Engineering offers programs in computational science, data analytics, and agricultural technology integration.',
                'mission' => 'To become a leading university in science, technology, and agriculture through excellent education, research, and community service.',
                'stats' => [
                    'national_ranking' => '#5',
                    'it_programs' => '6',
                    'active_students' => '19,600',
                    'agritech_focus' => 'Top 10 Asia'
                ],
                'competencies' => [
                    [
                        'name' => 'Computer Science & Information Systems',
                        'icon' => 'code',
                        'desc' => 'Software engineering, computational modeling, and data science for agriculture and industry.'
                    ],
                    [
                        'name' => 'Information Technology',
                        'icon' => 'server',
                        'desc' => 'IT infrastructure, information systems, and digital transformation in agriculture.'
                    ]
                ]
            ],
            [
                'id' => 'undip-kampus',
                'numeric_id' => 6,
                'name' => 'Universitas Diponegoro (UNDIP)',
                'verified' => true,
                'category_badge' => 'Public University',
                'location' => 'Semarang, Central Java',
                'location_full' => 'Semarang, Central Java, Indonesia',
                'province' => 'Central Java',
                'faculty' => 'Faculty of Engineering and Computer Science',
                'tags' => ['Informatics', 'Information Systems'],
                'status_badge' => 'Enrollment Open',
                'status_badge_type' => 'green',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1000&q=80',
                'logo_bg_class' => 'bg-blue-700',
                'logo_text' => 'UNDIP',
                'website' => 'https://undip.ac.id',
                'email' => 'humas@undip.ac.id',
                'map_link' => 'https://maps.google.com/?q=Universitas+Diponegoro',
                'about' => 'Universitas Diponegoro (UNDIP) is a leading public university in Central Java. Its Faculty of Engineering offers strong programs in computer science and information systems with industry partnerships.',
                'mission' => 'To become a leading, independent, and credible university based on science and technology in the Asian region.',
                'stats' => [
                    'national_ranking' => '#7',
                    'it_programs' => '5',
                    'active_students' => '15,200',
                    'community_engagement' => 'High'
                ],
                'competencies' => [
                    [
                        'name' => 'Information Engineering',
                        'icon' => 'code',
                        'desc' => 'Software development, information systems, and digital technology innovation.'
                    ]
                ]
            ]
        ];
    }

    public function index()
    {
        $campuses = $this->getCampusesData();
        return view('education.campus.index', compact('campuses'));
    }

    public function show($id)
    {
        $campuses = $this->getCampusesData();

        $campus = collect($campuses)->first(function ($c) use ($id) {
            return $c['id'] === $id || (string)$c['numeric_id'] === (string)$id;
        });

        if (!$campus) {
            $campus = $campuses[0];
        }

        return view('education.campus.show', compact('campus'));
    }
}
