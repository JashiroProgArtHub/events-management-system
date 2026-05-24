@extends('layouts.app')

@section('title', 'Events')

@section('content')
    <div class="page-title">
        <i class="bi bi-calendar2"></i>
        <span>Events Management</span>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('events.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Search by event title..."
                            value="{{ $search }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="upcoming" {{ $status === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="ongoing" {{ $status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="done" {{ $status === 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Events Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-list"></i> All Events
                <span class="badge bg-secondary">{{ $events->total() }}</span>
            </div>
            <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Create New Event
            </a>
        </div>
        <div class="card-body">
            @if ($events->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle"></i> No events found. <a href="{{ route('events.create') }}">Create your first
                        event</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Venue</th>
                                <th>Date & Time</th>
                                <th>Participants</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td>
                                        <strong>{{ $event->title }}</strong>
                                    </td>
                                    <td>{{ $event->venue }}</td>
                                    <td>{{ $event->formatted_date }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $event->participants->count() }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($event->isUpcoming())
                                            <span class="badge badge-upcoming">Upcoming</span>
                                        @elseif ($event->isOngoing())
                                            <span class="badge badge-ongoing">Ongoing</span>
                                        @else
                                            <span class="badge badge-done">Done</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $event->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('events.show', $event) }}" class="btn btn-outline-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('participants.index', $event) }}" class="btn btn-outline-primary"
                                                title="Participants">
                                                <i class="bi bi-people"></i>
                                            </a>
                                            <a href="{{ route('events.edit', $event) }}" class="btn btn-outline-warning"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('events.destroy', $event) }}" method="POST"
                                                style="display: inline;"
                                                onsubmit="return confirm('Are you sure you want to delete this event?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-4">
                    {{ $events->appends(request()->query())->links() }}
                </nav>
            @endif
        </div>
    </div>
@endsection