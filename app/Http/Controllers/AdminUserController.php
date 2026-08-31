<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $users = collect($this->getUsers());

        // Search query
        if ($request->filled('q')) {
            $q = strtolower($request->query('q'));
            $users = $users->filter(function ($user) use ($q) {
                return str_contains(strtolower($user['name']), $q)
                    || str_contains(strtolower($user['email']), $q)
                    || str_contains(strtolower($user['role']), $q);
            });
        }

        // Status filter
        if ($request->filled('status') && strtolower($request->query('status')) !== 'all') {
            $status = strtolower($request->query('status'));
            $users = $users->filter(function ($user) use ($status) {
                return strtolower($user['status']) === $status;
            });
        }

        // Role filter
        if ($request->filled('role') && strtolower($request->query('role')) !== 'all') {
            $role = strtolower($request->query('role'));
            $users = $users->filter(function ($user) use ($role) {
                return str_contains(strtolower($user['role']), $role);
            });
        }

        $perPage = 3;
        $totalItems = 24592;
        $totalPages = 12;
        $currentPage = max(1, (int) $request->query('page', 1));

        $paginatedUsers = $users->take($perPage)->values()->all();

        return view('admin.users.index', [
            'users' => $paginatedUsers,
            'totalUsersCount' => number_format($totalItems),
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'activeRole' => $request->query('role', 'all'),
            'activeStatus' => $request->query('status', 'all'),
            'searchQuery' => $request->query('q', ''),
        ]);
    }

    private function getUsers(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Siti Nurhaliza',
                'joined' => '12 Okt 2023',
                'email' => 'siti.n@sekolah.edu',
                'role' => 'School Admin',
                'status' => 'Active',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'avatar_type' => 'image',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=120&h=120&fit=crop',
            ],
            [
                'id' => 2,
                'name' => 'Budi Utama',
                'joined' => '10 Okt 2023',
                'email' => 'budi@universitas.ac.id',
                'role' => 'University Representative',
                'status' => 'Pending',
                'status_color' => 'bg-amber-100 text-amber-700',
                'avatar_type' => 'initials',
                'initials' => 'BU',
                'avatar' => null,
            ],
            [
                'id' => 3,
                'name' => 'Agus Pratama',
                'joined' => '05 Okt 2023',
                'email' => 'agus.p@perusahaan.co.id',
                'role' => 'Company HR',
                'status' => 'Inactive',
                'status_color' => 'bg-red-100 text-red-700',
                'avatar_type' => 'image',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=120&h=120&fit=crop',
            ],
            [
                'id' => 4,
                'name' => 'Dewi Anggraini',
                'joined' => '01 Okt 2023',
                'email' => 'dewi.a@smk1jkt.sch.id',
                'role' => 'School Admin',
                'status' => 'Active',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'avatar_type' => 'image',
                'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=120&h=120&fit=crop',
            ],
            [
                'id' => 5,
                'name' => 'Rizky Kurnia',
                'joined' => '28 Sep 2023',
                'email' => 'rizky.k@techcorp.co.id',
                'role' => 'Company HR',
                'status' => 'Active',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'avatar_type' => 'initials',
                'initials' => 'RK',
                'avatar' => null,
            ],
        ];
    }
}
