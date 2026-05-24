@extends('layouts.app')

@section('title', 'Create Event')

@section('content')
    <div class="page-title">
        <i class="bi bi-plus-circle"></i>
        <span>Create New Event</span>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-calendar2-plus"></i> Event Details
                </div>
                <div class="card-body">
                    <form action="{{ route('events.store') }}" method="POST">
                        @csrf

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label" for="title">Event Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}" placeholder="Enter event title" required>
                            @error('title')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label" for="description">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="5" placeholder="Enter detailed event description"
                                required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Venue -->
                        <div class="mb-3">
                            <label class="form-label" for="venue">Venue *</label>
                            <input type="text" class="form-control @error('venue') is-invalid @enderror" id="venue"
                                name="venue" value="{{ old('venue') }}" placeholder="Enter event venue" required>
                            @error('venue')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date and Time -->
                        <div class="mb-3">
                            <label class="form-label" for="event_date">Date & Time *</label>
                            <input type="datetime-local" class="form-control @error('event_date') is-invalid @enderror"
                                id="event_date" name="event_date" value="{{ old('event_date') }}" required>
                            <small class="text-muted">Format: YYYY-MM-DD HH:MM (must be in the future)</small>
                            @error('event_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Create Event
                            </button>
                            <a href="{{ route('events.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Panel -->
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-header">
                    <i class="bi bi-lightbulb"></i> Tips
                </div>
                <div class="card-body">
                    <h6>Best Practices</h6>
                    <ul class="small">
                        <li>Use clear and descriptive event titles</li>
                        <li>Provide detailed descriptions for participants</li>
                        <li>Ensure venue information is accurate</li>
                        <li>Set event dates in advance</li>
                        <li>Event status will auto-update based on date</li>
                    </ul>

                    <h6 class="mt-4">Event Status</h6>
                    <div class="small">
                        <p class="mb-2">
                            <span class="badge badge-upcoming">Upcoming</span> - Date is in the future
                        </p>
                        <p class="mb-2">
                            <span class="badge badge-ongoing">Ongoing</span> - Event is happening today
                        </p>
                        <p class="mb-2">
                            <span class="badge badge-done">Done</span> - Event date has passed
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Set minimum date to today
        document.getElementById('event_date').min = new Date().toISOString().slice(0, 16);
    </script>
@endsection