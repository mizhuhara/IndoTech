<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CommunityController extends Controller
{
    public function index(Request $request): View
    {
        $query = Community::where('status', 'active');

        if ($request->filled('q')) {
            $search = trim($request->query('q'));
            $query->where(function ($sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $activeCategory = $request->input('category', 'all');
        if ($activeCategory !== 'all') {
            $query->where('category', $activeCategory);
        }

        $sort = $request->input('sort', 'members_desc');
        match ($sort) {
            'name_asc' => $query->orderBy('name'),
            'name_desc' => $query->orderByDesc('name'),
            'newest' => $query->orderByDesc('created_at'),
            default => $query->orderByDesc('members'),
        };

        return view('community.index', [
            'communities' => $query->paginate(12)->withQueryString(),
            'totalMembers' => Community::where('status', 'active')->sum('members'),
            'totalGroups' => Community::where('status', 'active')->count(),
            'activeSort' => $sort,
            'activeCategory' => $activeCategory,
        ]);
    }

    public function show(Request $request, Community $community): View
    {
        abort_unless($community->status === 'active', 404);

        $isMember = $request->user()
            && $community->members()->whereKey($request->user()->id)->exists();

        return view('community.show', [
            'community' => $community,
            'isMember' => $isMember,
            'memberUsers' => $community->members()
                ->orderByDesc('community_user.created_at')
                ->limit(12)
                ->get(),
        ]);
    }

    public function join(Request $request, Community $community): RedirectResponse
    {
        abort_unless($community->status === 'active', 404);

        $joined = DB::transaction(function () use ($request, $community) {
            $locked = Community::whereKey($community->id)->lockForUpdate()->firstOrFail();

            if ($locked->members()->whereKey($request->user()->id)->exists()) {
                return false;
            }

            $locked->members()->attach($request->user()->id);
            $locked->increment('members');

            return true;
        });

        return back()->with(
            $joined ? 'success' : 'error',
            $joined
                ? "Anda berhasil bergabung dengan \"{$community->name}\"."
                : 'Anda sudah menjadi anggota komunitas ini.'
        );
    }

    public function leave(Request $request, Community $community): RedirectResponse
    {
        $left = DB::transaction(function () use ($request, $community) {
            $locked = Community::whereKey($community->id)->lockForUpdate()->firstOrFail();
            $detached = $locked->members()->detach($request->user()->id);

            if ($detached > 0 && $locked->members > 0) {
                $locked->decrement('members');
            }

            return $detached > 0;
        });

        return back()->with(
            $left ? 'success' : 'error',
            $left
                ? "Anda keluar dari \"{$community->name}\"."
                : 'Anda belum menjadi anggota komunitas ini.'
        );
    }
}
