<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminVerificationController extends Controller
{
    public function index(Request $request)
    {
        $requests = collect($this->getVerificationRequests());

        // Type Filter (School, University, Company)
        if ($request->filled('type') && strtolower($request->query('type')) !== 'all') {
            $type = strtolower($request->query('type'));
            $requests = $requests->filter(function ($req) use ($type) {
                return strtolower($req['type']) === $type;
            });
        }

        // Search Filter
        if ($request->filled('q')) {
            $q = strtolower($request->query('q'));
            $requests = $requests->filter(function ($req) use ($q) {
                return str_contains(strtolower($req['name']), $q)
                    || str_contains(strtolower($req['req_id']), $q)
                    || str_contains(strtolower($req['type']), $q);
            });
        }

        $perPage = 3;
        $totalItems = 24;
        $totalPages = 3;
        $currentPage = max(1, (int) $request->query('page', 1));

        $paginatedRequests = $requests->take($perPage)->values()->all();

        return view('admin.verification.index', [
            'requests' => $paginatedRequests,
            'activeType' => $request->query('type', 'All Types'),
            'searchQuery' => $request->query('q', ''),
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalPendingCount' => $totalItems,
        ]);
    }

    private function getVerificationRequests(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'SMP N 1 Bali',
                'req_id' => 'REQ-2023-0891',
                'type' => 'School',
                'icon_type' => 'school',
                'date' => 'Oct 24, 2023',
                'time' => '10:42 AM',
                'status' => 'Pending',
                'status_color' => 'bg-slate-100 text-slate-700 font-bold',
            ],
            [
                'id' => 2,
                'name' => 'Universitas Indonesia',
                'req_id' => 'REQ-2023-0890',
                'type' => 'University',
                'icon_type' => 'university',
                'date' => 'Oct 23, 2023',
                'time' => '03:15 PM',
                'status' => 'Pending',
                'status_color' => 'bg-slate-100 text-slate-700 font-bold',
            ],
            [
                'id' => 3,
                'name' => 'TechCorp Nusantara',
                'req_id' => 'REQ-2023-0888',
                'type' => 'Company',
                'icon_type' => 'company',
                'date' => 'Oct 21, 2023',
                'time' => '09:30 AM',
                'status' => 'Pending',
                'status_color' => 'bg-slate-100 text-slate-700 font-bold',
            ],
        ];
    }
}
