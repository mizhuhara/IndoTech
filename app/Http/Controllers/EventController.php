<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
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
    public function show(int $id): View
    {
        $event = Event::where('status', 'Approved')
            ->where('is_verified', true)
            ->findOrFail($id);

        $event->loadLearningAndSpeakers();

        return view('event.show', [
            'event' => $event,
        ]);
    }
}
