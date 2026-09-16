@extends('layouts.admin')

@section('title', 'Announcements Management - UYA Connect')

@push('styles')
<style>
    .announcement-card { background-color: var(--admin-card-bg); border: 1px solid var(--admin-border); border-radius: 16px; padding: 22px; transition: border-color 0.2s ease; }
    .announcement-card:hover { border-color: rgba(255, 255, 255, 0.18); }

    .badge-audience { background-color: rgba(99, 102, 241, 0.25); color: #a5b4fc; font-weight: 600; font-size: 0.7rem; padding: 4px 10px; border-radius: 12px; border: 1px solid rgba(99, 102, 241, 0.4); }
    .badge-audience-officers { background-color: rgba(56, 189, 248, 0.2); color: #7dd3fc; font-weight: 600; font-size: 0.7rem; padding: 4px 10px; border-radius: 12px; border: 1px solid rgba(56, 189, 248, 0.4); }
    .badge-audience-admin { background-color: rgba(244, 63, 94, 0.2); color: #fda4af; font-weight: 600; font-size: 0.7rem; padding: 4px 10px; border-radius: 12px; border: 1px solid rgba(244, 63, 94, 0.4); }
    .badge-pinned { background-color: rgba(245, 158, 11, 0.2); color: #fcd34d; font-weight: 600; font-size: 0.7rem; padding: 4px 10px; border-radius: 12px; border: 1px solid rgba(245, 158, 11, 0.4); }

    .btn-action-icon { background: transparent; border: none; color: var(--admin-text-subtle); padding: 6px; font-size: 0.95rem; transition: color 0.2s ease; }
    .btn-action-icon:hover { color: #ffffff; }
    .btn-action-icon.danger:hover { color: #fb7185; }

    .btn-purple { background-color: var(--admin-accent-purple); color: #ffffff; border: none; border-radius: 10px; font-weight: 600; font-size: 0.85rem; padding: 9px 18px; transition: background-color 0.2s ease; }
    .btn-purple:hover { background-color: var(--admin-accent-purple-hover); color: #ffffff; }

    .admin-modal .modal-content { background-color: var(--admin-card-bg); border: 1px solid var(--admin-border); color: #ffffff; border-radius: 16px; }
    .admin-modal .form-label { font-size: 0.85rem; font-weight: 600; color: #ffffff; }
    .admin-modal .form-control, .admin-modal .form-select { background-color: var(--admin-input-bg); border: 1px solid var(--admin-border); color: #ffffff; border-radius: 10px; font-size: 0.88rem; padding: 10px 14px; }
    .admin-modal .form-control:focus, .admin-modal .form-select:focus { background-color: var(--admin-input-bg); color: #ffffff; border-color: var(--admin-accent-purple); box-shadow: none; }
</style>
@endpush

@section('content')
    @php
        $authUser = auth()->user();
        $authName = $authUser->name ?? 'User';
        $authRole = ucfirst($authUser->role ?? 'Officer');
    @endphp

    @if (session('success'))
        <div class="alert alert-success bg-success bg-opacity-20 text-success border-0 rounded-3 mb-3" style="font-size: 0.85rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1 text-white">Announcements</h4>
        </div>
        <button type="button" class="btn btn-purple d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createAnnouncementModal">
            <i class="fa-solid fa-plus"></i> Create Announcement
        </button>
    </div>

    <div class="d-flex flex-column gap-3 mb-4">
        @forelse($announcements as $announcement)
            <div class="announcement-card">
                <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-bullhorn text-subtle" style="font-size: 0.95rem;"></i>
                        <h6 class="fw-bold mb-0 text-white" style="font-size: 1.05rem;">{{ $announcement->title }}</h6>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        @if($announcement->is_pinned)
                            <span class="badge badge-pinned"><i class="fa-solid fa-thumbtack me-1"></i> Pinned</span>
                        @endif

                        @php $audience = $announcement->target_audience ?? 'all'; @endphp
                        @if($audience === 'officers')
                            <span class="badge badge-audience-officers"><i class="fa-solid fa-user-shield me-1"></i> Officers</span>
                        @elseif($audience === 'admin')
                            <span class="badge badge-audience-admin"><i class="fa-solid fa-lock me-1"></i> Admin</span>
                        @else
                            <span class="badge badge-audience"><i class="fa-solid fa-users me-1"></i> All</span>
                        @endif

                        @if(in_array(strtolower(auth()->user()->role ?? 'member'), ['admin', 'officer']))
                            <button class="btn-action-icon ms-1" title="Edit" onclick="editAnnouncement({{ json_encode($announcement) }})">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <button class="btn-action-icon danger" title="Delete" onclick="confirmDelete('{{ route('announcements.destroy', $announcement->id) }}')">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="text-subtle small mb-3" style="font-size: 0.8rem;">
                    {{ $announcement->created_at ? $announcement->created_at->format('F j, Y') : 'Recent' }}
                </div>

                <p class="text-subtle mb-3" style="font-size: 0.88rem; line-height: 1.55;">
                    {{ $announcement->content }}
                </p>

                <div class="text-subtle small" style="font-size: 0.8rem;">
                    Posted by <span class="fw-semibold text-white">{{ $announcement->author->name ?? 'Admin' }}</span>
                </div>
            </div>
        @empty
            <div class="announcement-card text-center text-subtle py-5">
                <i class="fa-solid fa-bullhorn fa-2x mb-3 text-muted"></i>
                <h6 class="fw-semibold text-white mb-1">No Announcements Found</h6>
                <p class="small mb-0">Create an announcement using the button above to publish update posts.</p>
            </div>
        @endforelse
    </div>

    @if(method_exists($announcements, 'links'))
        <div class="d-flex justify-content-center">
            {{ $announcements->links() }}
        </div>
    @endif

    <!-- CREATE ANNOUNCEMENT MODAL -->
    <div class="modal fade admin-modal" id="createAnnouncementModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 520px;">
            <div class="modal-content p-2">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom border-white border-opacity-10">
                    <h5 class="fw-bold mb-0" style="font-size: 1.05rem;">Create Announcement</h5>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('announcements.store') }}">
                    @csrf
                    <div class="modal-body p-3">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Announcement Title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Target Audience</label>
                            <select name="target_audience" class="form-select" required>
                                <option value="all" selected>All (Members, Officers & Admins)</option>
                                <option value="officers">Officers Only</option>
                                <option value="admin">Admin Only</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="content" class="form-control" rows="4" placeholder="Write announcement message..." required></textarea>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input shadow-none" type="checkbox" name="is_pinned" value="1" id="createPinCheck">
                            <label class="form-check-label text-subtle small fw-semibold" for="createPinCheck">
                                Pin this announcement to top
                            </label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 p-3 border-top border-white border-opacity-10">
                        <button type="button" class="btn btn-outline-light rounded-3 px-4 py-2" style="font-size: 0.85rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-purple px-4 py-2">Publish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT ANNOUNCEMENT MODAL -->
    <div class="modal fade admin-modal" id="editAnnouncementModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 520px;">
            <div class="modal-content p-2">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom border-white border-opacity-10">
                    <h5 class="fw-bold mb-0" style="font-size: 1.05rem;">Edit Announcement</h5>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="editAnnouncementForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-3">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" id="edit_title" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Target Audience</label>
                            <select id="edit_target_audience" name="target_audience" class="form-select" required>
                                <option value="all">All (Members, Officers & Admins)</option>
                                <option value="officers">Officers Only</option>
                                <option value="admin">Admin Only</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea id="edit_content" name="content" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input shadow-none" type="checkbox" name="is_pinned" value="1" id="edit_is_pinned">
                            <label class="form-check-label text-subtle small fw-semibold" for="edit_is_pinned">
                                Pin this announcement to top
                            </label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 p-3 border-top border-white border-opacity-10">
                        <button type="button" class="btn btn-outline-light rounded-3 px-4 py-2" style="font-size: 0.85rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-purple px-4 py-2">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE ANNOUNCEMENT MODAL -->
    <div class="modal fade admin-modal" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 text-center">
                <div class="modal-body p-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="width: 56px; height: 56px; background-color: rgba(244, 63, 94, 0.15);">
                        <i class="fa-solid fa-trash-can text-danger fa-lg"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Delete Announcement?</h5>
                    <p class="text-subtle small mb-4">This action cannot be undone and will remove the announcement post.</p>

                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger rounded-3 px-4">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function editAnnouncement(announcement) {
        document.getElementById('editAnnouncementForm').action = '/announcements/' + announcement.id;
        document.getElementById('edit_title').value = announcement.title;
        document.getElementById('edit_target_audience').value = announcement.target_audience || 'all';
        document.getElementById('edit_content').value = announcement.content;
        document.getElementById('edit_is_pinned').checked = Boolean(announcement.is_pinned);

        const modal = new bootstrap.Modal(document.getElementById('editAnnouncementModal'));
        modal.show();
    }

    function confirmDelete(actionUrl) {
        document.getElementById('deleteForm').action = actionUrl;
        const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        modal.show();
    }
</script>
@endpush