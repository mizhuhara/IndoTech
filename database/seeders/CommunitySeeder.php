<?php

namespace Database\Seeders;

use App\Models\Community;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    public function run(): void
    {
        $communities = [
            [
                'name' => 'Web Developer Indonesia',
                'category' => 'Technology',
                'members' => 12500,
                'status' => 'active',
                'description' => 'Komunitas untuk para web developer di seluruh Indonesia saling berbagi ilmu, pengalaman, dan lowongan kerja terkait pengembangan web.',
                'website' => 'https://webdev-id.org',
                'email' => 'hello@webdev-id.org',
                'logo_url' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=120&h=120&q=80',
                'cover_url' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?auto=format&fit=crop&w=600&h=200&q=80',
                'tags' => ['Laravel', 'React', 'Vue', 'Node.js'],
            ],
            [
                'name' => 'Indo UI/UX Design',
                'category' => 'Design',
                'members' => 8400,
                'status' => 'active',
                'description' => 'Tempat berkumpulnya UI/UX Designer dari Indonesia untuk membahas tren desain, membagikan portofolio, dan mencari feedback dari sesama.',
                'website' => 'https://indouiux.com',
                'email' => 'contact@indouiux.com',
                'logo_url' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&w=120&h=120&q=80',
                'cover_url' => 'https://images.unsplash.com/photo-1558655146-364adaf1fcc9?auto=format&fit=crop&w=600&h=200&q=80',
                'tags' => ['Figma', 'Prototyping', 'Design System'],
            ],
            [
                'name' => 'Startup Founders Club',
                'category' => 'Business',
                'members' => 3200,
                'status' => 'active',
                'description' => 'Komunitas eksklusif bagi founder startup di Indonesia untuk networking, berbagi pengalaman fundraising, dan bimbingan bisnis.',
                'website' => 'https://startupfounders.id',
                'email' => 'join@startupfounders.id',
                'logo_url' => null,
                'cover_url' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=600&h=200&q=80',
                'tags' => ['Startup', 'Fundraising', 'Networking'],
            ],
            [
                'name' => 'Data Science Nusantara',
                'category' => 'Technology',
                'members' => 5600,
                'status' => 'active',
                'description' => 'Forum diskusi seputar Data Science, Machine Learning, dan Artificial Intelligence dengan studi kasus Indonesia.',
                'website' => 'https://datascience-nusantara.net',
                'email' => 'admin@datascience-nusantara.net',
                'logo_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=120&h=120&q=80',
                'cover_url' => 'https://images.unsplash.com/photo-1504639725590-34d0984388bd?auto=format&fit=crop&w=600&h=200&q=80',
                'tags' => ['Python', 'Machine Learning', 'AI', 'Data Analysis'],
            ],
            [
                'name' => 'Cybersecurity Indonesia',
                'category' => 'Technology',
                'members' => 4750,
                'status' => 'active',
                'description' => 'Komunitas keamanan siber Indonesia yang fokus pada penetration testing, ethical hacking, dan edukasi keamanan digital.',
                'website' => 'https://cybersec-id.net',
                'email' => 'info@cybersec-id.net',
                'logo_url' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=120&h=120&q=80',
                'cover_url' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=600&h=200&q=80',
                'tags' => ['Ethical Hacking', 'CTF', 'Security'],
            ],
            [
                'name' => 'Mobile Dev ID',
                'category' => 'Technology',
                'members' => 6900,
                'status' => 'active',
                'description' => 'Komunitas pengembang aplikasi mobile (Android & iOS) di Indonesia. Diskusi Flutter, React Native, Swift, dan Kotlin.',
                'website' => 'https://mobiledev.id',
                'email' => 'hello@mobiledev.id',
                'logo_url' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&fit=crop&w=120&h=120&q=80',
                'cover_url' => 'https://images.unsplash.com/photo-1565689157206-0fddef7589a2?auto=format&fit=crop&w=600&h=200&q=80',
                'tags' => ['Flutter', 'React Native', 'Android', 'iOS'],
            ],
            [
                'name' => 'Creative Indonesia',
                'category' => 'Design',
                'members' => 2800,
                'status' => 'active',
                'description' => 'Ruang kreatif bagi para desainer grafis, illustrator, dan kreator konten digital di Indonesia untuk berkolaborasi.',
                'website' => 'https://creative-indonesia.com',
                'email' => 'team@creative-indonesia.com',
                'logo_url' => 'https://images.unsplash.com/photo-1504639725590-34d0984388bd?auto=format&fit=crop&w=120&h=120&q=80',
                'cover_url' => 'https://images.unsplash.com/photo-1541960071727-c531398e7494?auto=format&fit=crop&w=600&h=200&q=80',
                'tags' => ['Illustration', 'Graphic Design', 'Content Creation'],
            ],
            [
                'name' => 'DevOps & Cloud Indonesia',
                'category' => 'Technology',
                'members' => 3900,
                'status' => 'active',
                'description' => 'Komunitas DevOps dan cloud engineering Indonesia untuk berbagi praktik terbaik CI/CD, Kubernetes, dan infrastruktur cloud.',
                'website' => 'https://devops-id.io',
                'email' => 'ops@devops-id.io',
                'logo_url' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=120&h=120&q=80',
                'cover_url' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=600&h=200&q=80',
                'tags' => ['Docker', 'Kubernetes', 'AWS', 'CI/CD'],
            ],
        ];

        foreach ($communities as $community) {
            Community::updateOrCreate(['name' => $community['name']], $community);
        }
    }
}
