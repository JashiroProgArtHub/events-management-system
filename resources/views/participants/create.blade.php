@extends('layouts.app')

@section('title', 'Add Participant')

@section('content')
    <div class="page-title">
        <i class="bi bi-person-plus"></i>
        <span>Add Participant to {{ $event->title }}</span>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-person-check"></i> Participant Details
                </div>
                <div class="card-body">
                    <form action="{{ route('participants.store', $event) }}" method="POST">
                        @csrf

                        <!-- Full Name -->
                        <div class="mb-3">
                            <label class="form-label" for="full_name">Full Name *</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name"
                                name="full_name" value="{{ old('full_name') }}" placeholder="Enter participant's full name"
                                required autofocus>
                            @error('full_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Course -->
                        <div class="mb-3">
                            <label class="form-label" for="course">Course/Program *</label>
                            <input type="text" class="form-control @error('course') is-invalid @enderror" id="course"
                                name="course" value="{{ old('course') }}" placeholder="e.g., BS Information Technology"
                                required>
                            @error('course')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Year Level -->
                        <div class="mb-3">
                            <label class="form-label" for="year_level">Year Level *</label>
                            <select class="form-select @error('year_level') is-invalid @enderror" id="year_level"
                                name="year_level" required>
                                <option value="">Select Year Level</option>
                                <option value="1st Year" {{ old('year_level') === '1st Year' ? 'selected' : '' }}>1st Year
                                </option>
                                <option value="2nd Year" {{ old('year_level') === '2nd Year' ? 'selected' : '' }}>2nd Year
                                </option>
                                <option value="3rd Year" {{ old('year_level') === '3rd Year' ? 'selected' : '' }}>3rd Year
                                </option>
                                <option value="4th Year" {{ old('year_level') === '4th Year' ? 'selected' : '' }}>4th Year
                                </option>
                            </select>
                            @error('year_level')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label" for="email">Email Address *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" placeholder="participant@student.sao.edu.ph"
                                required>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contact Number -->
                        <div class="mb-3">
                            <label class="form-label" for="contact_number">Contact Number *</label>
                            <input type="tel" class="form-control @error('contact_number') is-invalid @enderror"
                                id="contact_number" name="contact_number" value="{{ old('contact_number') }}"
                                placeholder="09XXXXXXXXX or +63-9XXXXXXXXX" required>
                            @error('contact_number')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Add Participant
                            </button>
                            <a href="{{ route('participants.index', $event) }}" class="btn btn-secondary">
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
                    <i class="bi bi-info-circle"></i> Information
                </div>
                <div class="card-body small">
                    <h6>Event Details</h6>
                    <p class="mb-3">
                        <strong>{{ $event->title }}</strong><br>
                        <span class="text-muted">{{ $event->formatted_date }}</span>
                    </p>

                    <h6>Required Fields</h6>
                    <ul class="mb-3">
                        <li>Full Name</li>
                        <li>Course/Program</li>
                        <li>Year Level</li>
                        <li>Email Address</li>
                        <li>Contact Number</li>
                    </ul>

                    <h6>Tips</h6>
                    <ul>
                        <li>Ensure valid email format</li>
                        <li>Use proper contact number format</li>
                        <li>Double-check participant details</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection