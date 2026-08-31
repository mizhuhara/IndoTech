<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class AdminSchoolController extends Controller
{
    /**
     * Centralized school data store.
     *
     * @return array<int, array<string, mixed>>
     */
    private function getSchoolsData(): array
    {
        return [
            [
                'id' => 1,
                'npsn' => '20109988',
                'name' => 'SMK Telkom Jakarta',
                'type' => 'SMK (IT)',
                'institution_type' => 'SMK IT',
                'city' => 'Jakarta Barat',
                'province' => 'DKI Jakarta',
                'location' => 'Jakarta Barat, DKI Jakarta',
                'address' => 'Jl. Daan Mogot, Cengkareng, Jakarta Barat, 11730',
                'status' => 'Active',
                'logo_name' => 'SMK_Telkom_Logo.png',
                'logo_url' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'TELKOM',
                'logo_bg' => 'bg-blue-600',
                'email' => 'info@smktelkomjakarta.sch.id',
                'website' => 'https://smktelkomjakarta.sch.id',
                'phone' => '021-56957111',
                'description' => 'SMK Telkom Jakarta is a premier vocational high school focusing on Information Technology and Telecommunications. We prepare students for the modern tech workforce with a specialized curriculum in Network Engineering, Software Development, and Multimedia.',
                'tags' => ['TKJ', 'RPL', 'Broadcasting'],
                'total_students' => 1850,
                'industry_partners' => 72,
                'founded' => 1989,
                'accreditation' => 'A',
                'created_at' => '2024-01-15',
            ],
            [
                'id' => 2,
                'npsn' => '20211234',
                'name' => 'SMK Negeri 1 Bandung',
                'type' => 'SMK (IT)',
                'institution_type' => 'SMK IT',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'location' => 'Bandung, Jawa Barat',
                'address' => 'Jl. Wastukencana No.3, Bandung, Jawa Barat 40117',
                'status' => 'Active',
                'logo_name' => 'SMKN1_Bandung_Logo.png',
                'logo_url' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'SMK 1',
                'logo_bg' => 'bg-sky-600',
                'email' => 'info@smkn1bandung.sch.id',
                'website' => 'https://smkn1bandung.sch.id',
                'phone' => '022-4203974',
                'description' => 'SMK Negeri 1 Bandung is a premier vocational high school in West Java providing top education in Software Development, Computer Networks, and Digital Media.',
                'tags' => ['RPL', 'TKJ', 'Multimedia'],
                'total_students' => 2100,
                'industry_partners' => 85,
                'founded' => 1950,
                'accreditation' => 'A',
                'created_at' => '2024-02-10',
            ],
            [
                'id' => 3,
                'npsn' => '70012555',
                'name' => 'SMA Kristen 1 Tomohon',
                'type' => 'SMK (IT)',
                'institution_type' => 'SMK IT',
                'city' => 'Tomohon',
                'province' => 'Sulawesi Utara',
                'location' => 'Tomohon, Sulawesi Utara',
                'address' => 'Jl. R.W. Mongisidi No.10, Tomohon, Sulawesi Utara 95362',
                'status' => 'Inactive',
                'logo_name' => 'SMA_Kristen_Logo.png',
                'logo_url' => '',
                'logo_text' => 'SK',
                'logo_bg' => 'bg-slate-200 text-slate-600',
                'email' => 'admin@smakristentomohon.sch.id',
                'website' => '',
                'phone' => '0431-351234',
                'description' => 'SMA Kristen 1 Tomohon is a respected high school in North Sulawesi committed to academic excellence, leadership development, and character building.',
                'tags' => ['IPA', 'IPS'],
                'total_students' => 480,
                'industry_partners' => 5,
                'founded' => 1965,
                'accreditation' => 'B',
                'created_at' => '2024-03-05',
            ],
            [
                'id' => 4,
                'npsn' => '20301122',
                'name' => 'SMK Raden Umar Said',
                'type' => 'SMK (IT)',
                'institution_type' => 'SMK IT',
                'city' => 'Kudus',
                'province' => 'Jawa Tengah',
                'location' => 'Kudus, Jawa Tengah',
                'address' => 'Jl. Kudus–Colo Km.5, Kudus, Jawa Tengah 59353',
                'status' => 'Active',
                'logo_name' => 'SMK_RUS_Logo.png',
                'logo_url' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'RUS',
                'logo_bg' => 'bg-purple-700',
                'email' => 'hello@smkrus.sch.id',
                'website' => 'https://smkrus.sch.id',
                'phone' => '0291-434876',
                'description' => 'SMK Raden Umar Said (RUS) Kudus is an internationally recognized 3D animation and software development school with cutting-edge production pipelines.',
                'tags' => ['3D Animation', 'RPL'],
                'total_students' => 980,
                'industry_partners' => 45,
                'founded' => 1998,
                'accreditation' => 'A',
                'created_at' => '2024-03-20',
            ],
            [
                'id' => 5,
                'npsn' => '20501987',
                'name' => 'SMK Negeri 1 Denpasar',
                'type' => 'SMK (IT)',
                'institution_type' => 'SMK IT',
                'city' => 'Denpasar',
                'province' => 'Bali',
                'location' => 'Denpasar, Bali',
                'address' => 'Jl. Hos Cokroaminoto No.84, Denpasar, Bali 80119',
                'status' => 'Active',
                'logo_name' => 'SMKN1_Denpasar_Logo.png',
                'logo_url' => '',
                'logo_text' => 'SMK 1',
                'logo_bg' => 'bg-teal-700',
                'email' => 'info@smkn1denpasar.sch.id',
                'website' => 'https://smkn1denpasar.sch.id',
                'phone' => '0361-262375',
                'description' => 'SMK Negeri 1 Denpasar is a center of vocational excellence in Bali focused on IT solutions, programming, and networking infrastructure.',
                'tags' => ['RPL', 'TKJ', 'Multimedia'],
                'total_students' => 1350,
                'industry_partners' => 40,
                'founded' => 1970,
                'accreditation' => 'A',
                'created_at' => '2024-04-01',
            ],
            [
                'id' => 6,
                'npsn' => '20601543',
                'name' => 'SMK Telkom Medan',
                'type' => 'SMK (IT)',
                'institution_type' => 'SMK IT',
                'city' => 'Medan',
                'province' => 'Sumatera Utara',
                'location' => 'Medan, Sumatera Utara',
                'address' => 'Jl. Jamin Ginting No.485, Medan, Sumatera Utara 20156',
                'status' => 'Active',
                'logo_name' => 'SMK_Telkom_Medan_Logo.png',
                'logo_url' => '',
                'logo_text' => 'TLK MDN',
                'logo_bg' => 'bg-red-600',
                'email' => 'info@smktelkommdn.sch.id',
                'website' => 'https://smktelkom-mdn.sch.id',
                'phone' => '061-7364855',
                'description' => 'SMK Telkom Medan offers specialized training in telecommunication, enterprise network engineering, and modern web application development.',
                'tags' => ['TKJ', 'RPL', 'Broadcasting'],
                'total_students' => 1400,
                'industry_partners' => 60,
                'founded' => 2002,
                'accreditation' => 'A',
                'created_at' => '2024-04-15',
            ],
            [
                'id' => 7,
                'npsn' => '20701321',
                'name' => 'SMK Negeri 2 Makassar',
                'type' => 'SMK (IT)',
                'institution_type' => 'SMK IT',
                'city' => 'Makassar',
                'province' => 'Sulawesi Selatan',
                'location' => 'Makassar, Sulawesi Selatan',
                'address' => 'Jl. Perintis Kemerdekaan Km.12, Makassar, Sulawesi Selatan 90245',
                'status' => 'Active',
                'logo_name' => 'SMKN2_Makassar_Logo.png',
                'logo_url' => '',
                'logo_text' => 'SMK 2',
                'logo_bg' => 'bg-sky-700',
                'email' => 'contact@smkn2makassar.sch.id',
                'website' => 'https://smkn2makassar.sch.id',
                'phone' => '0411-324567',
                'description' => 'SMK Negeri 2 Makassar provides top-tier education in computer informatics, cloud services, and enterprise software engineering.',
                'tags' => ['RPL', 'TKJ', 'SIJA'],
                'total_students' => 1250,
                'industry_partners' => 35,
                'founded' => 1967,
                'accreditation' => 'A',
                'created_at' => '2024-05-10',
            ],
        ];
    }

    /**
     * Display a listing of schools with search/filter support.
     */
    public function index(Request $request): View
    {
        $schools = collect($this->getSchoolsData());

        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $schools = $schools->filter(fn ($s) => str_contains(strtolower($s['name']), $search)
                || str_contains(strtolower($s['npsn']), $search)
                || str_contains(strtolower($s['city']), $search)
                || str_contains(strtolower($s['province']), $search)
                || str_contains(strtolower($s['location']), $search)
            );
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $schools = $schools->filter(fn ($s) => strtolower($s['status']) === strtolower($request->input('status')));
        }

        if ($request->filled('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'name_asc') {
                $schools = $schools->sortBy('name');
            } elseif ($sort === 'name_desc') {
                $schools = $schools->sortByDesc('name');
            } elseif ($sort === 'region_asc') {
                $schools = $schools->sortBy('city');
            } elseif ($sort === 'region_desc') {
                $schools = $schools->sortByDesc('city');
            } elseif ($sort === 'oldest') {
                $schools = $schools->sortBy('id');
            } else {
                $schools = $schools->sortByDesc('id');
            }
        }

        $perPage = 4;
        $page = (int) $request->input('page', 1);
        $total = $schools->count();
        $offset = ($page - 1) * $perPage;
        $items = $schools->slice($offset, $perPage)->values();

        $paginatedSchools = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => route('admin.schools.index'), 'query' => $request->query()]
        );

        $totalSchools = 520;
        $activePartners = 480;
        $newSubmissions = 40;

        return view('admin.schools.index', [
            'schools' => $paginatedSchools,
            'totalSchools' => $totalSchools,
            'activePartners' => $activePartners,
            'newSubmissions' => $newSubmissions,
        ]);
    }

    /**
     * Show the form for creating a new school.
     */
    public function create(): View
    {
        return view('admin.schools.create');
    }

    /**
     * Store a newly created school (stub — no DB yet).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'npsn' => ['required', 'string', 'max:20'],
            'institution_type' => ['required', 'string'],
            'location' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        return redirect()->route('admin.schools.index')
            ->with('success', "Sekolah \"{$request->input('name')}\" berhasil ditambahkan.");
    }

    /**
     * Display the specified school.
     */
    public function show(int $id): View
    {
        $school = collect($this->getSchoolsData())->firstWhere('id', $id);

        if (! $school) {
            $school = $this->getSchoolsData()[0];
        }

        return view('admin.schools.show', compact('school'));
    }

    /**
     * Show the form for editing the specified school.
     */
    public function edit(int $id): View
    {
        $school = collect($this->getSchoolsData())->firstWhere('id', $id);

        if (! $school) {
            $school = $this->getSchoolsData()[0];
        }

        return view('admin.schools.edit', compact('school'));
    }

    /**
     * Update the specified school (stub — no DB yet).
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'npsn' => ['required', 'string', 'max:20'],
            'institution_type' => ['required', 'string'],
            'location' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        return redirect()->route('admin.schools.index')
            ->with('success', "Data sekolah \"{$request->input('name')}\" berhasil diperbarui.");
    }

    /**
     * Remove the specified school (stub — no DB yet).
     */
    public function destroy(int $id): RedirectResponse
    {
        $school = collect($this->getSchoolsData())->firstWhere('id', $id);
        $name = $school ? $school['name'] : 'Sekolah';

        return redirect()->route('admin.schools.index')
            ->with('success', "Sekolah \"{$name}\" berhasil dihapus.");
    }
}
