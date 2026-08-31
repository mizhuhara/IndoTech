<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = collect($this->getEvents());

        // Category pill filter
        $category = $request->query('category', 'all');
        if ($category !== 'all') {
            $events = $events->filter(function ($event) use ($category) {
                return strtolower($event['category']) === strtolower($category);
            });
        }

        // Search Keyword
        if ($request->filled('q')) {
            $q = strtolower($request->query('q'));
            $events = $events->filter(function ($event) use ($q) {
                return str_contains(strtolower($event['title']), $q)
                    || str_contains(strtolower($event['organizer']), $q)
                    || str_contains(strtolower($event['location']), $q);
            });
        }

        // Location Filter
        if ($request->filled('location')) {
            $locations = (array) $request->query('location');
            $events = $events->filter(function ($event) use ($locations) {
                foreach ($locations as $loc) {
                    if (str_contains(strtolower($event['location']), strtolower($loc))) {
                        return true;
                    }
                }

                return false;
            });
        }

        // Price Filter
        if ($request->filled('price')) {
            $prices = (array) $request->query('price');
            $events = $events->filter(function ($event) use ($prices) {
                $isFree = strtolower($event['price']) === 'free';
                if (in_array('Free', $prices) && $isFree) {
                    return true;
                }
                if (in_array('Paid', $prices) && ! $isFree) {
                    return true;
                }

                return false;
            });
        }

        // Organizer Type Filter
        if ($request->filled('organizer_type')) {
            $orgTypes = (array) $request->query('organizer_type');
            $events = $events->filter(function ($event) use ($orgTypes) {
                return in_array($event['organizer_type'], $orgTypes);
            });
        }

        $categories = [
            'All', 'Seminar', 'Workshop', 'Webinar', 'Hackathon',
            'Competition', 'Job Fair', 'Tech Meetup', 'Conference', 'Training',
        ];

        // Pagination setup
        $perPage = 3;
        $totalItems = $events->count();
        $totalPages = max(1, (int) ceil($totalItems / $perPage));
        if ($totalPages < 3 && ! $request->filled('q') && ! $request->filled('location') && ! $request->filled('price') && ! $request->filled('organizer_type')) {
            $totalPages = 3;
        }

        $currentPage = max(1, min((int) $request->query('page', 1), $totalPages));

        $paginatedEvents = $events->slice(($currentPage - 1) * $perPage, $perPage)->values()->all();
        if (empty($paginatedEvents) && count($events) > 0) {
            $paginatedEvents = $events->take($perPage)->values()->all();
        }

        return view('event.index', [
            'events' => $paginatedEvents,
            'categories' => $categories,
            'activeCategory' => $category,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    public function show($id)
    {
        $events = collect($this->getEvents());
        $event = $events->firstWhere('id', (int) $id);

        if (! $event) {
            // Default fallback to ID 6 matching Figma detail design
            $event = $events->firstWhere('id', 6);
        }

        return view('event.show', [
            'event' => $event,
        ]);
    }

    private function getEvents(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Indonesia Tech Summit 2024: AI & The Future',
                'category' => 'Conference',
                'category_tag' => 'CONFERENCE',
                'mode' => 'Online',
                'mode_color' => 'bg-emerald-500',
                'price' => 'Free',
                'organizer' => 'TechLink Hub',
                'organizer_type' => 'Tech Company',
                'date' => 'Oct 15, 2024 • 09:00 AM WIB',
                'short_date' => 'Oct 15, 2024',
                'full_date' => 'Tuesday, October 15, 2024',
                'time' => '09:00 - 15:00 (WIB)',
                'location' => 'Online Webinar',
                'is_verified' => true,
                'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&h=500&fit=crop',
                'description' => 'Connect with industry leaders, AI pioneers, and tech innovators across Indonesia to discuss the future of AI and software engineering.',
                'what_you_will_learn' => [
                    'The state of AI and Machine Learning adoption in SEA.',
                    'Building scalable AI-powered microservices.',
                    'Best practices for enterprise security and ethics in AI.',
                    'Networking with top tech leads and CTOs.',
                ],
                'speakers' => [
                    [
                        'name' => 'Budi Santoso',
                        'role' => 'Senior AI Researcher at Gojek',
                        'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=120&h=120&fit=crop',
                    ],
                    [
                        'name' => 'Siti Rahma',
                        'role' => 'Lead Data Scientist at Tokopedia',
                        'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=120&h=120&fit=crop',
                    ],
                ],
                'quota' => 85,
                'total_quota' => 100,
            ],
            [
                'id' => 2,
                'title' => 'Fullstack Development Bootcamp Preview',
                'category' => 'Workshop',
                'category_tag' => 'WORKSHOP',
                'mode' => 'In-Person',
                'mode_color' => 'bg-amber-600',
                'price' => 'Rp 150.000',
                'organizer' => 'CodeCamp ID',
                'organizer_type' => 'Community',
                'date' => 'Oct 18, 2024 • 13:00 PM WIB',
                'short_date' => 'Oct 18, 2024',
                'full_date' => 'Friday, October 18, 2024',
                'time' => '13:00 - 17:00 (WIB)',
                'location' => 'CoHive SCBD, Jakarta',
                'is_verified' => true,
                'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=500&fit=crop',
                'description' => 'A hands-on preview session of our fullstack engineering curriculum covering Laravel, React, and DevOps deployment basics.',
                'what_you_will_learn' => [
                    'Fullstack architecture setup from scratch.',
                    'RESTful API creation with Laravel.',
                    'Frontend integration with React & Vite.',
                    'Deployment workflows to cloud VPS.',
                ],
                'speakers' => [
                    [
                        'name' => 'Aditya Pratama',
                        'role' => 'Principal Engineer at CodeCamp ID',
                        'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=120&h=120&fit=crop',
                    ],
                ],
                'quota' => 42,
                'total_quota' => 50,
            ],
            [
                'id' => 3,
                'title' => 'Nusantara FinTech Hack 2024',
                'category' => 'Hackathon',
                'category_tag' => 'HACKATHON',
                'mode' => 'Hybrid',
                'mode_color' => 'bg-indigo-600',
                'price' => 'Free',
                'organizer' => 'Bank Indo & TechLink',
                'organizer_type' => 'Tech Company',
                'date' => 'Oct 20-22, 2024',
                'short_date' => 'Oct 20-22, 2024',
                'full_date' => 'October 20-22, 2024',
                'time' => '09:00 - 21:00 (WIB)',
                'location' => 'Bandung & Remote',
                'is_verified' => true,
                'image' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=800&h=500&fit=crop',
                'description' => '48-hour nationwide fintech hackathon solving financial inclusion, open banking APIs, and digital payment challenges in Indonesia.',
                'what_you_will_learn' => [
                    'Integrating Open Banking APIs.',
                    'Rapid prototyping under 48 hours.',
                    'Pitching solutions to fintech VC investors.',
                ],
                'speakers' => [
                    [
                        'name' => 'Rizky Kurnia',
                        'role' => 'Head of Innovation at Bank Indo',
                        'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=120&h=120&fit=crop',
                    ],
                ],
                'quota' => 120,
                'total_quota' => 200,
            ],
            [
                'id' => 4,
                'title' => 'Mastering UI/UX for Enterprise SaaS',
                'category' => 'Webinar',
                'category_tag' => 'WEBINAR',
                'mode' => 'Online',
                'mode_color' => 'bg-emerald-500',
                'price' => 'Free',
                'organizer' => 'Design Association',
                'organizer_type' => 'Community',
                'date' => 'Oct 25, 2024 • 19:00 PM WIB',
                'short_date' => 'Oct 25, 2024',
                'full_date' => 'Friday, October 25, 2024',
                'time' => '19:00 - 21:00 (WIB)',
                'location' => 'Zoom Online',
                'is_verified' => true,
                'image' => 'https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?w=800&h=500&fit=crop',
                'description' => 'Learn design systems, complex data table layouts, and dashboard UX patterns tailored for high-density enterprise SaaS applications.',
                'what_you_will_learn' => [
                    'Designing scalable Figma design systems.',
                    'Data visualization and complex dashboard UX.',
                    'User research methods for B2B SaaS.',
                ],
                'speakers' => [
                    [
                        'name' => 'Dewi Anggraini',
                        'role' => 'Lead Product Designer at Traveloka',
                        'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=120&h=120&fit=crop',
                    ],
                ],
                'quota' => 180,
                'total_quota' => 250,
            ],
            [
                'id' => 5,
                'title' => 'TechLink Global Talent Expo',
                'category' => 'Job Fair',
                'category_tag' => 'JOB FAIR',
                'mode' => 'In-Person',
                'mode_color' => 'bg-amber-600',
                'price' => 'Free',
                'organizer' => 'Ministry of Tech',
                'organizer_type' => 'University',
                'date' => 'Nov 01-02, 2024',
                'short_date' => 'Nov 01-02, 2024',
                'full_date' => 'November 01-02, 2024',
                'time' => '09:00 - 17:00 (WIB)',
                'location' => 'JCC Senayan, Jakarta',
                'is_verified' => true,
                'image' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&h=500&fit=crop',
                'description' => 'Indonesia’s largest tech job fair featuring 100+ hiring tech companies, startup pitch stages, and on-site interview sessions.',
                'what_you_will_learn' => [
                    'Direct hiring interviews with tech recruiters.',
                    'Resume review sessions with engineering managers.',
                    'Career guidance keynotes.',
                ],
                'speakers' => [
                    [
                        'name' => 'Hendra Wijaya',
                        'role' => 'Director of Talent Acquisition at Ministry of Tech',
                        'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=120&h=120&fit=crop',
                    ],
                ],
                'quota' => 450,
                'total_quota' => 500,
            ],
            [
                'id' => 6,
                'title' => 'Modern Web Development Workshop: React & Next.js',
                'category' => 'Workshop',
                'category_tag' => 'WORKSHOP',
                'mode' => 'In-Person',
                'mode_color' => 'bg-amber-600',
                'price' => 'Free',
                'organizer' => 'TechLink Academy',
                'organizer_type' => 'Tech Company',
                'date' => 'Oct 28, 2024 • 09:00 - 16:00 WIB',
                'short_date' => 'Oct 28, 2024',
                'full_date' => 'Saturday, October 28, 2024',
                'time' => '09:00 - 16:00 (WIB)',
                'location' => 'TechLink HQ, South Jakarta',
                'is_verified' => true,
                'image' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=1200&h=600&fit=crop',
                'description' => 'Join this intensive, hands-on workshop designed to elevate your front-end development skills. This session focuses on modern web architecture using React and Next.js, bridging the gap between theoretical knowledge and industry-standard practices.'."\n\n".'Whether you\'re a vocational student looking to enter the tech industry or a junior developer looking to refine your skills, this workshop provides practical insights and hands-on coding experience.',
                'what_you_will_learn' => [
                    'Component-based architecture and state management in React.',
                    'Server-side rendering and static site generation with Next.js.',
                    'Integrating Tailwind CSS for rapid responsive UI development.',
                    'Best practices for performance optimization and accessibility.',
                ],
                'speakers' => [
                    [
                        'name' => 'Budi Santoso',
                        'role' => 'Senior Frontend Engineer at Gojek',
                        'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=120&h=120&fit=crop',
                    ],
                    [
                        'name' => 'Siti Rahma',
                        'role' => 'Lead Developer at Tokopedia',
                        'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=120&h=120&fit=crop',
                    ],
                ],
                'quota' => 50,
                'total_quota' => 100,
            ],
        ];
    }
}
