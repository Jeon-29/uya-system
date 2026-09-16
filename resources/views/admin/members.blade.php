@extends('layouts.admin')

@section('title', 'Manage Members - UYA Connect')

@push('styles')
<style>
    .admin-card { background-color: var(--admin-card-bg); border: 1px solid var(--admin-border); border-radius: 14px; padding: 20px; }
    .admin-table { color: var(--admin-text-main); margin-bottom: 0; }
    .admin-table th { background-color: transparent; color: var(--admin-text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--admin-border); padding: 14px 16px; }
    .admin-table td { background-color: transparent; color: var(--admin-text-main); font-size: 0.88rem; border-bottom: 1px solid var(--admin-border); padding: 14px 16px; vertical-align: middle; }
    .admin-table tbody tr:hover td { background-color: rgba(255, 255, 255, 0.02); }

    .badge-role-admin, .badge-role-officer { border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff; background: transparent; font-weight: 500; padding: 4px 12px; border-radius: 12px; font-size: 0.72rem; }
    .badge-role-member { background-color: var(--admin-accent-purple); color: #ffffff; font-weight: 500; padding: 4px 12px; border-radius: 12px; font-size: 0.72rem; }
    .badge-status-active { border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; background: transparent; font-weight: 400; padding: 3px 10px; border-radius: 10px; font-size: 0.72rem; }
    .badge-status-inactive { border: 1px solid rgba(244, 63, 94, 0.4); color: #fb7185; background: transparent; font-weight: 400; padding: 3px 10px; border-radius: 10px; font-size: 0.72rem; }
    .badge-toggle-btn { cursor: pointer; transition: filter 0.15s ease; }
    .badge-toggle-btn:hover { filter: brightness(1.3); }

    .btn-action-icon { background: transparent; border: none; color: var(--admin-text-muted); padding: 4px 6px; transition: color 0.2s ease; }
    .btn-action-icon:hover { color: #ffffff; }
    .btn-action-icon.danger:hover { color: #fb7185; }

    .admin-input-group { background-color: var(--admin-card-bg); border: 1px solid var(--admin-border); border-radius: 12px; overflow: hidden; }
    .admin-input-group .form-control { background-color: transparent; border: none; color: #ffffff; font-size: 0.85rem; }
    .admin-input-group .form-control::placeholder { color: var(--admin-text-muted); }
    .admin-input-group .input-group-text { background-color: transparent; border: none; color: var(--admin-text-muted); }

    .btn-purple { background-color: var(--admin-accent-purple); color: #ffffff; border: none; border-radius: 10px; font-weight: 600; font-size: 0.85rem; padding: 8px 18px; transition: background-color 0.2s ease; }
    .btn-purple:hover { background-color: var(--admin-accent-purple-hover); color: #ffffff; }

    .admin-modal .modal-content { background-color: var(--admin-card-bg); border: 1px solid var(--admin-border); color: #ffffff; border-radius: 16px; }
    .admin-modal .form-label { font-size: 0.82rem; font-weight: 600; color: #ffffff; }
    .admin-modal .form-control, .admin-modal .form-select { background-color: var(--admin-input-bg); border: 1px solid var(--admin-border); color: #ffffff; border-radius: 10px; font-size: 0.85rem; padding: 10px 14px; }
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
    @if (session('error'))
        <div class="alert alert-danger bg-danger bg-opacity-20 text-danger border-0 rounded-3 mb-3" style="font-size: 0.85rem;">
            {{ session('error') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1 text-white">Manage Members</h4>
            <p class="text-muted small mb-0">View and manage all organization members</p>
        </div>
        <button type="button" class="btn btn-purple d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addMemberModal">
            <i class="fa-solid fa-plus"></i> Add Member
        </button>
    </div>

    <div class="mb-3">
        <form method="GET" action="{{ route('admin.members') }}">
            <div class="input-group admin-input-group">
                <span class="input-group-text ps-3">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control py-2 shadow-none" placeholder="Search members...">
                @if(request('search'))
                    <a href="{{ route('admin.members') }}" class="btn text-muted d-flex align-items-center pe-3">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="admin-card p-0 overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table admin-table align-middle">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td class="text-muted">#{{ $member->id }}</td>
                            <td class="fw-semibold text-white">{{ $member->name }}</td>
                            <td class="text-muted">{{ $member->email }}</td>
                            <td>
                                @if(strtolower($member->role) === 'admin')
                                    <span class="badge badge-role-admin">Admin</span>
                                @elseif(strtolower($member->role) === 'officer')
                                    <span class="badge badge-role-officer">Officer</span>
                                @else
                                    <span class="badge badge-role-member">Member</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->id() === $member->id)
                                    @if($member->email_verified_at)
                                        <span class="badge badge-status-active">Active</span>
                                    @else
                                        <span class="badge badge-status-inactive">Inactive</span>
                                    @endif
                                @else
                                    <form method="POST" action="{{ route('admin.members.toggle-status', $member->id) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        @if($member->email_verified_at)
                                            <button type="submit" class="badge badge-status-active badge-toggle-btn" title="Click to deactivate">Active</button>
                                        @else
                                            <button type="submit" class="badge badge-status-inactive badge-toggle-btn" title="Click to activate">Inactive</button>
                                        @endif
                                    </form>
                                @endif
                            </td>
                            <td class="text-end">
                                <button class="btn-action-icon me-1" title="Edit" onclick="editMember({{ json_encode($member) }})">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <button class="btn-action-icon danger" title="Delete" onclick="confirmDelete('{{ route('admin.members.destroy', $member->id) }}')">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No members found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center p-3 border-top border-white border-opacity-10 flex-wrap gap-2" style="font-size: 0.8rem;">
            <div class="text-muted">
                Showing {{ $members->firstItem() ?? 0 }}-{{ $members->lastItem() ?? 0 }} of {{ $members->total() ?? 0 }} members
            </div>
            <div>
                @if(method_exists($members, 'links'))
                    {{ $members->links() }}
                @endif
            </div>
        </div>
    </div>

    <!-- ADD MEMBER MODAL -->
    <div class="modal fade admin-modal" id="addMemberModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content p-2">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom border-white border-opacity-10">
                    <h5 class="fw-bold mb-0" style="font-size: 1.05rem;">Add New Member</h5>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('admin.members.store') }}">
                    @csrf
                    <div class="modal-body p-3">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter member name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email address" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Set initial password" required>
                            <div class="form-text text-muted" style="font-size: 0.72rem;">
                                Used to create the member, officer, or admin login credentials.
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="member">Member</option>
                                <option value="officer">Officer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 p-3 border-top border-white border-opacity-10">
                        <button type="button" class="btn btn-outline-light rounded-3 px-4 py-2" style="font-size: 0.85rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-purple px-4 py-2">Add Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT MEMBER MODAL -->
    <div class="modal fade admin-modal" id="editMemberModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content p-2">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom border-white border-opacity-10">
                    <h5 class="fw-bold mb-0" style="font-size: 1.05rem;">Edit Member</h5>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="editMemberForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-3">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" id="edit_name" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" id="edit_email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-muted fw-normal">(Leave blank to keep current)</span></label>
                            <input type="password" name="password" class="form-control" placeholder="New password">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Role</label>
                            <select id="edit_role" name="role" class="form-select" required>
                                <option value="member">Member</option>
                                <option value="officer">Officer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 p-3 border-top border-white border-opacity-10">
                        <button type="button" class="btn btn-outline-light rounded-3 px-4 py-2" style="font-size: 0.85rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-purple px-4 py-2">Update Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE CONFIRMATION MODAL -->
    <div class="modal fade admin-modal" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 text-center">
                <div class="modal-body p-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="width: 56px; height: 56px; background-color: rgba(244, 63, 94, 0.15);">
                        <i class="fa-solid fa-trash-can text-danger fa-lg"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Delete Member?</h5>
                    <p class="text-muted small mb-4">This action will remove the account permanently.</p>

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
    function editMember(data) {
        document.getElementById('editMemberForm').action = '/admin/members/' + data.id;
        document.getElementById('edit_name').value = data.name;
        document.getElementById('edit_email').value = data.email;
        document.getElementById('edit_role').value = data.role || 'member';

        const modal = new bootstrap.Modal(document.getElementById('editMemberModal'));
        modal.show();
    }

    function confirmDelete(actionUrl) {
        document.getElementById('deleteForm').action = actionUrl;
        const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        modal.show();
    }
</script>
@endpush