@extends('layouts.admin')

@section('title', 'Manage Activities - UYA Connect')

@push('styles')
<style>
    .activity-card {
        background-color: var(--admin-card-bg);
        border: 1px solid var(--admin-border);
        border-radius: 16px;
        padding: 22px;
        transition: all 0.2s ease;
    }
    .activity-card:hover {
        border-color: rgba(99, 102, 241, 0.35);
    }

    .badge-status-upcoming { background-color: rgba(99, 102, 241, 0.2); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.4); font-size: 0.7rem; font-weight: 600; padding: 4px 10px; border-radius: 12px; }
    .badge-status-ongoing { background-color: rgba(245, 158, 11, 0.2); color: #fcd34d; border: 1px solid rgba(245, 158, 11, 0.4); font-size: 0.7rem; font-weight: 600; padding: 4px 10px; border-radius: 12px; }
    .badge-status-completed { background-color: rgba(34, 197, 94, 0.2); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.4); font-size: 0.7rem; font-weight: 600; padding: 4px 10px; border-radius: 12px; }
    .badge-status-archived { background-color: rgba(244, 63, 94, 0.2); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.4); font-size: 0.7rem; font-weight: 600; padding: 4px 10px; border-radius: 12px; }

    .tab-pill {
        background-color: transparent;
        border: 1px solid var(--admin-border);
        color: var(--admin-text-muted);
        border-radius: 10px;
        padding: 8px 18px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .tab-pill.active {
        background-color: var(--admin-accent-purple);
        border-color: var(--admin-accent-purple);
        color: #ffffff !important;
    }

    .btn-action-icon { background: transparent; border: none; color: var(--admin-text-subtle); padding: 6px; font-size: 0.95rem; transition: color 0.2s ease; }
    .btn-action-icon:hover { color: #ffffff; }
    .btn-action-icon.danger:hover { color: #fb7185; }

    .btn-purple { background-color: var(--admin-accent-purple); color: #ffffff; border: none; border-radius: 10px; font-weight: 600; font-size: 0.85rem; padding: 9px 18px; transition: background-color 0.2s ease; }
    .btn-purple:hover { background-color: var(--admin-accent-purple-hover); color: #ffffff; }

    .admin-input-group { background-color: var(--admin-card-bg); border: 1px solid var(--admin-border); border-radius: 12px; overflow: hidden; }
    .admin-input-group .form-control { background-color: transparent; border: none; color: #ffffff; font-size: 0.85rem; }
    .admin-input-group .form-control::placeholder { color: var(--admin-text-muted); }
    .admin-input-group .input-group-text { background-color: transparent; border: none; color: var(--admin-text-muted); }

    .admin-modal .modal-content { background-color: var(--admin-card-bg); border: 1px solid var(--admin-border); color: #ffffff; border-radius: 16px; }
    .admin-modal .form-label { font-size: 0.82rem; font-weight: 600; color: #ffffff; }
    .admin-modal .form-control, .admin-modal .form-select { background-color: var(--admin-input-bg); border: 1px solid var(--admin-border); color: #ffffff; border-radius: 10px; font-size: 0.85rem; padding: 10px 14px; }
</style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1 text-white">Manage Activities</h4>
            <p class="text-subtle small mb-0">Create and manage all organization activities</p>
        </div>
        <button type="button" class="btn btn-purple d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createActivityModal">
            <i class="fa-solid fa-plus"></i> Add Activity
        </button>
    </div>

    <!-- Search Input Bar -->
    <div class="mb-3">
        <form method="GET" action="{{ route('admin.activities.index') }}">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <div class="input-group admin-input-group">
                <span class="input-group-text ps-3">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" value="{{ $search }}" class="form-control py-2 shadow-none" placeholder="Search activities...">
                @if($search)
                    <a href="{{ route('admin.activities.index', ['tab' => $tab]) }}" class="btn text-muted d-flex align-items-center pe-3">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Active vs Finished vs Archived Tabs -->
    <div class="d-flex gap-2 mb-4 flex-wrap">
        <a href="{{ route('admin.activities.index', ['tab' => 'active', 'search' => $search]) }}" class="tab-pill {{ $tab === 'active' ? 'active' : '' }}">
            Active Activities ({{ $activeCount }})
        </a>
        <a href="{{ route('admin.activities.index', ['tab' => 'finished', 'search' => $search]) }}" class="tab-pill {{ $tab === 'finished' ? 'active' : '' }}">
            Finished Activities ({{ $finishedCount }})
        </a>
        <a href="{{ route('admin.activities.index', ['tab' => 'archived', 'search' => $search]) }}" class="tab-pill {{ $tab === 'archived' ? 'active' : '' }}">
            Archived ({{ $archivedCount }})
        </a>
    </div>

    @if($tab === 'active')
        <!-- Active Cards Grid View -->
        <div class="row g-4 mb-4">
            @forelse($activities as $activity)
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="activity-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-2 gap-2">
                                <h5 class="fw-bold text-white mb-0" style="font-size: 1.05rem;">{{ $activity->title }}</h5>
                                <span class="badge badge-status-{{ $activity->status }}">{{ ucfirst($activity->status) }}</span>
                            </div>

                            <div class="d-flex flex-column gap-1.5 text-subtle small mb-3" style="font-size: 0.8rem;">
                                <div><i class="fa-regular fa-calendar me-2 opacity-75"></i> {{ $activity->date->format('D, M j, Y') }}</div>
                                <div><i class="fa-regular fa-clock me-2 opacity-75"></i> {{ $activity->date->format('g:i A') }}</div>
                                <div><i class="fa-solid fa-location-dot me-2 opacity-75"></i> {{ $activity->location ?? 'TBD' }}</div>
                                <div><i class="fa-regular fa-user me-2 opacity-75"></i> Organized by {{ $activity->organizer_name ?? 'Admin' }}</div>
                                <div><i class="fa-solid fa-peso-sign me-2 opacity-75"></i> Budget: ₱{{ number_format($activity->budget, 2) }}</div>
                            </div>

                            <p class="text-subtle small mb-4 line-clamp-2" style="font-size: 0.82rem; line-height: 1.5;">
                                {{ $activity->description }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center small text-subtle mb-1">
                                <span>Registration:</span>
                                <span class="fw-semibold {{ $activity->is_registration_open ? 'text-success' : 'text-danger' }}">
                                    <i class="fa-solid {{ $activity->is_registration_open ? 'fa-lock-open me-1' : 'fa-lock me-1' }}"></i>
                                    {{ $activity->is_registration_open ? 'Open' : 'Closed' }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center small text-subtle mb-3">
                                <span>Attendance:</span>
                                <span class="fw-semibold {{ $activity->is_attendance_open ? 'text-success' : 'text-danger' }}">
                                    <i class="fa-solid {{ $activity->is_attendance_open ? 'fa-lock-open me-1' : 'fa-lock me-1' }}"></i>
                                    {{ $activity->is_attendance_open ? 'Open' : 'Closed' }}
                                </span>
                            </div>
                        </div>

                        <div class="pt-3 border-top border-white border-opacity-10 d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.activities.show', $activity->id) }}" class="btn btn-outline-light rounded-3 btn-sm px-3 fw-semibold">
                                <i class="fa-regular fa-eye me-1"></i> View Details
                            </a>

                            <div class="d-flex align-items-center gap-1">
                                <button class="btn-action-icon" title="Edit" onclick="editActivity({{ json_encode($activity) }})">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <button class="btn-action-icon danger" title="Archive Activity" onclick="confirmArchive('{{ route('admin.activities.destroy', $activity->id) }}')">
                                    <i class="fa-solid fa-box-archive"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-subtle py-5">
                    <i class="fa-regular fa-calendar-xmark fa-2x mb-2 opacity-50 d-block"></i>
                    No active activities found.
                </div>
            @endforelse
        </div>
    @elseif($tab === 'finished')
        <!-- Finished Row Layout View -->
        <div class="d-flex flex-column gap-3 mb-4">
            @forelse($activities as $activity)
                <div class="activity-card d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h5 class="fw-bold text-white mb-0" style="font-size: 1.05rem;">{{ $activity->title }}</h5>
                            <span class="badge badge-status-completed">Completed</span>
                        </div>
                        <p class="text-subtle small mb-2">{{ $activity->description }}</p>
                        <div class="d-flex align-items-center gap-3 text-subtle small flex-wrap" style="font-size: 0.78rem;">
                            <span><i class="fa-regular fa-calendar me-1"></i> {{ $activity->date->format('M j, Y') }}</span>
                            <span><i class="fa-regular fa-clock me-1"></i> {{ $activity->date->format('g:i A') }}</span>
                            <span><i class="fa-solid fa-location-dot me-1"></i> {{ $activity->location ?? 'N/A' }}</span>
                            <span><i class="fa-regular fa-user me-1"></i> {{ $activity->organizer_name ?? 'Admin' }}</span>
                            <span><i class="fa-solid fa-peso-sign me-1"></i> ₱{{ number_format($activity->budget, 2) }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 ms-auto">
                        <div class="text-center px-3 border-start border-end border-white border-opacity-10">
                            <span class="d-block fw-bold text-white fs-5">{{ $activity->feedback->count() }}</span>
                            <span class="text-subtle" style="font-size: 0.72rem;">Feedback</span>
                        </div>
                        <div class="text-center px-3 border-end border-white border-opacity-10 me-2">
                            <span class="d-block fw-bold text-white fs-5">{{ $activity->photos->count() }}</span>
                            <span class="text-subtle" style="font-size: 0.72rem;">Photos</span>
                        </div>
                        <a href="{{ route('admin.activities.show', $activity->id) }}" class="btn btn-purple btn-sm px-3">
                            <i class="fa-regular fa-eye me-1"></i> View Details
                        </a>

                        <button class="btn-action-icon danger" title="Archive Activity" onclick="confirmArchive('{{ route('admin.activities.destroy', $activity->id) }}')">
                            <i class="fa-solid fa-box-archive"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="activity-card text-center text-subtle py-5">
                    <i class="fa-solid fa-box-archive fa-2x mb-2 opacity-50 d-block"></i>
                    No finished activities recorded.
                </div>
            @endforelse
        </div>
    @else
        <!-- Archived Tab View -->
        <div class="d-flex flex-column gap-3 mb-4">
            @forelse($activities as $activity)
                <div class="activity-card d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h5 class="fw-bold text-white mb-0" style="font-size: 1.05rem;">{{ $activity->title }}</h5>
                            <span class="badge badge-status-archived">Archived</span>
                        </div>
                        <p class="text-subtle small mb-2">{{ $activity->description }}</p>
                        <div class="d-flex align-items-center gap-3 text-subtle small flex-wrap" style="font-size: 0.78rem;">
                            <span><i class="fa-regular fa-calendar me-1"></i> {{ $activity->date->format('M j, Y') }}</span>
                            <span><i class="fa-solid fa-location-dot me-1"></i> {{ $activity->location ?? 'N/A' }}</span>
                            <span><i class="fa-regular fa-clock me-1"></i> Archived on {{ $activity->deleted_at ? $activity->deleted_at->format('M j, Y') : 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <form method="POST" action="{{ route('admin.activities.restore', $activity->id) }}" class="m-0">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-success rounded-3 px-3">
                                <i class="fa-solid fa-rotate-left me-1"></i> Restore
                            </button>
                        </form>

                        <button class="btn btn-sm btn-outline-danger rounded-3 px-3" onclick="confirmPermanentDelete('{{ route('admin.activities.force-delete', $activity->id) }}')">
                            <i class="fa-solid fa-trash-can me-1"></i> Delete Forever
                        </button>
                    </div>
                </div>
            @empty
                <div class="activity-card text-center text-subtle py-5">
                    <i class="fa-solid fa-box-archive fa-2x mb-2 opacity-50 d-block"></i>
                    No archived activities found.
                </div>
            @endforelse
        </div>
    @endif

    @if($activities->hasPages())
        <div class="d-flex justify-content-center">
            {{ $activities->links() }}
        </div>
    @endif

    <!-- CREATE ACTIVITY MODAL -->
    <div class="modal fade admin-modal" id="createActivityModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-2">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom border-white border-opacity-10">
                    <h5 class="fw-bold mb-0" style="font-size: 1.05rem;">Create New Activity</h5>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('admin.activities.store') }}">
                    @csrf
                    <div class="modal-body p-3">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Activity Title</label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. Web Dev Workshop" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Organizer Name</label>
                                <input type="text" name="organizer_name" class="form-control" value="{{ auth()->user()->name }}" required>
                            </div>

                            <div class="col-12 col-md-3">
                                <label class="form-label">Event Date</label>
                                <input type="date" name="event_date" class="form-control" required>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">Event Start Time</label>
                                <input type="time" name="event_time" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Location / Venue</label>
                                <input type="text" name="location" class="form-control" placeholder="e.g. SM Aura / Zoom Link">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Budget (₱)</label>
                                <input type="number" step="0.01" name="budget" class="form-control" value="0.00">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Duration</label>
                                <input type="text" name="duration" class="form-control" placeholder="e.g. 2 hours / Half day">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="upcoming" selected>Upcoming</option>
                                    <option value="ongoing">Ongoing</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Write activity description..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 p-3 border-top border-white border-opacity-10">
                        <button type="button" class="btn btn-outline-light rounded-3 px-4 py-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-purple px-4 py-2">Create Activity</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT ACTIVITY MODAL -->
    <div class="modal fade admin-modal" id="editActivityModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-2">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom border-white border-opacity-10">
                    <h5 class="fw-bold mb-0" style="font-size: 1.05rem;">Edit Activity</h5>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="editActivityForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-3">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Activity Title</label>
                                <input type="text" id="edit_title" name="title" class="form-control" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Organizer Name</label>
                                <input type="text" id="edit_organizer_name" name="organizer_name" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-3">
                                <label class="form-label">Event Date</label>
                                <input type="date" id="edit_event_date" name="event_date" class="form-control" required>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">Event Start Time</label>
                                <input type="time" id="edit_event_time" name="event_time" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Location / Venue</label>
                                <input type="text" id="edit_location" name="location" class="form-control">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Budget (₱)</label>
                                <input type="number" step="0.01" id="edit_budget" name="budget" class="form-control">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Duration</label>
                                <input type="text" id="edit_duration" name="duration" class="form-control">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Status</label>
                                <select id="edit_status" name="status" class="form-select" required>
                                    <option value="upcoming">Upcoming</option>
                                    <option value="ongoing">Ongoing</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea id="edit_description" name="description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 p-3 border-top border-white border-opacity-10">
                        <button type="button" class="btn btn-outline-light rounded-3 px-4 py-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-purple px-4 py-2">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ARCHIVE CONFIRMATION MODAL -->
    <div class="modal fade admin-modal" id="archiveConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 text-center">
                <div class="modal-body p-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 56px; height: 56px; background-color: rgba(244, 63, 94, 0.15);">
                        <i class="fa-solid fa-box-archive text-danger fa-lg"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2">Move Activity to Archive?</h5>
                    <p class="text-subtle small mb-4">This item will be safely stored in the Archived tab. You can restore it anytime.</p>

                    <form id="archiveForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger rounded-3 px-4 fw-semibold">Archive</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- PERMANENT DELETE CONFIRMATION MODAL -->
    <div class="modal fade admin-modal" id="permDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 text-center">
                <div class="modal-body p-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 56px; height: 56px; background-color: rgba(220, 38, 38, 0.2);">
                        <i class="fa-solid fa-trash-can text-danger fa-lg"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2">Permanently Delete Activity?</h5>
                    <p class="text-subtle small mb-4">This action is irreversible and will wipe all activity logs, participants, and feedback forever.</p>

                    <form id="permDeleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger rounded-3 px-4 fw-semibold">Delete Forever</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function editActivity(data) {
        document.getElementById('editActivityForm').action = '/admin/activities/' + data.id;
        document.getElementById('edit_title').value = data.title;
        document.getElementById('edit_organizer_name').value = data.organizer_name || '';

        if(data.date) {
            const parts = data.date.split(' ');
            document.getElementById('edit_event_date').value = parts[0] || '';
            document.getElementById('edit_event_time').value = parts[1] ? parts[1].substring(0, 5) : '';
        }

        document.getElementById('edit_location').value = data.location || '';
        document.getElementById('edit_budget').value = data.budget || '0.00';
        document.getElementById('edit_duration').value = data.duration || '';
        document.getElementById('edit_status').value = data.status || 'upcoming';
        document.getElementById('edit_description').value = data.description || '';

        const modal = new bootstrap.Modal(document.getElementById('editActivityModal'));
        modal.show();
    }

    function confirmArchive(actionUrl) {
        document.getElementById('archiveForm').action = actionUrl;
        const modal = new bootstrap.Modal(document.getElementById('archiveConfirmModal'));
        modal.show();
    }

    function confirmPermanentDelete(actionUrl) {
        document.getElementById('permDeleteForm').action = actionUrl;
        const modal = new bootstrap.Modal(document.getElementById('permDeleteModal'));
        modal.show();
    }
</script>
@endpush
