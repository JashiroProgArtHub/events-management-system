@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
    <div class="page-title">
        <i class="bi bi-pencil-square"></i>
        <span>Edit Event</span>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-calendar2-plus"></i> {{ $event->title }}
                </div>
                <div class="card-body">
                    <form action="{{ route('events.update', $event) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label" for="title">Event Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title', $event->title) }}" placeholder="Enter event title"
                                required>
                            @error('title')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label" for="description">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="5" placeholder="Enter detailed event description"
                                required>{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Venue -->
                        <div class="mb-3">
                            <label class="form-label" for="venue">Venue *</label>
                            <input type="text" class="form-control @error('venue') is-invalid @enderror" id="venue"
                                name="venue" value="{{ old('venue', $event->venue) }}" placeholder="Enter event venue"
                                required>
                            @error('venue')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date and Time -->
                        <div class="mb-3">
                            <label class="form-label" for="event_date">Date & Time *</label>
                            <input type="datetime-local" class="form-control @error('event_date') is-invalid @enderror"
                                id="event_date" name="event_date"
                                value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required>
                            <small class="text-muted">Use the date/time picker to select the event date and time</small>
                            @error('event_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Status -->
                        <div class="mb-3">
                            <label class="form-label">Current Status</label>
                            <div>
                                @if ($event->isUpcoming())
                                    <span class="badge badge-upcoming badge-lg">Upcoming</span>
                                @elseif ($event->isOngoing())
                                    <span class="badge badge-ongoing badge-lg">Ongoing</span>
                                @else
                                    <span class="badge badge-done badge-lg">Done</span>
                                @endif
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Event
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
                    <i class="bi bi-info-circle"></i> Event Information
                </div>
                <div class="card-body">
                    <p>
                        <strong>Created:</strong><br>
                        {{ $event->created_at->format('M d, Y H:i') }}
                    </p>
                    <p>
                        <strong>Last Updated:</strong><br>
                        {{ $event->updated_at->format('M d, Y H:i') }}
                    </p>
                    <p>
                        <strong>Total Participants:</strong><br>
                        {{ $event->participants->count() }}
                    </p>
                    <hr>
                    <a href="{{ route('participants.index', $event) }}" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-people"></i> Manage Participants
                    </a>
                    <a href="{{ route('events.show', $event) }}" class="btn btn-info btn-sm w-100 mt-2">
                        <i class="bi bi-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection