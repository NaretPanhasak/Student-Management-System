<div class="d-flex justify-content-between align-items-center">
    <span class="text-muted small">Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} students</span>
    {{ $students->links() }}
</div>
