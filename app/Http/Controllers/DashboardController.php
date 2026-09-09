<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\JobListing;
use App\Models\School;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan Main Dashboard Super Admin dengan data real-time dari database.
     */
    public function admin(): View
    {
        $calcDelta = function (string $modelClass, ?string $whereColumn = null, mixed $whereValue = null): array {
            $now = now();
            $currentQuery = $modelClass::where('created_at', '>=', $now->copy()->subDays(30));
            $previousQuery = $modelClass::whereBetween('created_at', [$now->copy()->subDays(60), $now->copy()->subDays(30)]);

            if ($whereColumn !== null) {
                $currentQuery->where($whereColumn, $whereValue);
                $previousQuery->where($whereColumn, $whereValue);
            }

            $current = $currentQuery->count();
            $previous = $previousQuery->count();

            if ($previous === 0) {
                if ($current > 0) {
                    return ['delta' => '+100%', 'up' => true];
                }

                return ['delta' => '0%', 'up' => true];
            }

            $pct = (int) round((($current - $previous) / $previous) * 100);

            return [
                'delta' => ($pct >= 0 ? '+' : '').$pct.'%',
                'up' => $pct >= 0,
            ];
        };

        // 1. Stat Cards
        $usersDelta = $calcDelta(User::class);
        $schoolsDelta = $calcDelta(School::class);
        $univsDelta = $calcDelta(University::class);
        $companiesDelta = $calcDelta(Company::class);
        $activeJobsCount = JobListing::where('is_active', true)->count();
        $activeJobsDelta = $calcDelta(JobListing::class, 'is_active', true);

        $stats = [
            [
                'label' => 'Total Users',
                'value' => number_format(User::count()),
                'delta' => $usersDelta['delta'],
                'up' => $usersDelta['up'],
                'icon' => 'users',
                'bg' => 'bg-blue-50',
                'fg' => 'text-blue-600',
            ],
            [
                'label' => 'Schools (SMK)',
                'value' => number_format(School::count()),
                'delta' => $schoolsDelta['delta'],
                'up' => $schoolsDelta['up'],
                'icon' => 'school',
                'bg' => 'bg-sky-50',
                'fg' => 'text-sky-600',
            ],
            [
                'label' => 'University',
                'value' => number_format(University::count()),
                'delta' => $univsDelta['delta'],
                'up' => $univsDelta['up'],
                'icon' => 'university',
                'bg' => 'bg-rose-50',
                'fg' => 'text-rose-500',
            ],
            [
                'label' => 'Company',
                'value' => number_format(Company::count()),
                'delta' => $companiesDelta['delta'],
                'up' => $companiesDelta['up'],
                'icon' => 'company',
                'bg' => 'bg-violet-50',
                'fg' => 'text-violet-600',
            ],
            [
                'label' => 'Active Jobs',
                'value' => number_format($activeJobsCount),
                'delta' => $activeJobsDelta['delta'],
                'up' => $activeJobsDelta['up'],
                'icon' => 'jobs',
                'bg' => 'bg-amber-50',
                'fg' => 'text-amber-600',
            ],
        ];

        // 2. Line Chart: 6 Months New User Registrations
        $monthsData = [];
        $now = now();
        for ($i = 5; $i >= 0; $i--) {
            $dt = $now->copy()->subMonths($i);
            $monthLabel = $dt->format('M');
            $count = User::whereYear('created_at', $dt->year)
                ->whereMonth('created_at', $dt->month)
                ->count();
            $monthsData[] = [
                'label' => $monthLabel,
                'count' => $count,
            ];
        }

        $countsList = array_column($monthsData, 'count');
        $maxCount = max($countsList);
        $lineChartPeriod = "Per month ({$monthsData[0]['label']}–{$monthsData[5]['label']})";
        $lineChartMonths = array_column($monthsData, 'label');

        $lineChartPoints = [];
        foreach ($monthsData as $idx => $m) {
            $x = $idx * 80;
            $y = $maxCount > 0 ? (int) round(125 - (($m['count'] / $maxCount) * 105)) : 125;
            $lineChartPoints[] = [
                'x' => $x,
                'y' => $y,
                'count' => $m['count'],
                'month' => $m['label'],
            ];
        }

        $linePath = "M {$lineChartPoints[0]['x']} {$lineChartPoints[0]['y']}";
        for ($i = 1; $i < count($lineChartPoints); $i++) {
            $prevX = $lineChartPoints[$i - 1]['x'];
            $prevY = $lineChartPoints[$i - 1]['y'];
            $currX = $lineChartPoints[$i]['x'];
            $currY = $lineChartPoints[$i]['y'];

            $dx = ($currX - $prevX) / 2;
            $cp1x = (int) round($prevX + $dx);
            $cp1y = $prevY;
            $cp2x = (int) round($currX - $dx);
            $cp2y = $currY;

            $linePath .= " C {$cp1x} {$cp1y}, {$cp2x} {$cp2y}, {$currX} {$currY}";
        }
        $lineAreaPath = $linePath.' L 400 130 L 0 130 Z';

        // 3. Bar Chart: Regional Distribution
        $provinces = collect()
            ->concat(School::pluck('province'))
            ->concat(University::pluck('province'))
            ->concat(Company::pluck('province'))
            ->filter(fn ($p) => ! empty(trim((string) $p)));

        $regionCounts = [
            'dki' => 0,
            'jabar' => 0,
            'jatim' => 0,
            'jateng_diy' => 0,
            'luar_jawa' => 0,
        ];

        foreach ($provinces as $prov) {
            $p = strtolower(trim((string) $prov));
            if (str_contains($p, 'jakarta')) {
                $regionCounts['dki']++;
            } elseif (str_contains($p, 'barat') && str_contains($p, 'jawa')) {
                $regionCounts['jabar']++;
            } elseif (str_contains($p, 'timur') && str_contains($p, 'jawa')) {
                $regionCounts['jatim']++;
            } elseif (str_contains($p, 'tengah') || str_contains($p, 'yogyakarta') || str_contains($p, 'jogja') || str_contains($p, 'diy')) {
                $regionCounts['jateng_diy']++;
            } else {
                $regionCounts['luar_jawa']++;
            }
        }

        $totalEntities = array_sum($regionCounts);
        $maxRegionCount = max($regionCounts);

        $regions = [
            [
                'label' => 'DKI Jakarta',
                'short' => 'DKI Jakarta',
                'count' => $regionCounts['dki'],
                'val' => ($totalEntities > 0 ? round(($regionCounts['dki'] / $totalEntities) * 100) : 0).'%',
                'h' => ($maxRegionCount > 0 ? round(15 + ($regionCounts['dki'] / $maxRegionCount) * 70) : 15).'%',
                'color' => 'bg-blue-700',
            ],
            [
                'label' => 'Jawa Barat',
                'short' => 'Jawa Barat',
                'count' => $regionCounts['jabar'],
                'val' => ($totalEntities > 0 ? round(($regionCounts['jabar'] / $totalEntities) * 100) : 0).'%',
                'h' => ($maxRegionCount > 0 ? round(15 + ($regionCounts['jabar'] / $maxRegionCount) * 70) : 15).'%',
                'color' => 'bg-blue-600',
            ],
            [
                'label' => 'Jawa Timur',
                'short' => 'Jawa Timur',
                'count' => $regionCounts['jatim'],
                'val' => ($totalEntities > 0 ? round(($regionCounts['jatim'] / $totalEntities) * 100) : 0).'%',
                'h' => ($maxRegionCount > 0 ? round(15 + ($regionCounts['jatim'] / $maxRegionCount) * 70) : 15).'%',
                'color' => 'bg-blue-500',
            ],
            [
                'label' => 'Jawa Tengah',
                'short' => 'Jateng & DIY',
                'count' => $regionCounts['jateng_diy'],
                'val' => ($totalEntities > 0 ? round(($regionCounts['jateng_diy'] / $totalEntities) * 100) : 0).'%',
                'h' => ($maxRegionCount > 0 ? round(15 + ($regionCounts['jateng_diy'] / $maxRegionCount) * 70) : 15).'%',
                'color' => 'bg-blue-400',
            ],
            [
                'label' => 'Luar Jawa',
                'short' => 'Luar Jawa',
                'count' => $regionCounts['luar_jawa'],
                'val' => ($totalEntities > 0 ? round(($regionCounts['luar_jawa'] / $totalEntities) * 100) : 0).'%',
                'h' => ($maxRegionCount > 0 ? round(15 + ($regionCounts['luar_jawa'] / $maxRegionCount) * 70) : 15).'%',
                'color' => 'bg-blue-300',
            ],
        ];

        // 4. Recent Verification Requests
        $recentUsers = User::where('role', '!=', 'super_admin')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $recentRequests = $recentUsers->map(function (User $user) {
            $type = match ($user->role) {
                'school', 'school_admin' => 'Vocational School',
                'university', 'univ_rep' => 'Campus',
                'company', 'company_hr' => 'Company',
                default => 'Individual',
            };

            $statusLower = strtolower($user->status ?? 'pending');
            $badge = match ($statusLower) {
                'active', 'approved' => 'bg-emerald-50 text-emerald-600',
                'rejected' => 'bg-red-50 text-red-600',
                default => 'bg-slate-100 text-slate-600',
            };

            $statusLabel = match ($statusLower) {
                'active', 'approved' => 'Approved',
                'rejected' => 'Rejected',
                default => 'Pending',
            };

            return [
                'name' => $user->name,
                'type' => $type,
                'date' => $user->created_at ? $user->created_at->format('M d, Y') : '—',
                'status' => $statusLabel,
                'badge' => $badge,
            ];
        });

        return view('admin.dashboard', [
            'stats' => $stats,
            'lineChartPeriod' => $lineChartPeriod,
            'lineChartMonths' => $lineChartMonths,
            'lineChartPoints' => $lineChartPoints,
            'linePath' => $linePath,
            'lineAreaPath' => $lineAreaPath,
            'regions' => $regions,
            'recentRequests' => $recentRequests,
        ]);
    }

    /**
     * Redirect login ke dashboard sesuai role.
     */
    public function index(Request $request)
    {
        $route = match ($request->user()->role) {
            'super_admin' => 'admin.dashboard',
            'school' => 'dashboard.school',
            'university' => 'dashboard.university',
            'company' => 'dashboard.company',
            default => 'dashboard.user',
        };

        return redirect()->route($route);
    }

    public function school(): View
    {
        $owned = School::where('user_id', auth()->id())->get();

        $cards = [];
        if ($owned->isNotEmpty()) {
            $cards[] = [
                'label' => 'Sekolah Saya',
                'value' => $owned->first()->name,
                'sub' => 'Status: '.$owned->first()->status,
                'action' => 'Kelola',
                'url' => route('admin.schools.index'),
            ];
        } else {
            $cards[] = [
                'label' => 'Sekolah Saya',
                'value' => 'Belum ada data',
                'sub' => 'Data sekolah Anda sedang diproses.',
                'action' => 'Lihat',
                'url' => route('admin.schools.index'),
            ];
        }

        return view('admin.dashboards.institution', [
            'title' => 'Dashboard Sekolah',
            'subtitle' => 'Kelola data sekolah milik Anda.',
            'cards' => $cards,
        ]);
    }

    public function university(): View
    {
        return view('admin.dashboards.institution', [
            'title' => 'Dashboard Universitas',
            'subtitle' => 'Kelola data universitas milik Anda.',
            'cards' => [
                [
                    'label' => 'Universitas Saya',
                    'value' => 'Kelola',
                    'action' => 'Buka',
                    'url' => route('admin.univ.index'),
                ],
            ],
        ]);
    }

    public function company(): View
    {
        return view('admin.dashboards.institution', [
            'title' => 'Dashboard Perusahaan',
            'subtitle' => 'Kelola data perusahaan milik Anda.',
            'cards' => [
                [
                    'label' => 'Perusahaan Saya',
                    'value' => 'Kelola',
                    'action' => 'Buka',
                    'url' => route('admin.company.index'),
                ],
            ],
        ]);
    }

    public function user(): View
    {
        return view('admin.dashboards.institution', [
            'title' => 'Dashboard Saya',
            'subtitle' => 'Akun pribadi Anda.',
            'cards' => [
                [
                    'label' => 'Profil',
                    'value' => auth()->user()->name,
                    'action' => 'Lihat profil',
                    'url' => '#',
                ],
                [
                    'label' => 'Karir',
                    'value' => 'Cari lowongan',
                    'action' => 'Buka',
                    'url' => route('career.index'),
                ],
            ],
        ]);
    }
}
