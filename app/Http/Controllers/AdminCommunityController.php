<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class AdminCommunityController extends Controller
{
    /**
     * Centralized community data store stub.
     *
     * @return array<int, array<string, mixed>>
     */
    private function getCommunitiesData(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Web Developer Indonesia',
                'category' => 'Technology',
                'members' => 12500,
                'status' => 'active',
                'description' => 'Komunitas untuk para web developer di seluruh Indonesia saling berbagi ilmu, pengalaman, dan lowongan kerja terkait pengembangan web.',
                'website' => 'https://webdev-id.org',
                'email' => 'hello@webdev-id.org',
                'logo_url' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=120&h=120&q=80',
                'created_at' => '2023-01-15',
                'updated_at' => '2024-01-20',
            ],
            [
                'id' => 2,
                'name' => 'Indo UI/UX Design',
                'category' => 'Design',
                'members' => 8400,
                'status' => 'active',
                'description' => 'Tempat berkumpulnya UI/UX Designer dari Indonesia untuk membahas tren desain, membagikan portofolio, dan mencari feedback dari sesama.',
                'website' => 'https://indouiux.com',
                'email' => 'contact@indouiux.com',
                'logo_url' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&w=120&h=120&q=80',
                'created_at' => '2023-03-10',
                'updated_at' => '2024-02-12',
            ],
            [
                'id' => 3,
                'name' => 'Startup Founders Club',
                'category' => 'Business',
                'members' => 3200,
                'status' => 'active',
                'description' => 'Komunitas eksklusif bagi founder startup di Indonesia untuk networking, berbagi pengalaman fundraising, dan bimbingan bisnis.',
                'website' => 'https://startupfounders.id',
                'email' => 'join@startupfounders.id',
                'logo_url' => '',
                'created_at' => '2022-11-05',
                'updated_at' => '2023-12-05',
            ],
            [
                'id' => 4,
                'name' => 'Data Science Nusantara',
                'category' => 'Technology',
                'members' => 5600,
                'status' => 'inactive',
                'description' => 'Forum diskusi seputar Data Science, Machine Learning, dan Artificial Intelligence dengan studi kasus Indonesia.',
                'website' => 'https://datascience-nusantara.net',
                'email' => 'admin@datascience-nusantara.net',
                'logo_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=120&h=120&q=80',
                'created_at' => '2021-08-20',
                'updated_at' => '2023-05-15',
            ],
        ];
    }

    /**
     * Display a listing of communities with search/filter support.
     */
    public function index(Request $request): View
    {
        $communities = collect($this->getCommunitiesData());

        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $communities = $communities->filter(fn ($c) => str_contains(strtolower($c['name']), $search)
                || str_contains(strtolower($c['category']), $search)
            );
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $communities = $communities->filter(fn ($c) => strtolower($c['status']) === strtolower($request->input('status')));
        }

        if ($request->filled('category') && $request->input('category') !== 'all') {
            $communities = $communities->filter(fn ($c) => strtolower($c['category']) === strtolower($request->input('category')));
        }

        if ($request->filled('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'name_asc') {
                $communities = $communities->sortBy('name');
            } elseif ($sort === 'name_desc') {
                $communities = $communities->sortByDesc('name');
            } elseif ($sort === 'members_desc') {
                $communities = $communities->sortByDesc('members');
            } elseif ($sort === 'oldest') {
                $communities = $communities->sortBy('id');
            } else {
                $communities = $communities->sortByDesc('id');
            }
        }

        $perPage = 10;
        $page = (int) $request->input('page', 1);
        $total = $communities->count();
        $offset = ($page - 1) * $perPage;
        $items = $communities->slice($offset, $perPage)->values();

        $paginatedCommunities = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => route('admin.community.index'), 'query' => $request->query()]
        );

        $totalCommunities = 45;
        $activeCommunities = 38;
        $newMembers = 1250;

        return view('admin.community.index', [
            'communities' => $paginatedCommunities,
            'totalCommunities' => $totalCommunities,
            'activeCommunities' => $activeCommunities,
            'newMembers' => $newMembers,
        ]);
    }

    /**
     * Show the form for creating a new community.
     */
    public function create(): View
    {
        return view('admin.community.create');
    }

    /**
     * Store a newly created community (stub).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'website' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        return redirect()->route('admin.community.index')
            ->with('success', "Komunitas \"{$request->input('name')}\" berhasil ditambahkan.");
    }

    /**
     * Display the specified community.
     */
    public function show(int $id): View
    {
        $community = collect($this->getCommunitiesData())->firstWhere('id', $id);

        if (! $community) {
            $community = $this->getCommunitiesData()[0];
        }

        return view('admin.community.show', compact('community'));
    }

    /**
     * Show the form for editing the specified community.
     */
    public function edit(int $id): View
    {
        $community = collect($this->getCommunitiesData())->firstWhere('id', $id);

        if (! $community) {
            $community = $this->getCommunitiesData()[0];
        }

        return view('admin.community.edit', compact('community'));
    }

    /**
     * Update the specified community (stub).
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'website' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        return redirect()->route('admin.community.index')
            ->with('success', "Data komunitas \"{$request->input('name')}\" berhasil diperbarui.");
    }

    /**
     * Remove the specified community (stub).
     */
    public function destroy(int $id): RedirectResponse
    {
        $community = collect($this->getCommunitiesData())->firstWhere('id', $id);
        $name = $community ? $community['name'] : 'Komunitas';

        return redirect()->route('admin.community.index')
            ->with('success', "Komunitas \"{$name}\" berhasil dihapus.");
    }
}
