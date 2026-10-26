<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a paginated listing of approved events for public users.
     */
    public function index(Request $request): View
    {
        $query = Event::where('status', 'Approved')
            ->where('is_verified', true);

        // Category filter
        $category = $request->query('category', 'all');
        if ($category !== 'all') {
            $query->where('category', $category);
        }

        // Search keyword
        if ($request->filled('q')) {
            $q = trim($request->query('q'));
            $query->where(function ($q2) use ($q) {
                $q2->where('title', 'like', "%{$q}%")
                    ->orWhere('organizer', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%");
            });
        }

        // Location filter
        if ($request->filled('location')) {
            $locations = (array) $request->query('location');
            $query->where(function ($q) use ($locations) {
                foreach ($locations as $loc) {
                    $q->orWhere('location', 'like', "%{$loc}%");
                }
            });
        }

        // Price filter
        if ($request->filled('price')) {
            $prices = (array) $request->query('price');
            $query->where(function ($q) use ($prices) {
                foreach ($prices as $price) {
                    if ($price === 'Free') {
                        $q->orWhereRaw("LOWER(price) = 'free'");
                    } elseif ($price === 'Paid') {
                        $q->orWhereRaw("LOWER(price) != 'free'");
                    }
                }
            });
        }

        // Organizer type filter
        if ($request->filled('organizer_type')) {
            $orgTypes = (array) $request->query('organizer_type');
            $query->whereIn('organizer_type', $orgTypes);
        }

        $events = $query->orderBy('id', 'desc')->paginate(3)->withQueryString();

        $categories = [
            'All', 'Seminar', 'Workshop', 'Webinar', 'Hackathon',
            'Competition', 'Job Fair', 'Tech Meetup', 'Conference', 'Training',
        ];

        return view('event.index', [
            'events' => $events,
            'categories' => $categories,
            'activeCategory' => $category,
        ]);
    }

    /**
     * Display a single event's details (only if approved/verified).
     */
    public function show(Request $request, int $id): View
    {
        $event = Event::where('status', 'Approved')
            ->where('is_verified', true)
            ->findOrFail($id);

        $event->loadLearningAndSpeakers();

        $registeredCount = $event->registrations()->count();
        $registration = $request->user()
            ? $event->registrations()->where('user_id', $request->user()->id)->first()
            : null;
        $isRegistered = $registration !== null;
        $isFull = $event->total_quota > 0 && $registeredCount >= $event->total_quota;

        return view('event.show', [
            'event' => $event,
            'registeredCount' => $registeredCount,
            'registration' => $registration,
            'isRegistered' => $isRegistered,
            'isFull' => $isFull,
        ]);
    }

    public function register(Request $request, Event $event): RedirectResponse
    {
        if ($event->status !== 'Approved' || ! $event->is_verified) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $result = DB::transaction(function () use ($event, $request, $validated) {
            $lockedEvent = Event::whereKey($event->id)->lockForUpdate()->firstOrFail();

            if ($lockedEvent->registrations()->where('user_id', $request->user()->id)->exists()) {
                return 'duplicate';
            }

            if ($lockedEvent->total_quota > 0
                && $lockedEvent->registrations()->count() >= $lockedEvent->total_quota) {
                return 'full';
            }

            $lockedEvent->registrations()->create([
                'user_id' => $request->user()->id,
                ...$validated,
            ]);

            return 'registered';
        });

        if ($result === 'registered') {
            return back()->with('success', "Pendaftaran event \"{$event->title}\" berhasil.");
        }

        return back()->with('error', $result === 'duplicate'
            ? 'Anda sudah terdaftar di event ini.'
            : 'Kuota event sudah penuh.');
    }

    public function cancel(Request $request, Event $event): RedirectResponse
    {
        $deleted = $event->registrations()
            ->where('user_id', $request->user()->id)
            ->delete();

        if ($deleted === 0) {
            return back()->with('error', 'Anda belum terdaftar di event ini.');
        }

        return back()->with('success', "Pendaftaran event \"{$event->title}\" dibatalkan.");
    }
}
