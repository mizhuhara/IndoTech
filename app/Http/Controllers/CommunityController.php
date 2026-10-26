<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
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
}
