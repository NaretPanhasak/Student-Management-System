@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold">Student Profile</h2>
                <p class="text-muted">Detailed view of academic and personal records.</p>
            </div>
            <div class="gap-2 d-flex">
                <button onclick="window.print()" class="btn btn-outline-secondary">
                    <i class="bi bi-printer me-2"></i> Print to PDF
                </button>
                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i> Edit Profile
                </a>
                <a href="{{ route('students.index') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left me-2"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Profile -->
        <div class="col-md-4">
            <div class="card mb-4 text-center">
                <div class="card-body p-5">
                    @if($student->photo)
                        <img src="{{ asset('storage/' . $student->photo) }}" class="rounded-circle shadow-sm mb-4" style="width: 180px; height: 180px; object-fit: cover; border: 5px solid #fff;">
                    @else
                        <div class="rounded-circle shadow-sm mb-4 mx-auto bg-soft-primary d-flex align-items-center justify-content-center" style="width: 180px; height: 180px; border: 5px solid #fff;">
                            <i class="bi bi-person" style="font-size: 5rem;"></i>
                        </div>
                    @endif
                    <h3 class="fw-bold mb-1">{{ $student->name }}</h3>
                    <p class="text-muted mb-3">{{ $student->student_id }}</p>
                    <div class="badge bg-soft-primary px-3 py-2 fs-6 mb-4">{{ $student->class->class_name }}</div>
                    
                    <div class="border-top pt-4">
                        <div class="row text-start">
                            <div class="col-6 mb-3">
                                <small class="text-muted d-block">Department</small>
                                <span class="fw-bold">{{ $student->department->department_name }}</span>
                            </div>
                            <div class="col-6 mb-3">
                                <small class="text-muted d-block">Gender</small>
                                <span class="fw-bold">{{ $student->gender }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Date of Birth</small>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($student->dob)->format('M d, Y') }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Age</small>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($student->dob)->age }} Years</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Info -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="mb-0 fw-bold">Academic Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small d-block mb-1">Assigned Class</label>
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-soft-success me-3" style="width: 40px; height: 40px;">
                                    <i class="bi bi-building fs-6"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $student->class->class_name }}</h6>
                                    <small class="text-muted">Room: {{ $student->class->room }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small d-block mb-1">Department</label>
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-soft-warning me-3" style="width: 40px; height: 40px;">
                                    <i class="bi bi-briefcase fs-6"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $student->department->department_name }}</h6>
                                    <small class="text-muted">Faculty Member</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="mb-0 fw-bold">Contact & Address</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small d-block mb-1">Email Address</label>
                            <div class="fw-bold"><i class="bi bi-envelope me-2 text-primary"></i> {{ $student->email }}</div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small d-block mb-1">Phone Number</label>
                            <div class="fw-bold"><i class="bi bi-telephone me-2 text-primary"></i> {{ $student->phone }}</div>
                        </div>
                        <div class="col-12">
                            <label class="text-muted small d-block mb-1">Permanent Address</label>
                            <div class="p-3 bg-light rounded" style="min-height: 80px;">
                                {{ $student->address }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
