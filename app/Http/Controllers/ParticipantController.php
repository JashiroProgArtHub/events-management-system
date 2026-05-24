<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticipantFormRequest;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParticipantController extends Controller
{
    use AuthorizesRequests;

    /**
     * Show all participants for a specific event
     */
    public function index(Request $request, Event $event): View
    {
        // Authorize: only admin who created the event can view participants
        $this->authorize('view', $event);

        $search = $request->query('search', '');
        $course = $request->query('course', '');
        $yearLevel = $request->query('year_level', '');

        // Start from the event's relationship query builder
        $query = $event->participants();

        // Search by name
        if (!empty($search)) {
            $query->searchName($search);
        }

        // Filter by course
        if (!empty($course)) {
            $query->filterCourse($course);
        }

        // Filter by year level
        if (!empty($yearLevel)) {
            $query->filterYearLevel($yearLevel);
        }

        $participants = $query->orderBy('full_name', 'asc')->paginate(15)->withQueryString();

        // Get unique courses and year levels for filter dropdowns directly from this event's pool
        // Optimized: cache these queries if there are many participants
        $courses = $event->participants()
            ->distinct()
            ->pluck('course')
            ->sort()
            ->values();

        $yearLevels = $event->participants()
            ->distinct()
            ->pluck('year_level')
            ->sort()
            ->values();

        return view('participants.index', [
            'event' => $event,
            'participants' => $participants,
            'search' => $search,
            'course' => $course,
            'yearLevel' => $yearLevel,
            'courses' => $courses,
            'yearLevels' => $yearLevels,
        ]);
    }

    /**
     * Show the form to add a participant to an event
     */
    public function create(Event $event): View
    {
        $this->authorize('create', $event);

        return view('participants.create', compact('event'));
    }

    /**
     * Store a new participant
     */
    public function store(ParticipantFormRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('create', $event);

        // Natively creating through relationship automatically sets the event_id foreign key
        $event->participants()->create([
            'full_name' => $request->full_name,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
        ]);

        return redirect()->route('participants.index', $event)
            ->with('success', 'Participant added successfully!');
    }

    /**
     * Show the form to edit a participant
     */
    public function edit(Event $event, Participant $participant): View
    {
        $this->authorize('update', $event);

        // Quick relational safety boundary
        if ($participant->event_id !== $event->event_id) {
            abort(404);
        }

        return view('participants.edit', compact('event', 'participant'));
    }

    /**
     * Update a participant
     */
    public function update(ParticipantFormRequest $request, Event $event, Participant $participant): RedirectResponse
    {
        $this->authorize('update', $event);

        if ($participant->event_id !== $event->event_id) {
            abort(404);
        }

        $participant->update([
            'full_name' => $request->full_name,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
        ]);

        return redirect()->route('participants.index', $event)
            ->with('success', 'Participant updated successfully!');
    }

    /**
     * Delete a participant
     */
    public function destroy(Event $event, Participant $participant): RedirectResponse
    {
        $this->authorize('update', $event);

        if ($participant->event_id !== $event->event_id) {
            abort(404);
        }

        $participant->delete();

        return redirect()->route('participants.index', $event)
            ->with('success', 'Participant deleted successfully!');
    }
}