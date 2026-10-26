<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $query = JobApplication::with(['jobListing', 'internship']);

        if ($request->filled('q')) {
            $search = trim($request->query('q'));
            $query->where(function ($sub) use ($search) {
                $sub->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->query('status') !== 'all') {
            $query->where('status', $request->query('status'));
        }

        $applications = $query->orderByDesc('id')->paginate(15)->withQueryString();

        return view('admin.applications.index', [
            'applications' => $applications,
            'totalApplications' => JobApplication::count(),
            'pendingApplications' => JobApplication::where('status', 'pending')->count(),
            'shortlistedApplications' => JobApplication::where('status', 'shortlisted')->count(),
            'searchQuery' => $request->query('q', ''),
            'activeStatus' => $request->query('status', 'all'),
        ]);
    }

    public function update(Request $request, JobApplication $application): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,reviewed,shortlisted,rejected'],
        ]);

        $application->update(['status' => $validated['status']]);

        return back()->with('success', "Status lamaran {$application->full_name} diperbarui.");
    }

    public function resume(JobApplication $application): StreamedResponse
    {
        abort_unless(Storage::disk('local')->exists($application->resume_path), 404);

        return Storage::disk('local')->download(
            $application->resume_path,
            basename($application->resume_path)
        );
    }

    public function destroy(JobApplication $application): RedirectResponse
    {
        $name = $application->full_name;

        Storage::disk('local')->delete($application->resume_path);
        $application->delete();

        return back()->with('success', "Lamaran {$name} berhasil dihapus.");
    }
}
