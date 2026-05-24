@extends('layouts.app')

@section('title', 'Participants - ' . $event->title)

@section('content')
    <div class="page-title">
        <i class="bi bi-people"></i>
        <span>Participants - {{ $event->title }}</span>
    </div>

    <!-- Event Info Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-muted">Event Details</h6>
                    <p><strong>{{ $event->title }}</strong></p>
                    <small class="text-muted">{{ $event->formatted_date }}</small>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Venue</h6>
                    <p>{{ $event->venue }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('participants.index', $event) }}" method="GET">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Search by name..."
                            value="{{ $search }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <select name="course" class="form-select">
                            <option value="">All Courses</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course }}" {{ $course === $course ? 'selected' : '' }}>
                                    {{ $course }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <select name="year_level" class="form-select">
                            <option value="">All Year Levels</option>
                            @foreach ($yearLevels as $level)
                                <option value="{{ $level }}" {{ $level === $yearLevel ? 'selected' : '' }}>
                                    {{ $level }}
                                </option>
                            @endforeach
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

    <!-- Participants Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-list"></i> All Participants
                <span class="badge bg-secondary">{{ $participants->total() }}</span>
            </div>
            <a href="{{ route('participants.create', $event) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Add Participant
            </a>
        </div>
        <div class="card-body">
            @if ($participants->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle"></i> No participants added yet. <a
                        href="{{ route('participants.create', $event) }}">Add participants</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Course</th>
                                <th>Year Level</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($participants as $participant)
                                <tr>
                                    <td>
                                        <strong>{{ $participant->full_name }}</strong>
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $participant->email }}">{{ $participant->email }}</a>
                                    </td>
                                    <td>{{ $participant->contact_number }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $participant->course }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $participant->year_level }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $participant->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('participants.edit', [$event, $participant]) }}"
                                                class="btn btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('participants.destroy', [$event, $participant]) }}" method="POST"
                                                style="display: inline;"
                                                onsubmit="return confirm('Are you sure you want to remove this participant?');">
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
                    {{ $participants->appends(request()->query())->links() }}
                </nav>
            @endif
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-4">
        <a href="{{ route('events.show', $event) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Event
        </a>
    </div>
@endsection