<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    use AuthorizesRequests;

    /**
     * Show the dashboard metrics and recent events
     */
    public function index(): View
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::user();

        // Get total counts utilizing the custom accessors defined in your Admin Model
        $totalEvents = $admin->total_events;
        $totalParticipants = $admin->total_participants;

        // Get status counts using the relation combined with your local event model scopes
        $upcomingEvents = $admin->events()->upcoming()->count();
        $ongoingEvents = $admin->events()->ongoing()->count();
        $completedEvents = $admin->events()->completed()->count();

        // Get the 10 most recent events scoped to this admin
        $recentEvents = $admin->events()
            ->with('participants')
            ->latest() // Shortcut alias for orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('dashboard', [
            'totalEvents' => $totalEvents,
            'totalParticipants' => $totalParticipants,
            'upcomingEvents' => $upcomingEvents,
            'ongoingEvents' => $ongoingEvents,
            'completedEvents' => $completedEvents,
            'recentEvents' => $recentEvents,
        ]);
    }
}