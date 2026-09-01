<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class AdminUnivController extends Controller
{
    /**
     * Centralized university data store.
     *
     * @return array<int, array<string, mixed>>
     */
    private function getUnivData(): array
    {
        return [
            [
                'id' => 1,
                'npsn' => '20109988',
                'name' => 'Institut Teknologi Bandung',
                'type' => 'Negeri',
                'institution_type' => 'Negeri',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'location' => 'Bandung, Jawa Barat',
                'address' => 'Jl. Ganesha No.10, Lb. Siliwangi, Kec. Coblong, Kota Bandung, Jawa Barat 40132',
                'status' => 'Active',
                'logo_name' => 'ITB_Logo.png',
                'logo_url' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'ITB',
                'logo_bg' => 'bg-blue-700',
                'email' => 'info@itb.ac.id',
                'website' => 'https://www.itb.ac.id',
                'phone' => '022-2504780',
                'description' => 'Institut Teknologi Bandung (ITB) adalah perguruan tinggi negeri tertua di Indonesia yang berfokus pada sains, teknologi, dan seni. Terkenal dengan program teknik, sains, dan desain yang unggul secara internasional.',
                'tags' => ['Teknik', 'Sains', 'Desain', 'Arsitektur'],
                'total_students' => 30000,
                'total_faculties' => 12,
                'accreditation' => 'A',
                'founded' => 1920,
                'created_at' => '2024-01-15',
            ],
            [
                'id' => 2,
                'npsn' => '20211234',
                'name' => 'Universitas Indonesia',
                'type' => 'Negeri',
                'institution_type' => 'Negeri',
                'city' => 'Depok',
                'province' => 'Jawa Barat',
                'location' => 'Depok, Jawa Barat',
                'address' => 'Kampus UI Depok, Jl. Prof. Dr. Ir. Soekarno, Kec. Beji, Kota Depok, Jawa Barat 16424',
                'status' => 'Active',
                'logo_name' => 'UI_Logo.png',
                'logo_url' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'UI',
                'logo_bg' => 'bg-yellow-600',
                'email' => 'humas@ui.ac.id',
                'website' => 'https://www.ui.ac.id',
                'phone' => '021-7888001',
                'description' => 'Universitas Indonesia (UI) adalah salah satu perguruan tinggi negeri terbaik di Indonesia dengan kampus utama di Depok. Memiliki 14 fakultas dan program studi unggulan di bidang kedokteran, hukum, ekonomi, dan teknik.',
                'tags' => ['Kedokteran', 'Hukum', 'Ekonomi', 'Teknik', 'Ilmu Sosial'],
                'total_students' => 45000,
                'total_faculties' => 14,
                'accreditation' => 'A',
                'founded' => 1849,
                'created_at' => '2024-02-10',
            ],
            [
                'id' => 3,
                'npsn' => '70012555',
                'name' => 'Universitas Gadjah Mada',
                'type' => 'Negeri',
                'institution_type' => 'Negeri',
                'city' => 'Yogyakarta',
                'province' => 'DI Yogyakarta',
                'location' => 'Yogyakarta, DI Yogyakarta',
                'address' => 'Jl. Sosio Humaniora No.1, Bulaksumur, Kec. Mlati, Kabupaten Sleman, DI Yogyakarta 55281',
                'status' => 'Active',
                'logo_name' => 'UGM_Logo.png',
                'logo_url' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'UGM',
                'logo_bg' => 'bg-red-700',
                'email' => 'ugm@ugm.ac.id',
                'website' => 'https://www.ugm.ac.id',
                'phone' => '0274-552810',
                'description' => 'Universitas Gadjah Mada (UGM) adalah universitas negeri tertua di Indonesia yang berdiri pada 1949. Terkenal sebagai "Perguruan Tinggi Pancasila" dengan 18 fakultas dan program unggulan di berbagai disiplin ilmu.',
                'tags' => ['Ilmu Sosial', 'Teknik', 'Pertanian', 'Kedokteran', 'Hukum'],
                'total_students' => 50000,
                'total_faculties' => 18,
                'accreditation' => 'A',
                'founded' => 1949,
                'created_at' => '2024-03-05',
            ],
            [
                'id' => 4,
                'npsn' => '20301122',
                'name' => 'Institut Teknologi Sepuluh Nopember',
                'type' => 'Negeri',
                'institution_type' => 'Negeri',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
                'location' => 'Surabaya, Jawa Timur',
                'address' => 'Kampus ITS Sukolilo, Jl. Raya ITS, Kec. Sukolilo, Kota Surabaya, Jawa Timur 60111',
                'status' => 'Active',
                'logo_name' => 'ITS_Logo.png',
                'logo_url' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'ITS',
                'logo_bg' => 'bg-orange-600',
                'email' => 'humas@its.ac.id',
                'website' => 'https://www.its.ac.id',
                'phone' => '031-5923411',
                'description' => 'Institut Teknologi Sepuluh Nopember (ITS) adalah perguruan tinggi negeri yang berfokus pada teknologi maritim, teknik, dan sains. Terkenal dengan penelitian robotika, kelautan, dan energi terbarukan.',
                'tags' => ['Teknik Maritim', 'Robotika', 'Teknik Elektro', 'Teknik Mesin'],
                'total_students' => 25000,
                'total_faculties' => 7,
                'accreditation' => 'A',
                'founded' => 1957,
                'created_at' => '2024-03-20',
            ],
            [
                'id' => 5,
                'npsn' => '20501987',
                'name' => 'Universitas Airlangga',
                'type' => 'Negeri',
                'institution_type' => 'Negeri',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
                'location' => 'Surabaya, Jawa Timur',
                'address' => 'Kampus C Mulyorejo, Jl. Mulyorejo, Kec. Mulyorejo, Kota Surabaya, Jawa Timur 60115',
                'status' => 'Active',
                'logo_name' => 'UNAIR_Logo.png',
                'logo_url' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'UNAIR',
                'logo_bg' => 'bg-purple-700',
                'email' => 'humas@unair.ac.id',
                'website' => 'https://www.unair.ac.id',
                'phone' => '031-5914040',
                'description' => 'Universitas Airlangga (UNAIR) adalah universitas negeri tertua di Jawa Timur dengan keunggulan di bidang kesehatan, kedokteran gigi, farmasi, dan keperawatan. Memiliki rumah sakit pendidikan sendiri.',
                'tags' => ['Kedokteran', 'Kedokteran Gigi', 'Farmasi', 'Keperawatan', 'Kesehatan Masyarakat'],
                'total_students' => 35000,
                'total_faculties' => 15,
                'accreditation' => 'A',
                'founded' => 1954,
                'created_at' => '2024-04-01',
            ],
            [
                'id' => 6,
                'npsn' => '20601543',
                'name' => 'Universitas Diponegoro',
                'type' => 'Negeri',
                'institution_type' => 'Negeri',
                'city' => 'Semarang',
                'province' => 'Jawa Tengah',
                'location' => 'Semarang, Jawa Tengah',
                'address' => 'Kampus Undip Tembalang, Jl. Prof. H. Soedarto, S.H., Tembalang, Kota Semarang, Jawa Tengah 50275',
                'status' => 'Active',
                'logo_name' => 'UNDIP_Logo.png',
                'logo_url' => '',
                'logo_text' => 'UNDIP',
                'logo_bg' => 'bg-teal-700',
                'email' => 'humas@undip.ac.id',
                'website' => 'https://www.undip.ac.id',
                'phone' => '024-7474698',
                'description' => 'Universitas Diponegoro (Undip) adalah universitas negeri di Semarang dengan 11 fakultas. Terkenal dengan program teknik sipil, perikanan, dan ilmu kelautan yang unggul.',
                'tags' => ['Teknik Sipil', 'Perikanan', 'Kelautan', 'Hukum', 'Ekonomi'],
                'total_students' => 40000,
                'total_faculties' => 11,
                'accreditation' => 'A',
                'founded' => 1957,
                'created_at' => '2024-04-15',
            ],
            [
                'id' => 7,
                'npsn' => '20701321',
                'name' => 'Universitas Hasanuddin',
                'type' => 'Negeri',
                'institution_type' => 'Negeri',
                'city' => 'Makassar',
                'province' => 'Sulawesi Selatan',
                'location' => 'Makassar, Sulawesi Selatan',
                'address' => 'Kampus UNHAS Tamalanrea, Jl. Perintis Kemerdekaan Km.10, Tamalanrea, Kota Makassar, Sulawesi Selatan 90245',
                'status' => 'Active',
                'logo_name' => 'UNHAS_Logo.png',
                'logo_url' => '',
                'logo_text' => 'UNHAS',
                'logo_bg' => 'bg-sky-700',
                'email' => 'humas@unhas.ac.id',
                'website' => 'https://www.unhas.ac.id',
                'phone' => '0411-585388',
                'description' => 'Universitas Hasanuddin (UNHAS) adalah universitas negeri terbesar di Indonesia Timur. Memiliki 14 fakultas dengan keunggulan di bidang kelautan, pertanian, dan kedokteran.',
                'tags' => ['Kelautan', 'Pertanian', 'Kedokteran', 'Teknik', 'Peternakan'],
                'total_students' => 32000,
                'total_faculties' => 14,
                'accreditation' => 'A',
                'founded' => 1956,
                'created_at' => '2024-05-10',
            ],
        ];
    }

    /**
     * Display a listing of universities with search/filter support.
     */
    public function index(Request $request): View
    {
        $univs = collect($this->getUnivData());

        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $univs = $univs->filter(fn ($u) => str_contains(strtolower($u['name']), $search)
                || str_contains(strtolower($u['npsn']), $search)
                || str_contains(strtolower($u['city']), $search)
                || str_contains(strtolower($u['province']), $search)
                || str_contains(strtolower($u['location']), $search)
            );
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $univs = $univs->filter(fn ($u) => strtolower($u['status']) === strtolower($request->input('status')));
        }

        if ($request->filled('type') && $request->input('type') !== 'all') {
            $univs = $univs->filter(fn ($u) => strtolower($u['type']) === strtolower($request->input('type')));
        }

        if ($request->filled('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'name_asc') {
                $univs = $univs->sortBy('name');
            } elseif ($sort === 'name_desc') {
                $univs = $univs->sortByDesc('name');
            } elseif ($sort === 'region_asc') {
                $univs = $univs->sortBy('city');
            } elseif ($sort === 'region_desc') {
                $univs = $univs->sortByDesc('city');
            } elseif ($sort === 'oldest') {
                $univs = $univs->sortBy('id');
            } else {
                $univs = $univs->sortByDesc('id');
            }
        }

        $perPage = 4;
        $page = (int) $request->input('page', 1);
        $total = $univs->count();
        $offset = ($page - 1) * $perPage;
        $items = $univs->slice($offset, $perPage)->values();

        $paginatedUnivs = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => route('admin.univ.index'), 'query' => $request->query()]
        );

        $totalUnivs = 4650;
        $activePartners = 380;
        $newSubmissions = 25;

        return view('admin.univ.index', [
            'univs' => $paginatedUnivs,
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
     * Store a newly created university (stub — no DB yet).
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

        return redirect()->route('admin.univ.index')
            ->with('success', "Universitas \"{$request->input('name')}\" berhasil ditambahkan.");
    }

    /**
     * Display the specified university.
     */
    public function show(int $id): View
    {
        $univ = collect($this->getUnivData())->firstWhere('id', $id);

        if (! $univ) {
            $univ = $this->getUnivData()[0];
        }

        return view('admin.univ.show', compact('univ'));
    }

    /**
     * Show the form for editing the specified university.
     */
    public function edit(int $id): View
    {
        $univ = collect($this->getUnivData())->firstWhere('id', $id);

        if (! $univ) {
            $univ = $this->getUnivData()[0];
        }

        return view('admin.univ.edit', compact('univ'));
    }

    /**
     * Update the specified university (stub — no DB yet).
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

        return redirect()->route('admin.univ.index')
            ->with('success', "Data universitas \"{$request->input('name')}\" berhasil diperbarui.");
    }

    /**
     * Remove the specified university (stub — no DB yet).
     */
    public function destroy(int $id): RedirectResponse
    {
        $univ = collect($this->getUnivData())->firstWhere('id', $id);
        $name = $univ ? $univ['name'] : 'Universitas';

        return redirect()->route('admin.univ.index')
            ->with('success', "Universitas \"{$name}\" berhasil dihapus.");
    }
}
