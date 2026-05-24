@extends('layouts.app')

@section('title', $event->title)

@section('content')
    <div class="page-title">
        <i class="bi bi-calendar-event"></i>
        <span>{{ $event->title }}</span>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-file-text"></i> Event Details
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="text-muted">Status</h5>
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

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Date & Time</h6>
                            <p class="fs-5">
                                <i class="bi bi-calendar3"></i>
                                {{ $event->event_date->format('l, F d, Y') }}
                            </p>
                            <p>
                                <i class="bi bi-clock"></i>
                                {{ $event->event_date->format('h:i A') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Venue</h6>
                            <p class="fs-5">
                                <i class="bi bi-geo-alt"></i>
                                {{ $event->venue }}
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-4">
                        <h6 class="text-muted">Description</h6>
                        <p>{{ $event->description }}</p>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Created</h6>
                            <p>{{ $event->created_at->format('M d, Y H:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Last Updated</h6>
                            <p>{{ $event->updated_at->format('M d, Y H:i A') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex gap-2">
                        <a href="{{ route('events.edit', $event) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit Event
                        </a>
                        <form action="{{ route('events.destroy', $event) }}" method="POST" style="display: inline;"
                            onsubmit="return confirm('Are you sure you want to delete this event?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Delete Event
                            </button>
                        </form>
                        <a href="{{ route('events.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Events
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Participants Panel -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-people"></i> Participants
                        <span class="badge bg-primary">{{ $event->participants->count() }}</span>
                    </div>
                </div>
                <div class="card-body">
                    @if ($event->participants->isEmpty())
                        <p class="text-muted text-center mb-3">No participants yet</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach ($event->participants->take(5) as $participant)
                                <div class="list-group-item">
                                    <h6 class="mb-1">{{ $participant->full_name }}</h6>
                                    <small class="text-muted">
                                        {{ $participant->course }}<br>
                                        {{ $participant->year_level }}
                                    </small>
                                </div>
                            @endforeach
                        </div>
                        @if ($event->participants->count() > 5)
                            <p class="text-muted mt-2 mb-0 text-center small">
                                +{{ $event->participants->count() - 5 }} more participants
                            </p>
                        @endif
                    @endif

                    <a href="{{ route('participants.index', $event) }}" class="btn btn-primary btn-sm w-100 mt-3">
                        <i class="bi bi-people"></i> Manage All Participants
                    </a>
                </div>
            </div>

            <div class="card mt-3 bg-light">
                <div class="card-header">
                    <i class="bi bi-info-circle"></i> Quick Info
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Total Participants:</strong><br>
                        <span class="badge bg-info">{{ $event->participants->count() }}</span>
                    </p>
                    <p class="mb-2">
                        <strong>Created By:</strong><br>
                        {{ $event->admin->full_name }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection