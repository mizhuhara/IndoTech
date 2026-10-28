<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\View\View;

class EducationController extends Controller
{
    public function index(): View
    {
        $schools = School::where('status', 'Active')
            ->inRandomOrder()
            ->get()
            ->map(fn (School $school) => $this->mapSchool($school))
            ->all();

        return view('education.index', compact('schools'));
    }

    public function show(string $id): View
    {
        $school = School::where('status', 'Active')
            ->where(function ($query) use ($id) {
                $query->where('npsn', $id);

                if (ctype_digit($id)) {
                    $query->orWhere('id', (int) $id);
                }
            })
            ->firstOrFail();

        return view('education.show', [
            'school' => $this->mapSchool($school),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function mapSchool(School $school): array
    {
        $tags = $school->tags ?? [];

        return [
            'id' => $school->npsn ?: (string) $school->id,
            'name' => $school->name,
            'verified' => $school->status === 'Active',
            'category_badge' => $school->institution_type ?: 'Sekolah Menengah Kejuruan',
            'location' => $school->location ?: trim("{$school->city}, {$school->province}", ', '),
            'location_full' => $school->address ?: trim("{$school->location}, Indonesia", ', '),
            'province' => $school->province,
            'tags' => $tags,
            'status_badge' => $school->status === 'Active' ? 'Terverifikasi' : $school->status,
            'status_badge_type' => $school->status === 'Active' ? 'green' : 'gray',
            'image' => $school->logo_url ?: 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1000&q=80',
            'logo_bg_class' => $school->logo_bg ?: 'bg-blue-600',
            'logo_text' => $school->logo_text ?: mb_substr($school->name, 0, 8),
            'website' => $school->website,
            'email' => $school->email,
            'map_link' => 'https://maps.google.com/?q='.urlencode($school->name),
            'about' => $school->description ?: "{$school->name} adalah institusi pendidikan vokasi di {$school->location}.",
            'mission' => 'Menyiapkan lulusan yang kompeten, adaptif, dan siap kerja di industri teknologi.',
            'stats' => [
                'placement_rate' => '-',
                'industry_partners' => ($school->industry_partners ?? 0).'+',
                'active_students' => (string) ($school->total_students ?? '-'),
                'modern_labs' => '-',
            ],
            'competencies' => collect($tags)->map(fn (string $tag) => [
                'name' => $tag,
                'icon' => $this->iconForTag($tag),
                'desc' => "Program keahlian {$tag}.",
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
