<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\AccountApprovedNotification;
use App\Notifications\AccountRejectedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminVerificationController extends Controller
{
    /**
     * Tampilkan daftar pengajuan verifikasi pengguna & institusi.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Filter status (default 'pending' jika tidak diset secara spesifik)
        $statusFilter = strtolower($request->query('status', 'pending'));
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        // Filter Tipe / Role
        if ($request->filled('type') && strtolower($request->query('type')) !== 'all') {
            $type = strtolower($request->query('type'));
            $query->where(function ($q) use ($type) {
                if ($type === 'school') {
                    $q->whereIn('role', ['school', 'school_admin']);
                } elseif ($type === 'university') {
                    $q->whereIn('role', ['university', 'univ_rep']);
                } elseif ($type === 'company') {
                    $q->whereIn('role', ['company', 'company_hr']);
                } elseif ($type === 'user') {
                    $q->where('role', 'user');
                } else {
                    $q->where('role', 'like', "%{$type}%");
                }
            });
        }

        // Search Query (Nama, Email, Role, Kontak, HP)
        if ($request->filled('q')) {
            $q = trim($request->query('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('role', 'like', "%{$q}%")
                    ->orWhere('org_contact', 'like', "%{$q}%")
                    ->orWhere('org_phone', 'like', "%{$q}%");
            });
        }

        $users = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        // Count Summary Stats
        $pendingCount = User::where('status', 'pending')->count();
        $approvedCount = User::whereIn('status', ['active', 'Approved'])->count();
        $rejectedCount = User::whereIn('status', ['rejected', 'Rejected'])->count();
        $totalCount = User::count();

        return view('admin.verification.index', [
            'requests' => $users,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'totalCount' => $totalCount,
            'activeType' => $request->query('type', 'all'),
            'activeStatus' => $statusFilter,
            'searchQuery' => $request->query('q', ''),
        ]);
    }

    /**
     * Setujui / Approve pengajuan verifikasi user.
     */
    public function approve(User $user): RedirectResponse
    {
        $user->status = 'active';
        $user->save();

        $user->notify(new AccountApprovedNotification);

        return back()->with('success', "Akun \"{$user->name}\" berhasil disetujui (Active).");
    }

    /**
     * Tolak / Reject pengajuan verifikasi user.
     */
    public function reject(User $user): RedirectResponse
    {
        $user->status = 'rejected';
        $user->save();

        $user->notify(new AccountRejectedNotification);

        return back()->with('success', "Akun \"{$user->name}\" telah ditolak (Rejected).");
    }

    /**
     * Hapus data pengajuan verifikasi.
     */
    public function destroy(User $user): RedirectResponse
    {
        $name = $user->name;
        $user->delete();

        return back()->with('success', "Data verifikasi \"{$name}\" berhasil dihapus.");
    }
}
