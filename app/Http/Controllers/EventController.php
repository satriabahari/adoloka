<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // /events?categories=umkm-kuliner,umkm-perkebunan
        $cats = $request->filled('categories')
            ? array_map('trim', explode(',', $request->query('categories')))
            : null;

        $events = Event::query()
            ->with(['media', 'categories'])
            ->upcoming()
            ->when($cats, fn($q) => $q->categories($cats))
            ->paginate(12)
            ->withQueryString();

        return view('events', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load([
            'categories',
            'registrations' => fn($q) => $q->latest(),
            'registrations.media',
        ]);

        return view('event-detail', compact('event'));
    }
}
