<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSchoolController extends Controller
{
    /**
     * Display a listing of schools with search/filter support.
     */
    public function index(Request $request): View
    {
        $query = $this->visibleSchools();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('npsn', 'like', "%{$search}%")
                ->orWhere('city', 'like', "%{$search}%")
                ->orWhere('province', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%"));
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('sort')) {
            $sort = $request->input('sort');
            match ($sort) {
                'name_asc' => $query->orderBy('name'),
                'name_desc' => $query->orderByDesc('name'),
                'region_asc' => $query->orderBy('city'),
                'region_desc' => $query->orderByDesc('city'),
                'oldest' => $query->orderBy('id'),
                default => $query->orderByDesc('id'),
            };
        } else {
            $query->orderByDesc('id');
        }

        $paginatedSchools = $query->paginate(4)->withQueryString();

        $visible = $this->visibleSchools();

        return view('admin.schools.index', [
            'schools' => $paginatedSchools,
            'totalSchools' => (clone $visible)->count(),
            'activePartners' => (clone $visible)->where('status', 'Active')->count(),
            'newSubmissions' => (clone $visible)->where('status', 'Inactive')->count(),
            'canManage' => in_array($request->user()->role, ['super_admin', 'admin'], true),
        ]);
    }

    /**
     * Show the form for creating a new school.
     */
    public function create(): View
    {
        $this->authorizeCreate();

        return view('admin.schools.create');
    }

    /**
     * Store a newly created school in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorizeCreate();

        $data = $this->validateSchool($request);
        $user = $request->user();

        // Feed lama (data diisi manual oleh admin) dipakai untuk apa?
        School::create($data);

        return redirect()->route('admin.schools.index')
            ->with('success', "Sekolah \"{$data['name']}\" berhasil ditambahkan.");
    }

    /**
     * Display the specified school.
     */
    public function show(int $id): View
    {
        $school = $this->findVisibleSchool($id);

        return view('admin.schools.show', compact('school'));
    }

    /**
     * Show the form for editing the specified school.
     */
    public function edit(int $id): View
    {
        $school = $this->findVisibleSchool($id);

        return view('admin.schools.edit', compact('school'));
    }

    /**
     * Update the specified school in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $school = $this->findVisibleSchool($id);
        $data = $this->validateSchool($request);
        $user = $request->user();

        // Institusi tidak boleh mengubah status — hanya admin yang approve/reject
        if (in_array($user->role, ['school', 'university', 'company'], true)) {
            unset($data['status']);
        }

        $school->update($data);

        return redirect()->route('admin.schools.index')
            ->with('success', "Data sekolah \"{$data['name']}\" berhasil diperbarui.");
    }

    /**
     * Remove the specified school from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        abort_if(auth()->user()->role !== 'super_admin' && auth()->user()->role !== 'admin', 403, 'Akses ditolak. Hanya admin.');

        $school = $this->findVisibleSchool($id);
        $name = $school->name;

        $school->delete();

        return redirect()->route('admin.schools.index')
            ->with('success', "Sekolah \"{$name}\" berhasil dihapus.");
    }

    /**
     * Query schools yang boleh dilihat user: super_admin semua, role school hanya miliknya.
     */
    private function visibleSchools()
    {
        $user = auth()->user();

        if ($user && $user->role === 'school') {
            return School::where('user_id', $user->id);
        }

        return School::query();
    }

    /**
     * Ambil sekolah dengan proteksi kepemilikan (404 kalau bukan miliknya).
     */
    private function findVisibleSchool(int $id): School
    {
        return $this->visibleSchools()->findOrFail($id);
    }

    private function authorizeCreate(): void
    {
        $user = auth()->user();

        if (in_array($user->role, ['school', 'university', 'company'], true)) {
            abort(403, 'Akses ditolak. Akun institusi tidak dapat menambah data baru.');
        }
    }

    private function validateSchool(Request $request): array
    {
        return $request->validate([
            'npsn' => ['required', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:255'],
            'institution_type' => ['required', 'string', 'max:100', 'in:SMK IT,SMK,SMA IT,SMK Non-IT,Sekolah IT,Vokasi IT'],
            'city' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:150'],
            'address' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:20'],
            'logo_url' => ['nullable', 'url', 'max:500'],
            'logo_text' => ['nullable', 'string', 'max:50'],
            'logo_bg' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'description' => ['nullable', 'string', 'max:1000'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
            'total_students' => ['nullable', 'integer', 'min:0'],
            'industry_partners' => ['nullable', 'integer', 'min:0'],
            'founded' => ['nullable', 'string', 'max:10'],
            'accreditation' => ['nullable', 'string', 'max:10'],
        ]);
    }
}
