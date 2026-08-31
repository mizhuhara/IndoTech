<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    public function index(Request $request)
    {
        $articles = collect($this->getArticles());

        // Category filter
        $category = $request->query('category', 'All');
        if (strtolower($category) !== 'all') {
            $articles = $articles->filter(function ($article) use ($category) {
                return strtolower($article['category']) === strtolower($category);
            });
        }

        // Search Keyword
        if ($request->filled('q')) {
            $q = strtolower($request->query('q'));
            $articles = $articles->filter(function ($article) use ($q) {
                return str_contains(strtolower($article['title']), $q)
                    || str_contains(strtolower($article['author_name']), $q)
                    || str_contains(strtolower($article['category']), $q)
                    || str_contains(strtolower($article['excerpt']), $q);
            });
        }

        $categories = [
            'All', 'Technology', 'Programming', 'Web Development',
            'Mobile Development', 'AI', 'Cybersecurity', 'Networking',
            'Cloud', 'Database', 'UI/UX', 'Career', 'Education',
        ];

        // Pagination setup
        $perPage = 3;
        $totalItems = $articles->count();
        $totalPages = max(1, (int) ceil($totalItems / $perPage));
        // If "All" category, match the 12 pages in the design
        if (strtolower($category) === 'all' && ! $request->filled('q')) {
            $totalPages = 12;
        }

        $currentPage = max(1, min((int) $request->query('page', 1), $totalPages));

        // Paginate slice
        $paginatedArticles = $articles->slice(($currentPage - 1) * $perPage, $perPage)->values()->all();
        // If current page is beyond slice (e.g. page 2-12 for demo), cycle or fallback to articles
        if (empty($paginatedArticles) && count($articles) > 0) {
            $paginatedArticles = $articles->take($perPage)->values()->all();
        }

        return view('knowladge.index', [
            'articles' => $paginatedArticles,
            'categories' => $categories,
            'activeCategory' => $category,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    public function ai(Request $request)
    {
        $aiTools = collect($this->getAiTools());

        // Category filter (pills or dropdown)
        $category = $request->query('category', 'Semua');
        if (strtolower($category) !== 'semua' && strtolower($category) !== 'semua bidang') {
            $aiTools = $aiTools->filter(function ($tool) use ($category) {
                return strtolower($tool['category']) === strtolower($category);
            });
        }

        if ($request->filled('field') && strtolower($request->query('field')) !== 'semua bidang') {
            $field = strtolower($request->query('field'));
            $aiTools = $aiTools->filter(function ($tool) use ($field) {
                return strtolower($tool['category']) === $field;
            });
        }

        // Search filter
        if ($request->filled('q')) {
            $q = strtolower($request->query('q'));
            $aiTools = $aiTools->filter(function ($tool) use ($q) {
                return str_contains(strtolower($tool['name']), $q)
                    || str_contains(strtolower($tool['description']), $q)
                    || str_contains(strtolower($tool['category']), $q);
            });
        }

        $categories = ['Semua', 'Pemrograman', 'Kesehatan', 'Pertanian'];

        return view('knowladge.ai', [
            'aiTools' => $aiTools->values()->all(),
            'categories' => $categories,
            'activeCategory' => $category,
            'activeField' => $request->query('field', 'Semua Bidang'),
        ]);
    }

    public function aiDetail($id)
    {
        $aiTools = collect($this->getAiTools());
        $tool = $aiTools->firstWhere('id', (int) $id);

        if (! $tool) {
            $tool = $aiTools->firstWhere('id', 1);
        }

        $relatedTools = $aiTools->where('id', '!=', $tool['id'])->take(3)->values()->all();

        return view('knowladge.ai_detail', [
            'tool' => $tool,
            'relatedTools' => $relatedTools,
        ]);
    }

    public function show($id)
    {
        // Redirect legacy article show to AI detail page
        return redirect()->route('knowledge.ai.detail', $id);
    }

    private function getArticles(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'GitHub Copilot: Cara Kerja & Manfaat AI Pair Programmer',
                'category' => 'AI',
                'category_tag' => 'Pemrograman',
                'excerpt' => 'Pelajari bagaimana GitHub Copilot menggunakan model AI canggih untuk membantu pengembang menulis kode 55% lebih cepat langsung dari IDE favorit.',
                'image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&h=500&fit=crop',
                'author_name' => 'Tim IndoTech AI',
                'author_avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=120&h=120&fit=crop',
                'date' => 'Oct 24, 2024',
                'read_time' => '5 min read',
                'ai_tool_id' => 1,
            ],
            [
                'id' => 2,
                'title' => 'Cursor Editor: Membedah Fitur & Keunggulan IDE Berbasis AI',
                'category' => 'Programming',
                'category_tag' => 'Pemrograman',
                'excerpt' => 'Mengenal Cursor, editor kode yang dirancang khusus dari awal dengan integrasi kecerdasan buatan untuk refactoring dan penulisan kode skala besar.',
                'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=500&fit=crop',
                'author_name' => 'Budi Santoso',
                'author_avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=120&h=120&fit=crop',
                'date' => 'Oct 12, 2024',
                'read_time' => '8 min read',
                'ai_tool_id' => 2,
            ],
            [
                'id' => 3,
                'title' => 'IBM Watson Health: Peran Komputasi Kognitif dalam Dunia Medis',
                'category' => 'Cloud',
                'category_tag' => 'Kesehatan',
                'excerpt' => 'Bagaimana sistem AI pemrosesan bahasa alami membantu dokter menganalisis ribuan rekam medis dan data uji klinis secara akurat.',
                'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&h=500&fit=crop',
                'author_name' => 'Siti Rahma',
                'author_avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=120&h=120&fit=crop',
                'date' => 'Oct 10, 2024',
                'read_time' => '6 min read',
                'ai_tool_id' => 3,
            ],
            [
                'id' => 4,
                'title' => 'Zebra Medical Vision: Analisis AI untuk Radiologi & Diagnostik Dini',
                'category' => 'UI/UX',
                'category_tag' => 'Kesehatan',
                'excerpt' => 'Pemanfaatan deep learning untuk mendeteksi anomali radiologis pada pemindaian X-Ray dan CT scan medis secara presisi.',
                'image' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?w=800&h=500&fit=crop',
                'author_name' => 'Arif Wijaya',
                'author_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=120&h=120&fit=crop',
                'date' => 'Oct 08, 2024',
                'read_time' => '6 min read',
                'ai_tool_id' => 4,
            ],
            [
                'id' => 5,
                'title' => 'Prospera Agritech: Visi Komputer untuk Pemantauan Kesehatan Tanaman',
                'category' => 'Technology',
                'category_tag' => 'Pertanian',
                'excerpt' => 'Transformasi sektor pertanian berbasis data dan visi komputer untuk mengoptimalkan penggunaan pupuk dan hasil panen.',
                'image' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=800&h=500&fit=crop',
                'author_name' => 'Hendra Wijaya',
                'author_avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=120&h=120&fit=crop',
                'date' => 'Oct 18, 2024',
                'read_time' => '5 min read',
                'ai_tool_id' => 5,
            ],
            [
                'id' => 6,
                'title' => 'Taranis: Analitik Udara Berpresisi Tinggi Hingga Tingkat Daun',
                'category' => 'Education',
                'category_tag' => 'Pertanian',
                'excerpt' => 'Penggunaan citra udara beresolusi tinggi dan kecerdasan buatan untuk mendeteksi hama dan kekurangan nutrisi tanaman sejak dini.',
                'image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=800&h=500&fit=crop',
                'author_name' => 'Dr. Budi Santoso',
                'author_avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=120&h=120&fit=crop',
                'date' => 'Oct 15, 2024',
                'read_time' => '7 min read',
                'ai_tool_id' => 6,
            ],
        ];
    }

    private function getAiTools(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'GitHub Copilot',
                'category' => 'Pemrograman',
                'icon_type' => 'code',
                'icon_bg' => 'bg-blue-50 text-blue-600',
                'tagline' => 'Asisten Pemrograman AI Berbasis OpenAI Codex & GPT-4',
                'description' => 'Asisten AI berbasis cloud yang menyediakan penyelesaian kode otomatis dan saran arsitektur langsung di editor Anda, mempercepat siklus pengembangan perangkat lunak secara signifikan.',
                'overview' => 'GitHub Copilot adalah alat pasangan pemrogram berbasis AI (AI Pair Programmer) yang dikembangkan oleh GitHub bersama OpenAI. Alat ini terintegrasi langsung ke dalam lingkungan pengembangan (IDE) seperti VS Code, Visual Studio, Neovim, dan JetBrains untuk membantu pengembang menulis kode lebih cepat dan efisien.',
                'what_it_does' => 'Mengkonversi instruksi bahasa alami menjadi kode program executable, menyarankan penyelesaian baris demi baris, membuat pengujian otomatis (unit test), dan menjelaskan alur algoritma yang rumit secara instan.',
                'capabilities' => [
                    [
                        'title' => 'Penyelesaian Kode Otomatis (Autocompletion)',
                        'desc' => 'Menyediakan saran penyelesaian baris atau seluruh blok fungsi secara real-time saat Anda mengetik kode.',
                    ],
                    [
                        'title' => 'Chat & Refactoring di IDE (Copilot Chat)',
                        'desc' => 'Memungkinkan Anda bertanya tentang kode, mendeteksi bug, serta melakukan refactoring langsung di editor.',
                    ],
                    [
                        'title' => 'Pembuatan Dokumen & Unit Test',
                        'desc' => 'Dapat membuat skenario pengujian unit (Unit Testing) dan dokumentasi fungsi secara otomatis.',
                    ],
                    [
                        'title' => 'Dukungan Multi-Bahasa Pemrograman',
                        'desc' => 'Mendukung berbagai bahasa utama seperti Python, JavaScript, TypeScript, PHP, Go, C++, Ruby, dan HTML/CSS.',
                    ],
                ],
                'use_cases' => [
                    'Mempercepat pembuatan REST API dan komponen UI.',
                    'Memahami repositori kode legacy yang besar.',
                    'Mencari rujukan sintaks dan algoritma tanpa harus meninggalkan IDE.',
                ],
                'target_audience' => 'Pengembang Perangkat Lunak, Student Developer, Data Engineer, & Enterprise Tech Team.',
                'url' => 'https://github.com/features/copilot',
                'action_type' => 'detail',
                'pricing' => 'Freemium / Berlangganan',
            ],
            [
                'id' => 2,
                'name' => 'Cursor',
                'category' => 'Pemrograman',
                'icon_type' => 'editor',
                'icon_bg' => 'bg-indigo-50 text-indigo-600',
                'tagline' => 'Editor Kode Generasi Baru dengan Integrasi AI Mendalam',
                'description' => 'Editor kode cerdas yang dibangun khusus dengan integrasi AI tingkat lanjut, memungkinkan modifikasi basis kode skala besar dan refactoring kode secara natural dan intuitif.',
                'overview' => 'Cursor adalah IDE turunan VS Code yang dirancang secara khusus mengutamakan kecerdasan buatan (AI-first). Cursor memungkinkan pengembang melakukan pengeditan basis kode skala besar, bertanya pada seluruh codebase, dan mengedit beberapa file sekaligus menggunakan instruksi bahasa alami.',
                'what_it_does' => 'Cursor menghubungkan kecerdasan LLM (seperti Claude 3.5 Sonnet & GPT-4o) dengan basis kode lokal Anda, sehingga dapat mengedit banyak file dalam satu perintah, memperbaiki error terminal secara otomatis, dan menjawab pertanyaan seputar repositori.',
                'capabilities' => [
                    [
                        'title' => 'Codebase Chat & Context Indexing',
                        'desc' => 'Dapat merujuk pada seluruh struktur proyek Anda (@codebase) untuk menjawab pertanyaan arsitektur secara akurat.',
                    ],
                    [
                        'title' => 'Multi-File Editing (Cmd+K)',
                        'desc' => 'Mengubah dan memperbarui beberapa file sekaligus berdasarkan deskripsi tugas yang Anda berikan.',
                    ],
                    [
                        'title' => 'Terminal Agent & Auto-Fix Error',
                        'desc' => 'Menganalisis pesan kesalahan terminal dan menawarkan perbaikan satu-klik.',
                    ],
                    [
                        'title' => 'Kustomisasi Model AI',
                        'desc' => 'Bebas memilih model LLM terbaik seperti Claude 3.5 Sonnet, GPT-4o, atau model khusus lainnya.',
                    ],
                ],
                'use_cases' => [
                    'Refactoring basis kode monolitik menjadi microservices.',
                    'Pembangunan proyek aplikasi dari awal dalam waktu singkat.',
                    'Perbaikan bug kompleks lintas file.',
                ],
                'target_audience' => 'Fullstack Developer, Lead Engineers, Tech Startup Founders.',
                'url' => 'https://cursor.com',
                'action_type' => 'detail',
                'pricing' => 'Gratis dengan Opsi Pro',
            ],
            [
                'id' => 3,
                'name' => 'IBM Watson Health',
                'category' => 'Kesehatan',
                'icon_type' => 'health',
                'icon_bg' => 'bg-blue-50 text-blue-600',
                'tagline' => 'Sistem Komputasi Kognitif Analisis Data Medis & Klinis',
                'description' => 'Sistem komputasi kognitif yang memproses volume besar data medis untuk membantu profesional klinis dalam diagnosis presisi, perencanaan perawatan, dan penelitian medis mutakhir.',
                'overview' => 'IBM Watson Health memanfaatkan pemrosesan bahasa alami (NLP) dan pembelajaran mesin untuk membantu profesional kesehatan memproses data medis terstruktur dan tidak terstruktur dalam jumlah masif.',
                'what_it_does' => 'Membantu rumah sakit dan lembaga medis dalam menganalisis data rekam medis elektronik, hasil riset ilmiah terbaru, dan citra medis guna mendukung keputusan klinis yang lebih cepat dan tepat.',
                'capabilities' => [
                    [
                        'title' => 'Analisis Dokumen Medis & NLP',
                        'desc' => 'Membaca dan mengidentifikasi informasi penting dari ribuan halaman jurnal medis dan catatan dokter.',
                    ],
                    [
                        'title' => 'Rekomendasi Perawatan Presisi',
                        'desc' => 'Mencocokkan kondisi spesifik pasien dengan opsi terapi dan uji klinis medis terbaru.',
                    ],
                    [
                        'title' => 'Optimalisasi Alur Kerja Klinis',
                        'desc' => 'Meningkatkan efisiensi pengelolaan data kesehatan dan alokasi sumber daya medis.',
                    ],
                ],
                'use_cases' => [
                    'Riset klinis obat baru dan pengobatan kanker.',
                    'Pengolahan data rekam medis terpadu di rumah sakit.',
                    'Dukungan keputusan diagnostik dokter spesialis.',
                ],
                'target_audience' => 'Dokter, Peneliti Medis, Rumah Sakit, & Institusi Kesehatan.',
                'url' => 'https://www.ibm.com/watson-health',
                'action_type' => 'visit',
                'pricing' => 'Lisensi Enterprise Medis',
            ],
            [
                'id' => 4,
                'name' => 'Zebra Medical Vision',
                'category' => 'Kesehatan',
                'icon_type' => 'medical_plus',
                'icon_bg' => 'bg-sky-50 text-sky-600',
                'tagline' => 'Platform Analisis Gambar Medis & Diagnostik Radiologi AI',
                'description' => 'Platform analisis gambar medis yang memanfaatkan deep learning untuk mengidentifikasi anomali radiologis secara otomatis, meningkatkan akurasi deteksi dini penyakit kronis.',
                'overview' => 'Zebra Medical Vision (sekarang bagian dari Nanox) menggunakan algoritma deep learning untuk menganalisis gambar CT scan, X-Ray, dan Mammografi guna mendeteksi kondisi medis serius lebih awal.',
                'what_it_does' => 'Pemindaian gambar medis secara otomatis untuk mendeteksi tanda awal pendarahan otak, penyakit tulang, massa tumor, dan penyakit kardiovaskular.',
                'capabilities' => [
                    [
                        'title' => 'Deteksi Anomali Radiologis Otomatis',
                        'desc' => 'Memberikan indikasi awal dan anotasi visual pada hasil Rontgen dan CT scan pasien.',
                    ],
                    [
                        'title' => 'Integrasi Sistem PACS/DICOM Rumah Sakit',
                        'desc' => 'Terhubung langsung dengan alur kerja departemen radiologi tanpa mengganggu sistem operasional.',
                    ],
                    [
                        'title' => 'Skor Risiko Kesehatan Dini',
                        'desc' => 'Menghitung tingkat keparahan anomali untuk menentukan prioritas penanganan medis.',
                    ],
                ],
                'use_cases' => [
                    'Screening kesehatan massal di laboratorium radiologi.',
                    'Deteksi dini penyakit kronis seperti osteoporosis dan osteoartritis.',
                    'Triase darurat pasien trauma di UGD.',
                ],
                'target_audience' => 'Dokter Radiologi, Laboratorium Klinis, Rumah Sakit.',
                'url' => 'https://www.nanox.vision',
                'action_type' => 'visit',
                'pricing' => 'Platform Berlangganan Klinis',
            ],
            [
                'id' => 5,
                'name' => 'Prospera',
                'category' => 'Pertanian',
                'icon_type' => 'agri',
                'icon_bg' => 'bg-cyan-50 text-cyan-600',
                'tagline' => 'Solusi Agritech Cerdas Pemantauan Kesehatan Tanaman',
                'description' => 'Solusi agritech cerdas yang menggabungkan visi komputer dan machine learning untuk memantau kesehatan tanaman harian, memprediksi hasil panen, dan mengoptimalkan penggunaan sumber daya.',
                'overview' => 'Prospera adalah platform teknologi pertanian (agritech) yang menggunakan penginderaan jarak jauh, AI, dan visi komputer untuk membantu petani membuat keputusan berbasis data di lapangan.',
                'what_it_does' => 'Mengidentifikasi penyakit tanaman, serangan hama, dan kekurangan air/pupuk secara real-time dari data visual lapangan.',
                'capabilities' => [
                    [
                        'title' => 'Pemantauan Visual Lahan Harian',
                        'desc' => 'Menganalisis perkembangan kesehatan dedaunan dan buah tanaman menggunakan kamera sensor.',
                    ],
                    [
                        'title' => 'Prediksi Hasil Panen & Tonase',
                        'desc' => 'Memberikan estimasi kuantitas hasil panen berdasarkan tren pertumbuhan harian.',
                    ],
                    [
                        'title' => 'Efisiensi Pupuk & Irigasi',
                        'desc' => 'Menyarankan jadwal dan dosis penyiraman serta pemupukan yang paling tepat.',
                    ],
                ],
                'use_cases' => [
                    'Manajemen perkebunan skala sedang hingga industri.',
                    'Pencegahan penyakit tanaman pangan sebelum menyebar luas.',
                    'Optimasi penggunaan air irigasi di daerah kering.',
                ],
                'target_audience' => 'Petani Modern, Agronomis, Pengelola Perkebunan Industri.',
                'url' => 'https://prospera.ag',
                'action_type' => 'detail',
                'pricing' => 'Paket Layanan Agritech',
            ],
            [
                'id' => 6,
                'name' => 'Taranis',
                'category' => 'Pertanian',
                'icon_type' => 'leaf',
                'icon_bg' => 'bg-teal-50 text-teal-600',
                'tagline' => 'Analisis Pertanian Presisi Tingkat Daun Berbasis Citra Udara',
                'description' => 'Layanan analitik pertanian presisi yang menggunakan citra resolusi sangat tinggi dari udara untuk mendeteksi ancaman hama, gulma, dan kekurangan nutrisi hingga tingkat daun individu.',
                'overview' => 'Taranis menyediakan platform intelijen tanaman yang memanfaatkan citra udara beresolusi ultra-tinggi (diambil dari drone dan pesawat) untuk mendeteksi ancaman di lahan pertanian hingga ke tingkat detail daun individu.',
                'what_it_does' => 'Memberikan laporan analisis kondisi fisik tanaman secara menyeluruh untuk mencegah gagal panen.',
                'capabilities' => [
                    [
                        'title' => 'Sub-Millimeter Aerial Imaging',
                        'desc' => 'Kamera udara resolusi tinggi yang mampu memotret detail spesies serangga atau bintik daun.',
                    ],
                    [
                        'title' => 'Klasifikasi Gulma & Hama Otomatis',
                        'desc' => 'Jaringan AI mengenali jenis gulma spesifik untuk menentukan jenis pestisida yang tepat.',
                    ],
                    [
                        'title' => 'Peta Panas (Heatmap) Kesehatan Lahan',
                        'desc' => 'Visualisasi bagian lahan mana yang membutuhkan perhatian ekstra dari agronomis.',
                    ],
                ],
                'use_cases' => [
                    'Survei ketersediaan nutrisi tanah dan tanaman.',
                    'Deteksi serangan hama mendadak di lahan seluas puluhan hektar.',
                    'Perencanaan pemeliharaan tanaman berkala.',
                ],
                'target_audience' => 'Agronomis, Konsultan Pertanian, Pemilik Lahan Agribisnis.',
                'url' => 'https://taranis.ag',
                'action_type' => 'detail',
                'pricing' => 'Layanan Analisis Per Hektar',
            ],
        ];
    }
}
