@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold">Teachers</h2>
                <p class="text-muted">Manage your faculty members and their subjects.</p>
            </div>
            <a href="{{ route('teachers.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus me-2"></i> Add Teacher
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Teacher ID</th>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Contact</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                        <tr>
                            <td class="ps-4"><span class="fw-medium text-primary">{{ $teacher->teacher_id }}</span></td>
                            <td class="fw-bold">{{ $teacher->name }}</td>
                            <td><span class="badge bg-soft-info px-3 py-2 text-primary">{{ $teacher->subject }}</span></td>
                            <td>
                                <div class="small"><i class="bi bi-envelope me-1"></i> {{ $teacher->email }}</div>
                                <div class="small"><i class="bi bi-telephone me-1"></i> {{ $teacher->phone }}</div>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-sm btn-soft-primary me-2">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-soft-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $teacher->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $teacher->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header border-0 pb-0">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center py-4">
                                                <div class="text-danger mb-3" style="font-size: 3rem;">
                                                    <i class="bi bi-exclamation-octagon"></i>
                                                </div>
                                                <h4 class="fw-bold mb-2">Are you sure?</h4>
                                                <p class="text-muted">Do you really want to delete teacher <strong>{{ $teacher->name }}</strong>? This process cannot be undone.</p>
                                            </div>
                                            <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger px-4">Delete Now</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No teachers found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($teachers->hasPages())
        <div class="card-footer bg-white border-top-0">
            {{ $teachers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
