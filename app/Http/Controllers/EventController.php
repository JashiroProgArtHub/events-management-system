<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventFormRequest;
use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EventController extends Controller
{
    use AuthorizesRequests;

    /**
     * Show all events matching current logged-in admin
     */
    public function index(Request $request): View
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::user();
        
        $search = $request->query('search', '');
        $status = $request->query('status', '');

        // Start querying directly from the relationship with eager loading
        $query = $admin->events()->with(['participants' => function ($query) {
            $query->select('participant_id', 'event_id', 'full_name');
        }]);

        // Search by title
        if (!empty($search)) {
            $query->searchTitle($search);
        }

        // Filter by status
        if (!empty($status) && in_array($status, ['upcoming', 'ongoing', 'done'])) {
            $query->filterStatus($status);
        }

        // Appends current search/filter variables into page links automatically
        $events = $query->orderBy('event_date', 'desc')->paginate(10)->withQueryString();

        return view('events.index', [
            'events' => $events,
            'search' => $search,
            'status' => $status,
        ]);
    }

    /**
     * Show the form to create a new event
     */
    public function create(): View
    {
        return view('events.create');
    }

    /**
     * Store a new event
     */
    public function store(EventFormRequest $request): RedirectResponse
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::user();

        // Save directly through relationship to automatically inject admin_id
        $admin->events()->create([
            'title' => $request->title,
            'description' => $request->description,
            'venue' => $request->venue,
            'event_date' => $request->event_date,
        ]);

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully!');
    }

    /**
     * Show event details with participants
     */
    public function show(Event $event): View
    {
        $this->authorize('view', $event);

        $event->load('participants');

        return view('events.show', compact('event'));
    }

    /**
     * Show the form to edit an event
     */
    public function edit(Event $event): View
    {
        $this->authorize('update', $event);

        return view('events.edit', compact('event'));
    }

    /**
     * Update an event
     */
    public function update(EventFormRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'venue' => $request->venue,
            'event_date' => $request->event_date,
        ]);

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully!');
    }

    /**
     * Delete an event
     */
    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);

        /** @var \App\Models\Event $event */
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully!');
    }
}