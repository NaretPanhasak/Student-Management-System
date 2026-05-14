@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Dashboard Overview</h2>
            <p class="text-muted">Welcome back! Here's what's happening today.</p>
        </div>
    </div>

    <!-- Stats Cards Row 1 -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body stats-card">
                    <div>
                        <p class="text-muted mb-1">Total Students</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_students'] }}</h3>
                    </div>
                    <div class="stats-icon bg-soft-primary">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body stats-card">
                    <div>
                        <p class="text-muted mb-1">Total Classes</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_classes'] }}</h3>
                    </div>
                    <div class="stats-icon bg-soft-success">
                        <i class="bi bi-building"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body stats-card">
                    <div>
                        <p class="text-muted mb-1">Departments</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_departments'] }}</h3>
                    </div>
                    <div class="stats-icon bg-soft-warning">
                        <i class="bi bi-briefcase"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body stats-card">
                    <div>
                        <p class="text-muted mb-1">Total Teachers</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_teachers'] }}</h3>
                    </div>
                    <div class="stats-icon bg-soft-danger">
                        <i class="bi bi-person-workspace"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row 2 -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body stats-card">
                    <div>
                        <p class="text-muted mb-1">Present Today</p>
                        <h3 class="fw-bold mb-0">{{ $stats['present_today'] }}</h3>
                    </div>
                    <div class="stats-icon bg-soft-info">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-primary text-white shadow-sm">
                <div class="card-body stats-card">
                    <div>
                        <p class="text-white-50 mb-1">Quick Attendance</p>
                        <a href="{{ route('attendance.index') }}" class="text-white fw-bold text-decoration-none">Record Now <i class="bi bi-arrow-right"></i></a>
                    </div>
                    <div class="stats-icon bg-white text-primary">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Students -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Students</h5>
                    <a href="{{ route('students.index') }}" class="btn btn-sm btn-link text-decoration-none">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 border-0">Student</th>
                                    <th class="border-0">ID</th>
                                    <th class="border-0">Class</th>
                                    <th class="border-0">Added</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_students as $student)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($student->photo)
                                                <img src="{{ asset('storage/' . $student->photo) }}" class="student-photo-preview me-3" alt="">
                                            @else
                                                <div class="student-photo-preview me-3 bg-soft-primary d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $student->name }}</div>
                                                <div class="small text-muted">{{ $student->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $student->student_id }}</td>
                                    <td>{{ $student->class->class_name }}</td>
                                    <td>{{ $student->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No students added yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gender Chart -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Gender Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="genderChart" style="max-height: 250px;"></canvas>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('students.create') }}" class="btn btn-primary shadow-sm">
                            <i class="bi bi-person-plus me-2"></i> Add New Student
                        </a>
                        <a href="{{ route('classes.create') }}" class="btn btn-outline-primary shadow-sm">
                            <i class="bi bi-plus-circle me-2"></i> Create New Class
                        </a>
                        <a href="{{ route('departments.create') }}" class="btn btn-outline-secondary shadow-sm">
                            <i class="bi bi-briefcase me-2"></i> Add Department
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('genderChart');
        if(ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Male', 'Female', 'Other'],
                    datasets: [{
                        data: [
                            {{ $stats['male_students'] }}, 
                            {{ $stats['female_students'] }},
                            {{ $stats['total_students'] - ($stats['male_students'] + $stats['female_students']) }}
                        ],
                        backgroundColor: ['#4361ee', '#f72585', '#4cc9f0'],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
