<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminEventController extends Controller
{
    /**
     * Display a listing of events with filters, search, and pagination.
     */
    public function index(Request $request): View
    {
        $query = Event::query();

        // Status filter
        $status = strtolower($request->query('status', 'all'));
        if ($status !== 'all' && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', ucfirst($status));
        }

        // Type filter
        $activeType = strtolower($request->query('type', 'all'));
        if ($activeType !== 'all') {
            $query->whereRaw('LOWER(organizer_type) = ?', [$activeType]);
        }

        // Search
        $searchQuery = trim($request->query('q', ''));
        if (! empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                    ->orWhere('organizer', 'like', "%{$searchQuery}%")
                    ->orWhere('category', 'like', "%{$searchQuery}%")
                    ->orWhere('location', 'like', "%{$searchQuery}%");
            });
        }

        $events = $query->orderByDesc('id')->paginate(10)->withQueryString();

        return view('admin.events.index', [
            'events' => $events,
            'activeType' => $activeType,
            'activeStatus' => $status,
            'searchQuery' => $searchQuery,
            'totalEntries' => Event::count(),
            'pendingCount' => Event::where('status', 'Pending')->count(),
            'approvedCount' => Event::where('status', 'Approved')->count(),
            'rejectedCount' => Event::where('status', 'Rejected')->count(),
        ]);
    }

    /**
     * Display details of a specific event.
     */
    public function show(int $id): View|RedirectResponse
    {
        $event = Event::find($id);

        if (! $event) {
            return redirect()->route('admin.events.index')
                ->with('error', 'Event tidak ditemukan.');
        }

        return view('admin.events.show', compact('event'));
    }

    /**
     * Approve an event request.
     */
    public function approve(int $id): RedirectResponse
    {
        $event = Event::findOrFail($id);
        $event->update([
            'status' => 'Approved',
            'is_verified' => true,
        ]);

        return redirect()->back()
            ->with('success', "Event '{$event->title}' telah berhasil disetujui (Approved).");
    }

    /**
     * Reject an event request.
     */
    public function reject(int $id): RedirectResponse
    {
        $event = Event::findOrFail($id);
        $event->update([
            'status' => 'Rejected',
            'is_verified' => false,
        ]);

        return redirect()->back()
            ->with('success', "Event '{$event->title}' telah ditolak (Rejected).");
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $event = Event::findOrFail($id);
        $title = $event->title;
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', "Event '{$title}' berhasil dihapus dari database.");
    }
}
