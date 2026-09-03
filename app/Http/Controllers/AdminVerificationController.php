<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminVerificationController extends Controller
{
    /** Role institusi yang wajib diverifikasi. */
    private const INSTITUTION_ROLES = ['school', 'university', 'company'];

    public function index(Request $request): View
    {
        $query = User::query()
            ->whereIn('role', self::INSTITUTION_ROLES)
            ->where('status', 'pending');

        // Filter by type
        if ($request->filled('type') && strtolower($request->query('type')) !== 'all') {
            $query->where('role', strtolower($request->query('type')));
        }

        // Search by name
        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->query('q').'%');
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.verification.index', [
            'requests' => $users,
            'activeType' => $request->query('type', 'all'),
            'searchQuery' => $request->query('q', ''),
        ]);
    }

    public function approve(User $user): RedirectResponse
    {
        if (! in_array($user->role, self::INSTITUTION_ROLES, true)) {
            abort(400, 'Role ini tidak perlu verifikasi.');
        }

        $user->update(['status' => 'active']);

        return back()->with('success', "{$user->name} disetujui dan sekarang aktif.");
    }

    public function reject(User $user): RedirectResponse
    {
        if (! in_array($user->role, self::INSTITUTION_ROLES, true)) {
            abort(400, 'Role ini tidak perlu verifikasi.');
        }

        $user->update(['status' => 'rejected']);

        return back()->with('success', "{$user->name} ditolak.");
    }
}
