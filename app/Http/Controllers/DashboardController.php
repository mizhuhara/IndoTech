<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
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

        return view('admin.dashboards.institution', [
            'title' => 'Dashboard Sekolah',
            'subtitle' => 'Kelola data sekolah milik Anda.',
            'cards' => [
                [
                    'label' => 'Sekolah Saya',
                    'value' => $owned->count().' sekolah',
                    'action' => 'Kelola',
                    'url' => route('admin.schools.index'),
                ],
                [
                    'label' => 'Tambah Sekolah',
                    'value' => '+',
                    'action' => 'Tambah baru',
                    'url' => route('admin.schools.create'),
                ],
            ],
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