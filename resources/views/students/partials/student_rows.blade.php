@forelse($students as $student)
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
                <div class="small text-muted">{{ $student->gender }}</div>
            </div>
        </div>
    </td>
    <td><span class="fw-medium text-primary">{{ $student->student_id }}</span></td>
    <td>{{ $student->class->class_name }}</td>
    <td>{{ $student->department->department_name }}</td>
    <td>
        <div class="small"><i class="bi bi-envelope me-1"></i> {{ $student->email }}</div>
        <div class="small"><i class="bi bi-telephone me-1"></i> {{ $student->phone }}</div>
    </td>
    <td class="text-end pe-4">
        <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-soft-info me-1" title="View Profile">
            <i class="bi bi-eye"></i>
        </a>
        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-soft-primary me-1" title="Edit">
            <i class="bi bi-pencil"></i>
        </a>
        <button type="button" class="btn btn-sm btn-soft-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $student->id }}" title="Delete">
            <i class="bi bi-trash"></i>
        </button>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
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
                        <p class="text-muted">Do you really want to delete <strong>{{ $student->name }}</strong>? This process cannot be undone.</p>
                    </div>
                    <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST">
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
    <td colspan="6" class="text-center py-5">
        <div class="text-muted">
            <i class="bi bi-search fs-1 d-block mb-3"></i>
            <p>No students found matching your criteria.</p>
        </div>
    </td>
</tr>
@endforelse
