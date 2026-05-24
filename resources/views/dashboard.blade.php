@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-title">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="dashboard-card">
                <i class="bi bi-calendar2 fs-3" style="color: #3498db;"></i>
                <div class="card-number">{{ $totalEvents }}</div>
                <div class="card-label">Total Events</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="dashboard-card">
                <i class="bi bi-people fs-3" style="color: #27ae60;"></i>
                <div class="card-number">{{ $totalParticipants }}</div>
                <div class="card-label">Total Participants</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="dashboard-card">
                <i class="bi bi-arrow-up-right fs-3" style="color: #f39c12;"></i>
                <div class="card-number">{{ $upcomingEvents }}</div>
                <div class="card-label">Upcoming Events</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="dashboard-card">
                <i class="bi bi-hourglass-split fs-3" style="color: #e74c3c;"></i>
                <div class="card-number">{{ $completedEvents }}</div>
                <div class="card-label">Completed Events</div>
            </div>
        </div>
    </div>

    <!-- Event Status Distribution -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-pie-chart"></i> Event Status Distribution
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                <h5 style="color: #f39c12;">
                                    <i class="bi bi-arrow-up"></i> {{ $upcomingEvents }}
                                </h5>
                                <p class="text-muted">Upcoming Events</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h5 style="color: #e74c3c;">
                                    <i class="bi bi-hourglass-split"></i> {{ $ongoingEvents }}
                                </h5>
                                <p class="text-muted">Ongoing Events</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h5 style="color: #27ae60;">
                                    <i class="bi bi-check-circle"></i> {{ $completedEvents }}
                                </h5>
                                <p class="text-muted">Completed Events</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Events Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-list-check"></i> Recent Events
                    </div>
                    <a href="{{ route('events.create') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-plus-circle"></i> Create Event
                    </a>
                </div>
                <div class="card-body">
                    @if ($recentEvents->isEmpty())
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> No events yet. <a href="{{ route('events.create') }}">Create your
                                first event</a>
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
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentEvents as $event)
                                        <tr>
                                            <td>
                                                <strong>{{ $event->title }}</strong>
                                            </td>
                                            <td>{{ $event->venue }}</td>
                                            <td>{{ $event->formatted_date }}</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $event->participants->count() }} participants
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
                                                <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-info"
                                                    title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('participants.index', $event) }}" class="btn btn-sm btn-primary"
                                                    title="Manage Participants">
                                                    <i class="bi bi-people"></i>
                                                </a>
                                                <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-warning"
                                                    title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('events.destroy', $event) }}" method="POST"
                                                    style="display: inline;"
                                                    onsubmit="return confirm('Are you sure you want to delete this event?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .dashboard-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            margin-bottom: 25px;
        }

        .dashboard-card:hover {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .dashboard-card .card-number {
            font-size: 2.5rem;
            font-weight: bold;
            background: linear-gradient(135deg, #2c3e50, #3498db);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 10px 0;
        }

        .dashboard-card .card-label {
            color: #666;
            font-size: 0.95rem;
            margin-top: 10px;
        }
    </style>
@endsection