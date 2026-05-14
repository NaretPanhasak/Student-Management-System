@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Attendance Tracking</h2>
            <p class="text-muted">Select a class and date to record daily attendance.</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('attendance.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Select Class</label>
                    <select name="class_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Choose Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $class_id == $class->id ? 'selected' : '' }}>{{ $class->class_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Date</label>
                    <input type="date" name="date" class="form-control" value="{{ $date }}" onchange="this.form.submit()">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    @if($class_id && count($students) > 0)
    <div class="card">
        <form action="{{ route('attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="date" value="{{ $date }}">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold">Student List - {{ $date }}</h5>
                <button type="submit" class="btn btn-success"><i class="bi bi-check-all me-2"></i> Save All Attendance</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Student</th>
                                <th>Student ID</th>
                                <th>Status</th>
                                <th class="pe-4">Remarks (Optional)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            @php $record = $existing_attendance[$student->id] ?? null; @endphp
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">{{ $student->name }}</div>
                                </td>
                                <td>{{ $student->student_id }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="p{{ $student->id }}" value="Present" {{ ($record && $record->status == 'Present') || !$record ? 'checked' : '' }}>
                                        <label class="btn btn-outline-success btn-sm px-3" for="p{{ $student->id }}">Present</label>

                                        <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="l{{ $student->id }}" value="Late" {{ $record && $record->status == 'Late' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-warning btn-sm px-3" for="l{{ $student->id }}">Late</label>

                                        <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="a{{ $student->id }}" value="Absent" {{ $record && $record->status == 'Absent' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-danger btn-sm px-3" for="a{{ $student->id }}">Absent</label>
                                    </div>
                                </td>
                                <td class="pe-4">
                                    <input type="text" name="remarks[{{ $student->id }}]" class="form-control form-control-sm" placeholder="Reason..." value="{{ $record ? $record->remarks : '' }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
    @elseif($class_id)
    <div class="text-center py-5">
        <i class="bi bi-people fs-1 text-muted"></i>
        <p class="text-muted mt-3">No students found in this class.</p>
    </div>
    @endif
</div>
@endsection
