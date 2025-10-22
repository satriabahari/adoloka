<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('media')
            ->upcoming()
            ->paginate(12);

        return view('events', compact('events'));
    }

    public function show(Event $event)
    {
        // Eager load registrations dengan media untuk performa lebih baik
        $event->load([
            'registrations' => function ($query) {
                $query->latest();
            },
            'registrations.media'
        ]);

        return view('event-detail', compact('event'));
    }
}
