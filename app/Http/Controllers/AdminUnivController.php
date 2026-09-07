<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUnivController extends Controller
{
    /**
     * Display a listing of universities with search/filter support.
     */
    public function index(Request $request): View
    {
        $query = University::query();

        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(npsn) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(city) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(province) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(location) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->whereRaw('LOWER(status) = ?', [strtolower($request->input('status'))]);
        }

        if ($request->filled('type') && $request->input('type') !== 'all') {
            $query->whereRaw('LOWER(type) = ?', [strtolower($request->input('type'))]);
        }

        if ($request->filled('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'name_asc') {
                $query->orderBy('name', 'asc');
            } elseif ($sort === 'name_desc') {
                $query->orderBy('name', 'desc');
            } elseif ($sort === 'region_asc') {
                $query->orderBy('city', 'asc');
            } elseif ($sort === 'region_desc') {
                $query->orderBy('city', 'desc');
            } elseif ($sort === 'oldest') {
                $query->orderBy('id', 'asc');
            } else {
                $query->orderBy('id', 'desc');
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        $univs = $query->paginate(6)->withQueryString();

        $totalUnivs = University::count();
        $activePartners = University::whereRaw('LOWER(status) = ?', ['active'])->count();
        $newSubmissions = University::where('created_at', '>=', now()->subDays(30))->count();

        return view('admin.univ.index', [
            'univs' => $univs,
            'totalUnivs' => $totalUnivs,
            'activePartners' => $activePartners,
            'newSubmissions' => $newSubmissions,
        ]);
    }

    /**
     * Show the form for creating a new university.
     */
    public function create(): View
    {
        return view('admin.univ.create');
    }

    /**
     * Store a newly created university in database.
     */
    /**
     * Store a newly created university in database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'npsn' => ['required', 'string', 'max:20', 'unique:universities,npsn'],
            'type' => ['required', 'string'],
            'location' => ['required', 'string', 'max:150'],
            'accreditation' => ['nullable', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'address' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'map_link' => ['nullable', 'string', 'max:500'],
            'logo' => ['nullable', 'image', 'max:5120'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:5120'],
        ]);

        $locationParts = array_map('trim', explode(',', $validated['location']));
        $city = $locationParts[0] ?? $validated['location'];
        $province = $locationParts[1] ?? '';

        $words = explode(' ', $validated['name']);
        $logoText = strtoupper(substr($words[0] ?? 'UNIV', 0, 3));

        $data = [
            'name' => $validated['name'],
            'npsn' => $validated['npsn'],
            'type' => $validated['type'],
            'location' => $validated['location'],
            'city' => $city,
            'province' => $province,
            'accreditation' => $validated['accreditation'] ?? 'A',
            'website' => $validated['website'] ?? null,
            'description' => $validated['description'] ?? null,
            'address' => $validated['address'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'map_link' => $validated['map_link'] ?? null,
            'status' => 'Active',
            'logo_text' => $logoText,
            'logo_bg' => 'bg-blue-700',
            'gallery' => [],
        ];

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $path = $file->store('universities/logos', 'public');
            $data['logo_url'] = Storage::url($path);
            $data['logo_name'] = $file->getClientOriginalName();
        }

        if ($request->hasFile('gallery')) {
            $galleryUrls = [];
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('universities/gallery', 'public');
                $galleryUrls[] = Storage::url($path);
            }
            $data['gallery'] = $galleryUrls;
        }

        University::create($data);

        return redirect()->route('admin.univ.index')
            ->with('success', "Universitas \"{$validated['name']}\" berhasil ditambahkan.");
    }

    /**
     * Display the specified university.
     */
    public function show(int $id): View
    {
        $univ = University::findOrFail($id);

        return view('admin.univ.show', compact('univ'));
    }

    /**
     * Show the form for editing the specified university.
     */
    public function edit(int $id): View
    {
        $univ = University::findOrFail($id);

        return view('admin.univ.edit', compact('univ'));
    }

    /**
     * Update the specified university in database.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $univ = University::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'npsn' => ['required', 'string', 'max:20', Rule::unique('universities', 'npsn')->ignore($id)],
            'type' => ['required', 'string'],
            'location' => ['required', 'string', 'max:150'],
            'accreditation' => ['nullable', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'address' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'map_link' => ['nullable', 'string', 'max:500'],
            'logo' => ['nullable', 'image', 'max:5120'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:5120'],
            'existing_gallery' => ['nullable', 'array'],
            'existing_gallery.*' => ['string'],
        ]);

        $locationParts = array_map('trim', explode(',', $validated['location']));
        $city = $locationParts[0] ?? $validated['location'];
        $province = $locationParts[1] ?? '';

        $data = [
            'name' => $validated['name'],
            'npsn' => $validated['npsn'],
            'type' => $validated['type'],
            'location' => $validated['location'],
            'city' => $city,
            'province' => $province,
            'accreditation' => $validated['accreditation'] ?? $univ->accreditation,
            'website' => $validated['website'] ?? $univ->website,
            'description' => $validated['description'] ?? $univ->description,
            'address' => $validated['address'] ?? $univ->address,
            'latitude' => $validated['latitude'] ?? $univ->latitude,
            'longitude' => $validated['longitude'] ?? $univ->longitude,
            'map_link' => $validated['map_link'] ?? $univ->map_link,
        ];

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $path = $file->store('universities/logos', 'public');
            $data['logo_url'] = Storage::url($path);
            $data['logo_name'] = $file->getClientOriginalName();
        }

        // Handle gallery images: keep retained existing ones + add newly uploaded ones
        $gallery = $request->input('existing_gallery', []);
        if (! is_array($gallery)) {
            $gallery = [];
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('universities/gallery', 'public');
                $gallery[] = Storage::url($path);
            }
        }

        $data['gallery'] = array_values($gallery);

        $univ->update($data);

        return redirect()->route('admin.univ.index')
            ->with('success', "Data universitas \"{$validated['name']}\" berhasil diperbarui.");
    }

    /**
     * Remove the specified university from database.
     */
    public function destroy(int $id): RedirectResponse
    {
        $univ = University::findOrFail($id);
        $name = $univ->name;
        $univ->delete();

        return redirect()->route('admin.univ.index')
            ->with('success', "Universitas \"{$name}\" berhasil dihapus.");
    }
}
