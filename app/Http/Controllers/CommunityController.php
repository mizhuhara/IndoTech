<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityPost;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

    public function create(): View
    {
        $categories = ['Technology', 'Design', 'Business', 'Education', 'Science', 'Other'];

        return view('community.create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:1500'],
            'logo' => ['required', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:4096'],
            'type' => ['required', 'in:public,private,publik,privat'],
            'location' => ['required', 'string', 'max:255'],
            'language' => ['required', 'string', 'max:100'],
            'rules' => ['nullable', 'string', 'max:3000'],
        ], [
            'name.required' => 'Nama komunitas wajib diisi.',
            'category.required' => 'Kategori komunitas wajib dipilih.',
            'description.required' => 'Deskripsi komunitas wajib diisi.',
            'logo.required' => 'Logo komunitas wajib diunggah.',
            'logo.image' => 'Logo harus berupa berkas gambar (JPG, PNG, WebP, SVG).',
            'logo.max' => 'Ukuran berkas logo maksimal 2MB.',
            'banner.image' => 'Banner harus berupa berkas gambar (JPG, PNG, WebP, SVG).',
            'banner.max' => 'Ukuran berkas banner maksimal 4MB.',
            'type.required' => 'Jenis komunitas wajib dipilih.',
            'location.required' => 'Lokasi kegiatan wajib diisi.',
            'language.required' => 'Bahasa utama wajib diisi.',
        ]);

        $logoUrl = null;
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('communities', 'public');
            $logoUrl = Storage::disk('public')->url($path);
        }

        $coverUrl = null;
        if ($request->hasFile('banner')) {
            $path = $request->file('banner')->store('communities', 'public');
            $coverUrl = Storage::disk('public')->url($path);
        }

        $normalizedType = in_array(strtolower($validated['type']), ['privat', 'private'], true) ? 'private' : 'public';

        $community = Community::create([
            'user_id' => $request->user()?->id,
            'name' => $validated['name'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'logo_url' => $logoUrl,
            'cover_url' => $coverUrl,
            'type' => $normalizedType,
            'location' => $validated['location'],
            'language' => $validated['language'],
            'rules' => $validated['rules'] ?? null,
            'status' => 'active',
            'members' => $request->user() ? 1 : 0,
        ]);

        if ($request->user()) {
            $community->members()->attach($request->user()->id, [
                'role' => 'admin',
                'is_banned' => false,
            ]);
        }

        return redirect()->route('community.show', $community)
            ->with('success', "Komunitas \"{$community->name}\" berhasil dibuat!");
    }

    public function my(Request $request): View
    {
        $myCommunities = Community::where('user_id', $request->user()->id)
            ->withCount('members')
            ->latest()
            ->paginate(12);

        return view('community.my', [
            'communities' => $myCommunities,
        ]);
    }

    public function manage(Request $request, Community $community): View
    {
        abort_unless(
            $community->user_id === $request->user()->id,
            403,
            'Anda tidak memiliki hak akses untuk mengelola komunitas ini.'
        );

        $members = $community->members()
            ->orderByPivot('role')
            ->get();

        $posts = $community->posts()
            ->with('user')
            ->latest()
            ->get();

        $categories = ['Technology', 'Design', 'Business', 'Education', 'Science', 'Other'];

        return view('community.manage', [
            'community' => $community,
            'members' => $members,
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function updateSettings(Request $request, Community $community): RedirectResponse
    {
        abort_unless(
            $community->user_id === $request->user()->id,
            403,
            'Anda tidak memiliki hak akses untuk mengelola komunitas ini.'
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:1500'],
            'status' => ['required', 'in:active,inactive'],
            'type' => ['required', 'in:public,private,publik,privat'],
            'location' => ['required', 'string', 'max:255'],
            'language' => ['required', 'string', 'max:100'],
            'rules' => ['nullable', 'string', 'max:3000'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:4096'],
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('communities', 'public');
            $validated['logo_url'] = Storage::disk('public')->url($path);
        }

        if ($request->hasFile('banner')) {
            $path = $request->file('banner')->store('communities', 'public');
            $validated['cover_url'] = Storage::disk('public')->url($path);
        }

        $validated['type'] = in_array(strtolower($validated['type']), ['privat', 'private'], true) ? 'private' : 'public';

        unset($validated['logo'], $validated['banner']);

        $community->update($validated);

        return back()->with('success', "Pengaturan komunitas \"{$community->name}\" berhasil diperbarui.");
    }

    public function kickMember(Request $request, Community $community, User $user): RedirectResponse
    {
        abort_unless(
            $community->user_id === $request->user()->id,
            403,
            'Anda tidak memiliki hak akses untuk mengelola komunitas ini.'
        );

        if ($user->id === $community->user_id) {
            return back()->with('error', 'Pembuat komunitas tidak dapat dikeluarkan.');
        }

        $detached = DB::transaction(function () use ($community, $user) {
            $locked = Community::whereKey($community->id)->lockForUpdate()->firstOrFail();
            $count = $locked->members()->detach($user->id);
            if ($count > 0 && $locked->members > 0) {
                $locked->decrement('members');
            }

            return $count > 0;
        });

        return back()->with(
            $detached ? 'success' : 'error',
            $detached
                ? "Pengguna {$user->name} berhasil dikeluarkan dari komunitas."
                : 'Pengguna tersebut bukan anggota komunitas ini.'
        );
    }

    public function toggleBanMember(Request $request, Community $community, User $user): RedirectResponse
    {
        abort_unless(
            $community->user_id === $request->user()->id,
            403,
            'Anda tidak memiliki hak akses untuk mengelola komunitas ini.'
        );

        if ($user->id === $community->user_id) {
            return back()->with('error', 'Pembuat komunitas tidak dapat diblokir.');
        }

        $member = $community->members()->where('user_id', $user->id)->first();
        if ($member) {
            $newBan = ! (bool) $member->pivot->is_banned;
            $community->members()->updateExistingPivot($user->id, [
                'is_banned' => $newBan,
            ]);
            $msg = $newBan
                ? "Pengguna {$user->name} berhasil diblokir (banned) dari komunitas."
                : "Blokir untuk {$user->name} telah dicabut.";
        } else {
            $community->members()->attach($user->id, [
                'role' => 'member',
                'is_banned' => true,
            ]);
            $msg = "Pengguna {$user->name} berhasil diblokir (banned) dari komunitas.";
        }

        return back()->with('success', $msg);
    }

    public function moderatePost(Request $request, Community $community, CommunityPost $post): RedirectResponse
    {
        abort_unless(
            $community->user_id === $request->user()->id,
            403,
            'Anda tidak memiliki hak akses untuk mengelola komunitas ini.'
        );
        abort_unless($post->community_id === $community->id, 404);

        $action = $request->input('action');
        if ($action === 'delete') {
            $post->delete();
            $msg = 'Postingan berhasil dihapus.';
        } elseif ($action === 'hide') {
            $post->update(['status' => 'hidden']);
            $msg = 'Postingan berhasil disembunyikan.';
        } elseif ($action === 'publish') {
            $post->update(['status' => 'published']);
            $msg = 'Postingan berhasil dipublikasikan kembali.';
        } else {
            return back()->with('error', 'Aksi moderasi tidak valid.');
        }

        return back()->with('success', $msg);
    }

    public function storePost(Request $request, Community $community): RedirectResponse
    {
        abort_unless($community->status === 'active', 404);

        $membership = $community->members()->where('user_id', $request->user()->id)->first();
        if ($membership && $membership->pivot->is_banned) {
            return back()->with('error', 'Anda diblokir dan tidak dapat memposting di komunitas ini.');
        }

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:5000'],
        ]);

        $community->posts()->create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'] ?? null,
            'content' => $validated['content'],
            'status' => 'published',
        ]);

        return back()->with('success', 'Postingan Anda berhasil diterbitkan.');
    }

    public function show(Request $request, Community $community): View
    {
        abort_unless($community->status === 'active', 404);

        $isMember = $request->user()
            && $community->members()->whereKey($request->user()->id)->exists();

        $isOwnerOrAdmin = $request->user()
            && $community->isOwnerOrAdmin($request->user());

        $posts = $community->posts()
            ->where('status', 'published')
            ->with('user')
            ->latest()
            ->get();

        return view('community.show', [
            'community' => $community,
            'isMember' => $isMember,
            'isOwnerOrAdmin' => $isOwnerOrAdmin,
            'posts' => $posts,
            'memberUsers' => $community->members()
                ->orderByDesc('community_user.created_at')
                ->limit(12)
                ->get(),
        ]);
    }

    public function join(Request $request, Community $community): RedirectResponse
    {
        abort_unless($community->status === 'active', 404);

        $isBanned = $community->members()
            ->where('user_id', $request->user()->id)
            ->wherePivot('is_banned', true)
            ->exists();

        if ($isBanned) {
            return back()->with('error', 'Anda telah diblokir (banned) dari komunitas ini.');
        }

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
