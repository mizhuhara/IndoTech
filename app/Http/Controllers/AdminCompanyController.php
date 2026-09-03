<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class AdminCompanyController extends Controller
{
    /**
     * Centralized company data store.
     *
     * @return array<int, array<string, mixed>>
     */
    private function getCompaniesData(): array
    {
        return [
            [
                'id' => 1,
                'npsn' => 'CMP001',
                'name' => 'PT. Telekomunikasi Indonesia Tbk',
                'type' => 'BUMN',
                'industry' => 'Telekomunikasi',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'location' => 'Bandung, Jawa Barat',
                'address' => 'Jl. Japati No.1, Cibaduyut, Kec. Bojongloa Kidul, Kota Bandung, Jawa Barat 40212',
                'status' => 'Active',
                'logo_name' => 'Telkom_Logo.png',
                'logo_url' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'TELKOM',
                'logo_bg' => 'bg-blue-700',
                'email' => 'corporate@telkom.co.id',
                'website' => 'https://www.telkom.co.id',
                'phone' => '022-7510000',
                'description' => 'PT. Telekomunikasi Indonesia Tbk (Telkom) adalah perusahaan telekomunikasi dan jasa jaringan terbesar di Indonesia. Telkom menyediakan layanan telepon tetap, seluler, internet, dan layanan data serta komunikasi lainnya.',
                'tags' => ['Telekomunikasi', 'Digital', 'Infrastruktur', 'BUMN'],
                'total_employees' => 24000,
                'founded' => 1965,
                'created_at' => '2024-01-15',
            ],
            [
                'id' => 2,
                'npsn' => 'CMP002',
                'name' => 'PT. Bank Rakyat Indonesia (Persero) Tbk',
                'type' => 'BUMN',
                'industry' => 'Perbankan',
                'city' => 'Jakarta Pusat',
                'province' => 'DKI Jakarta',
                'location' => 'Jakarta Pusat, DKI Jakarta',
                'address' => 'Jl. Jenderal Sudirman Kav.44-46, RT.2/RW.1, Kuningan Tim., Kec. Setiabudi, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12930',
                'status' => 'Active',
                'logo_name' => 'BRI_Logo.png',
                'logo_url' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'BRI',
                'logo_bg' => 'bg-yellow-600',
                'email' => 'callcenter@bri.co.id',
                'website' => 'https://www.bri.co.id',
                'phone' => '14017',
                'description' => 'PT. Bank Rakyat Indonesia (Persero) Tbk (BRI) adalah salah satu bank terbesar di Indonesia yang berfokus pada segmentasi mikro, kecil, dan menengah (UMKM). BRI memiliki jaringan kantor cabang dan unit terpadu yang luas di seluruh Indonesia.',
                'tags' => ['Perbankan', 'UMKM', 'BUMN', 'Keuangan'],
                'total_employees' => 58000,
                'founded' => 1895,
                'created_at' => '2024-02-10',
            ],
            [
                'id' => 3,
                'npsn' => 'CMP003',
                'name' => 'PT. Gojek Indonesia',
                'type' => 'Swasta',
                'industry' => 'Teknologi & Transportasi',
                'city' => 'Jakarta Selatan',
                'province' => 'DKI Jakarta',
                'location' => 'Jakarta Selatan, DKI Jakarta',
                'address' => 'Gedung GoTo Tower, Jl. Profesional DR. Ide Anak Agung Gde Agung No. 10, RT.1/RW.3, Kuningan, Kec. Setiabudi, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12950',
                'status' => 'Active',
                'logo_name' => 'Gojek_Logo.png',
                'logo_url' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'GOJEK',
                'logo_bg' => 'bg-green-600',
                'email' => 'support@gojek.com',
                'website' => 'https://www.gojek.com',
                'phone' => '021-50884444',
                'description' => 'PT. Gojek Indonesia adalah platform teknologi terkemuka di Asia Tenggara yang menyediakan layanan transportasi, logistik, pembayaran, dan layanan gaya hidup melalui aplikasi super-app GoTo.',
                'tags' => ['Teknologi', 'Transportasi', 'Fintech', 'Super App', 'Startup'],
                'total_employees' => 8000,
                'founded' => 2010,
                'created_at' => '2024-03-05',
            ],
            [
                'id' => 4,
                'npsn' => 'CMP004',
                'name' => 'PT. Astra International Tbk',
                'type' => 'Swasta',
                'industry' => 'Otomotif & Keuangan',
                'city' => 'Jakarta Selatan',
                'province' => 'DKI Jakarta',
                'location' => 'Jakarta Selatan, DKI Jakarta',
                'address' => 'Menara Astra, Jl. Jenderal Sudirman Kav. 5-6, Kuningan, Kec. Setiabudi, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12950',
                'status' => 'Active',
                'logo_name' => 'Astra_Logo.png',
                'logo_url' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'ASTRA',
                'logo_bg' => 'bg-red-700',
                'email' => 'corporate@astra.co.id',
                'website' => 'https://www.astra.co.id',
                'phone' => '021-52326262',
                'description' => 'PT. Astra International Tbk adalah konglomerat terbesar di Indonesia dengan bisnis utama di bidang otomotif, keuangan, pertanian, infrastruktur, dan logistik. Astra adalah distributor mobil Toyota dan Daihatsu di Indonesia.',
                'tags' => ['Otomotif', 'Keuangan', 'Pertanian', 'Infrastruktur', 'Konglomerat'],
                'total_employees' => 230000,
                'founded' => 1957,
                'created_at' => '2024-03-20',
            ],
            [
                'id' => 5,
                'npsn' => 'CMP005',
                'name' => 'PT. Tokopedia',
                'type' => 'Swasta',
                'industry' => 'E-Commerce & Teknologi',
                'city' => 'Jakarta Selatan',
                'province' => 'DKI Jakarta',
                'location' => 'Jakarta Selatan, DKI Jakarta',
                'address' => 'Gedung GoTo Tower, Jl. Profesional DR. Ide Anak Agung Gde Agung No. 10, RT.1/RW.3, Kuningan, Kec. Setiabudi, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12950',
                'status' => 'Active',
                'logo_name' => 'Tokopedia_Logo.png',
                'logo_url' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=120&h=120&q=80',
                'logo_text' => 'TOKOPEDIA',
                'logo_bg' => 'bg-green-700',
                'email' => 'support@tokopedia.com',
                'website' => 'https://www.tokopedia.com',
                'phone' => '021-50884444',
                'description' => 'PT. Tokopedia adalah perusahaan teknologi Indonesia yang mengoperasikan platform e-commerce terbesar di Indonesia. Sekarang bergabung dengan Gojek di bawah induk GoTo Group.',
                'tags' => ['E-Commerce', 'Teknologi', 'Marketplace', 'Startup', 'GoTo'],
                'total_employees' => 6000,
                'founded' => 2009,
                'created_at' => '2024-04-01',
            ],
            [
                'id' => 6,
                'npsn' => 'CMP006',
                'name' => 'PT. Pertamina (Persero)',
                'type' => 'BUMN',
                'industry' => 'Migas & Energi',
                'city' => 'Jakarta Pusat',
                'province' => 'DKI Jakarta',
                'location' => 'Jakarta Pusat, DKI Jakarta',
                'address' => 'Jl. Medan Merdeka Timur No.1A, RT.1/RW.2, Gambir, Kec. Gambir, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10110',
                'status' => 'Active',
                'logo_name' => 'Pertamina_Logo.png',
                'logo_url' => '',
                'logo_text' => 'PERTAMINA',
                'logo_bg' => 'bg-red-800',
                'email' => 'corporate.secretary@pertamina.com',
                'website' => 'https://www.pertamina.com',
                'phone' => '021-3146800',
                'description' => 'PT. Pertamina (Persero) adalah perusahaan BUMN yang bergerak di bidang minyak dan gas bumi (migas) serta energi baru terbarukan. Pertamina mengelola penambangan, pengolahan, hingga distribusi bahan bakar di Indonesia.',
                'tags' => ['Migas', 'Energi', 'BUMN', 'Bahan Bakar', 'Renewable Energy'],
                'total_employees' => 35000,
                'founded' => 1968,
                'created_at' => '2024-04-15',
            ],
            [
                'id' => 7,
                'npsn' => 'CMP007',
                'name' => 'PT. Bukalapak.com',
                'type' => 'Swasta',
                'industry' => 'E-Commerce & Fintech',
                'city' => 'Jakarta Selatan',
                'province' => 'DKI Jakarta',
                'location' => 'Jakarta Selatan, DKI Jakarta',
                'address' => 'Cyber 2 Tower, 17th Floor, Jl. HR. Rasuna Said Blok X-5 Kav. 13, Kuningan, Kec. Setiabudi, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12950',
                'status' => 'Active',
                'logo_name' => 'Bukalapak_Logo.png',
                'logo_url' => '',
                'logo_text' => 'BUKALAPAK',
                'logo_bg' => 'bg-orange-600',
                'email' => 'support@bukalapak.com',
                'website' => 'https://www.bukalapak.com',
                'phone' => '021-50818888',
                'description' => 'PT. Bukalapak.com adalah platform e-commerce dan fintech Indonesia yang membantu mitra usaha mikro dan kecil (UMK) untuk berdigitalisasi. BukaWarung dan BukaModal adalah produk unggulannya.',
                'tags' => ['E-Commerce', 'Fintech', 'UMKM', 'Startup', 'Digitalisasi'],
                'total_employees' => 3000,
                'founded' => 2010,
                'created_at' => '2024-05-10',
            ],
        ];
    }

    /**
     * Display a listing of companies with search/filter support.
     */
    public function index(Request $request): View
    {
        $companies = collect($this->getCompaniesData());

        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $companies = $companies->filter(fn ($c) => str_contains(strtolower($c['name']), $search)
                || str_contains(strtolower($c['npsn']), $search)
                || str_contains(strtolower($c['city']), $search)
                || str_contains(strtolower($c['province']), $search)
                || str_contains(strtolower($c['industry']), $search)
                || str_contains(strtolower($c['location']), $search)
            );
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $companies = $companies->filter(fn ($c) => strtolower($c['status']) === strtolower($request->input('status')));
        }

        if ($request->filled('type') && $request->input('type') !== 'all') {
            $companies = $companies->filter(fn ($c) => strtolower($c['type']) === strtolower($request->input('type')));
        }

        if ($request->filled('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'name_asc') {
                $companies = $companies->sortBy('name');
            } elseif ($sort === 'name_desc') {
                $companies = $companies->sortByDesc('name');
            } elseif ($sort === 'region_asc') {
                $companies = $companies->sortBy('city');
            } elseif ($sort === 'region_desc') {
                $companies = $companies->sortByDesc('city');
            } elseif ($sort === 'oldest') {
                $companies = $companies->sortBy('id');
            } else {
                $companies = $companies->sortByDesc('id');
            }
        }

        $perPage = 4;
        $page = (int) $request->input('page', 1);
        $total = $companies->count();
        $offset = ($page - 1) * $perPage;
        $items = $companies->slice($offset, $perPage)->values();

        $paginatedCompanies = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => route('admin.company.index'), 'query' => $request->query()]
        );

        $totalCompanies = 1250;
        $activePartners = 890;
        $newSubmissions = 15;

        return view('admin.company.index', [
            'companies' => $paginatedCompanies,
            'totalCompanies' => $totalCompanies,
            'activePartners' => $activePartners,
            'newSubmissions' => $newSubmissions,
        ]);
    }

    /**
     * Show the form for creating a new company.
     */
    public function create(): View
    {
        return view('admin.company.create');
    }

    /**
     * Store a newly created company (stub — no DB yet).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'npsn' => ['required', 'string', 'max:20'],
            'type' => ['required', 'string'],
            'industry' => ['required', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        return redirect()->route('admin.company.index')
            ->with('success', "Perusahaan \"{$request->input('name')}\" berhasil ditambahkan.");
    }

    /**
     * Display the specified company.
     */
    public function show(int $id): View
    {
        $company = collect($this->getCompaniesData())->firstWhere('id', $id);

        if (! $company) {
            $company = $this->getCompaniesData()[0];
        }

        return view('admin.company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit(int $id): View
    {
        $company = collect($this->getCompaniesData())->firstWhere('id', $id);

        if (! $company) {
            $company = $this->getCompaniesData()[0];
        }

        return view('admin.company.edit', compact('company'));
    }

    /**
     * Update the specified company (stub — no DB yet).
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'npsn' => ['required', 'string', 'max:20'],
            'type' => ['required', 'string'],
            'industry' => ['required', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        return redirect()->route('admin.company.index')
            ->with('success', "Data perusahaan \"{$request->input('name')}\" berhasil diperbarui.");
    }

    /**
     * Remove the specified company (stub — no DB yet).
     */
    public function destroy(int $id): RedirectResponse
    {
        $company = collect($this->getCompaniesData())->firstWhere('id', $id);
        $name = $company ? $company['name'] : 'Perusahaan';

        return redirect()->route('admin.company.index')
            ->with('success', "Perusahaan \"{$name}\" berhasil dihapus.");
    }
}
