<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\View\View;

class CampusController extends Controller
{
    public function index(): View
    {
        $campuses = University::where('status', 'Active')
            ->orderBy('name')
            ->get()
            ->map(fn (University $university) => $this->mapCampus($university))
            ->all();

        return view('education.campus.index', compact('campuses'));
    }

    public function show(string $id): View
    {
        $university = University::where('status', 'Active')
            ->where(function ($query) use ($id) {
                $query->where('npsn', $id);

                if (ctype_digit($id)) {
                    $query->orWhere('id', (int) $id);
                }
            })
            ->firstOrFail();

        return view('education.campus.show', [
            'campus' => $this->mapCampus($university),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function mapCampus(University $university): array
    {
        $tags = $university->tags ?? [];
        $isPublic = $university->type === 'Negeri';

        return [
            'id' => $university->npsn ?: (string) $university->id,
            'name' => $university->name,
            'verified' => $university->status === 'Active',
            'category_badge' => $isPublic ? 'Public University' : 'Private University',
            'location' => $university->location ?: trim("{$university->city}, {$university->province}", ', '),
            'location_full' => $university->address ?: trim("{$university->location}, Indonesia", ', '),
            'province' => $university->province,
            'faculty' => $university->accreditation ? "Akreditasi {$university->accreditation}" : '-',
            'tags' => $tags,
            'status_badge' => $university->status === 'Active' ? 'Verified' : $university->status,
            'status_badge_type' => $university->status === 'Active' ? 'green' : 'gray',
            'image' => $university->logo_url ?: 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1000&q=80',
            'logo_bg_class' => $university->logo_bg ?: 'bg-blue-700',
            'logo_text' => $university->logo_text ?: mb_substr($university->name, 0, 8),
            'website' => $university->website,
            'email' => $university->email,
            'map_link' => $university->map_link ?: 'https://maps.google.com/?q='.urlencode($university->name),
            'about' => $university->description ?: "{$university->name} adalah perguruan tinggi di {$university->location}.",
            'mission' => 'Menyelenggarakan pendidikan, penelitian, dan pengabdian masyarakat di bidang teknologi informasi.',
            'stats' => [
                'active_students' => $university->total_students ? number_format($university->total_students) : '-',
                'faculties' => (string) ($university->total_faculties ?? '-'),
                'accreditation' => $university->accreditation ?? '-',
                'founded' => (string) ($university->founded ?? '-'),
            ],
            'competencies' => collect($tags)->map(fn (string $tag) => [
                'name' => $tag,
                'icon' => $this->iconForTag($tag),
                'desc' => "Program studi {$tag}.",
            ])->all(),
        ];
    }

    private function iconForTag(string $tag): string
    {
        $tag = strtolower($tag);

        if (str_contains($tag, 'network') || str_contains($tag, 'jaringan') || str_contains($tag, 'cloud')) {
            return 'server';
        }

        if (str_contains($tag, 'design') || str_contains($tag, 'multimedia') || str_contains($tag, 'animation')) {
            return 'cube';
        }

        return 'code';
    }
}
