<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminEventController extends Controller
{
    /**
     * Get all events with guaranteed default keys merged.
     *
     * @return array<int, array<string, mixed>>
     */
    private function getEventsData(): array
    {
        $defaults = $this->getDefaultEventsData();
        $sessionEvents = session('admin_events', []);

        if (empty($sessionEvents)) {
            return $defaults;
        }

        // Merge defaults to ensure no array key is missing for old session data
        $merged = [];
        foreach ($sessionEvents as $sEvent) {
            $defaultMatch = collect($defaults)->firstWhere('id', $sEvent['id']) ?? [];
            $merged[] = array_merge($defaultMatch, $sEvent);
        }

        return $merged;
    }

    /**
     * Display a listing of pending and managed event requests.
     */
    public function index(Request $request): View
    {
        $events = $this->getEventsData();

        $activeType = $request->query('type', 'all');
        $searchQuery = trim($request->query('q', ''));

        $filteredEvents = collect($events);

        // Filter by Type: School, University, Company
        if (! empty($activeType) && strtolower($activeType) !== 'all') {
            $filteredEvents = $filteredEvents->filter(function ($event) use ($activeType) {
                return strtolower($event['type']) === strtolower($activeType);
            });
        }

        // Search Filter by Event Name, Organizer, or Type
        if (! empty($searchQuery)) {
            $query = strtolower($searchQuery);
            $filteredEvents = $filteredEvents->filter(function ($event) use ($query) {
                return str_contains(strtolower($event['title']), $query)
                    || str_contains(strtolower($event['organizer']), $query)
                    || str_contains(strtolower($event['type']), $query);
            });
        }

        $totalEntries = $filteredEvents->count();
        $perPage = 10;
        $currentPage = max(1, (int) $request->query('page', 1));
        $totalPages = max(1, (int) ceil($totalEntries / $perPage));

        $paginatedEvents = $filteredEvents->slice(($currentPage - 1) * $perPage, $perPage)->values()->all();

        return view('admin.events.index', [
            'events' => $paginatedEvents,
            'activeType' => strtolower($activeType),
            'searchQuery' => $searchQuery,
            'totalEntries' => $totalEntries,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    /**
     * Display details of a specific event request.
     */
    public function show($id): View|RedirectResponse
    {
        $events = $this->getEventsData();

        $event = collect($events)->firstWhere('id', (int) $id);

        if (! $event) {
            return redirect()->route('admin.events.index')
                ->with('error', 'Event tidak ditemukan.');
        }

        return view('admin.events.show', [
            'event' => $event,
        ]);
    }

    /**
     * Approve an event request.
     */
    public function approve($id): RedirectResponse
    {
        $events = $this->getEventsData();
        $approvedName = '';

        foreach ($events as &$event) {
            if ((int) $event['id'] === (int) $id) {
                $event['status'] = 'Approved';
                $approvedName = $event['title'];
                break;
            }
        }

        session(['admin_events' => $events]);

        return redirect()->route('admin.events.index')
            ->with('success', "Event '{$approvedName}' telah berhasil disetujui (Approved).");
    }

    /**
     * Reject an event request.
     */
    public function reject($id): RedirectResponse
    {
        $events = $this->getEventsData();
        $rejectedName = '';

        foreach ($events as &$event) {
            if ((int) $event['id'] === (int) $id) {
                $event['status'] = 'Rejected';
                $rejectedName = $event['title'];
                break;
            }
        }

        session(['admin_events' => $events]);

        return redirect()->route('admin.events.index')
            ->with('success', "Event '{$rejectedName}' telah ditolak (Rejected).");
    }

    /**
     * Get default initial event requests matching screenshot reference.
     *
     * @return array<int, array<string, mixed>>
     */
    private function getDefaultEventsData(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Bali Tech Summit',
                'organizer' => 'TechNusa Corp',
                'type' => 'Company',
                'proposed_date' => 'Oct 15 - Oct 17, 2024',
                'status' => 'Pending',
                'category' => 'Conference & Summit',
                'location' => 'Bali International Convention Centre, Nusa Dua',
                'quota' => '500 Peserta',
                'contact_email' => 'contact@technusa.co.id',
                'contact_phone' => '+62 812-3456-7890',
                'description' => 'Konferensi teknologi berskala nasional yang mempertemukan para pemimpin industri teknologi, peneliti AI, pendiri startup, dan praktisi IT dari seluruh Indonesia untuk membahas tren teknologi terkini.',
            ],
            [
                'id' => 2,
                'title' => 'Vocational Career Fair',
                'organizer' => 'SMK Negeri 1 Jakarta',
                'type' => 'School',
                'proposed_date' => 'Nov 02, 2024',
                'status' => 'Pending',
                'category' => 'Job & Career Fair',
                'location' => 'Aula Utama SMKN 1 Jakarta Pusat',
                'quota' => '300 Peserta',
                'contact_email' => 'humas@smkn1jakarta.sch.id',
                'contact_phone' => '+62 811-9876-5432',
                'description' => 'Pameran bursa kerja dan peluang magang industri khusus bagi siswa dan alumni sekolah menengah kejuruan untuk berinteraksi langsung dengan mitra perusahaan teknologi.',
            ],
            [
                'id' => 3,
                'title' => 'University Coding Competition',
                'organizer' => 'ITB Student Council',
                'type' => 'University',
                'proposed_date' => 'Dec 10 - Dec 12, 2024',
                'status' => 'Pending',
                'category' => 'Hackathon & Competition',
                'location' => 'Aula Barat Institut Teknologi Bandung',
                'quota' => '150 Tim',
                'contact_email' => 'competition@kabinetitb.or.id',
                'contact_phone' => '+62 857-1122-3344',
                'description' => 'Kompetisi pemrograman dan algoritma tingkat mahasiswa se-Indonesia untuk menyelesaikan studi kasus nyata industri software engineering.',
            ],
            [
                'id' => 4,
                'title' => 'EdTech Founders Meetup',
                'organizer' => 'EduInnovate',
                'type' => 'Company',
                'proposed_date' => 'Jan 15, 2025',
                'status' => 'Pending',
                'category' => 'Community Meetup',
                'location' => 'CoHive SCBD, Jakarta Selatan',
                'quota' => '100 Peserta',
                'contact_email' => 'hello@eduinnovate.id',
                'contact_phone' => '+62 813-7788-9900',
                'description' => 'Sesi jejaring dan penyampaian gagasan (pitching) bagi praktisi pendidikan digital dan startup teknologi edukasi untuk berkolaborasi dengan institusi pendidikan.',
            ],
        ];
    }
}
