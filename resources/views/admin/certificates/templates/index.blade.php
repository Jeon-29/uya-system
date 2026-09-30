@extends('layouts.admin')

@section('title', 'Certificate Templates - Admin Dashboard')

@section('content')
    <div class="container-fluid p-0">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-bold text-white mb-1">Certificate Templates</h4>
                <p class="text-subtle small mb-0">Create and manage visual templates for activity certificates.</p>
            </div>
            <a href="{{ route('admin.certificates.templates.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                <i class="fa-solid fa-plus me-1.5"></i> Create New Template
            </a>
        </div>

        <div class="row g-4 mb-4">
            @forelse($templates as $template)
                <div class="col-xl-4 col-md-6">
                    <div class="card p-3 border-0 h-100 d-flex flex-column justify-content-between" style="background-color: var(--admin-card-bg); border-radius: 14px;">
                        <div>
                            <!-- Template Image Preview -->
                            <div class="rounded-3 overflow-hidden mb-3 border border-secondary border-opacity-25 bg-dark text-center position-relative" style="height: 180px;">
                                <img src="{{ asset('storage/' . $template->background_image_path) }}" alt="{{ $template->title }}" class="w-100 h-100 object-fit-cover">
                                <span class="position-absolute top-0 end-0 m-2 badge bg-dark bg-opacity-75 rounded-pill px-2.5 py-1 text-white border border-secondary border-opacity-25" style="font-size: 0.7rem;">
                                    <i class="fa-solid fa-calendar-check me-1 text-primary"></i> {{ $template->activities_count }} Activities
                                </span>
                            </div>

                            <h5 class="fw-bold text-white mb-1" style="font-size: 1.05rem;">{{ $template->title }}</h5>

                            <div class="text-subtle small mb-3" style="font-size: 0.8rem;">
                                <div><i class="fa-solid fa-signature me-1.5 text-primary"></i> {{ $template->signatory_name ?? 'No Signatory Set' }}</div>
                                @if($template->signatory_title)
                                    <div class="text-muted ms-3" style="font-size: 0.75rem;">{{ $template->signatory_title }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="pt-2 border-top border-white border-opacity-10 d-flex justify-content-between align-items-center">
                            <span class="text-muted small" style="font-size: 0.72rem;">By {{ $template->creator->name ?? 'Admin' }}</span>

                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('admin.certificates.templates.edit', $template->id) }}" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1" style="font-size: 0.78rem;">
                                    <i class="fa-regular fa-pen-to-square me-1"></i> Edit
                                </a>

                                <button type="button"
                                        onclick="promptDeleteModal('{{ route('admin.certificates.templates.destroy', $template->id) }}', '{{ addslashes($template->title) }}')"
                                        class="btn btn-sm btn-outline-danger border-0 rounded-circle"
                                        title="Delete Template"
                                        {{ $template->activities_count > 0 ? 'disabled' : '' }}>
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    <i class="fa-solid fa-certificate fs-1 mb-2 d-block opacity-50 text-primary"></i>
                    <p class="mb-0">No certificate templates created yet.</p>
                </div>
            @endforelse
        </div>

        {{ $templates->links() }}
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteTemplateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content rounded-4 bg-dark text-white border-secondary p-3 text-center">
                <div class="modal-body p-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width: 56px; height: 56px; background-color: rgba(220, 53, 69, 0.15);">
                        <i class="fa-regular fa-trash-can text-danger fa-lg"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Delete Certificate Template?</h5>
                    <p class="text-muted small mb-4">
                        Are you sure you want to delete <strong id="deleteTemplateTitle" class="text-white"></strong>? This action cannot be undone.
                    </p>

                    <form id="deleteTemplateForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-semibold">Yes, Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function promptDeleteModal(actionUrl, title) {
        document.getElementById('deleteTemplateForm').action = actionUrl;
        document.getElementById('deleteTemplateTitle').innerText = title;
        const modal = new bootstrap.Modal(document.getElementById('deleteTemplateModal'));
        modal.show();
    }
</script>
@endpush
