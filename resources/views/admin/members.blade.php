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

    /* Interactive Status Toggle Pill Styling */
    .status-toggle-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--admin-border);
        transition: all 0.2s ease;
        user-select: none;
    }
    .status-toggle-btn.active-status {
        color: #4ade80;
        border-color: rgba(74, 222, 128, 0.3);
        background-color: rgba(74, 222, 128, 0.08);
    }
    .status-toggle-btn.inactive-status {
        color: #fb7185;
        border-color: rgba(251, 113, 133, 0.3);
        background-color: rgba(251, 113, 133, 0.08);
    }
    .status-toggle-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }
    .status-toggle-btn.active-status:hover {
        border-color: #4ade80;
        background-color: rgba(74, 222, 128, 0.16);
    }
    .status-toggle-btn.inactive-status:hover {
        border-color: #fb7185;
        background-color: rgba(251, 113, 133, 0.16);
    }
    .status-toggle-btn.disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }
    .status-toggle-btn.disabled:hover {
        transform: none;
        box-shadow: none;
    }

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

    /* Custom Minimal Dark Pagination */
    .admin-pagination .pagination { margin-bottom: 0; gap: 4px; }
    .admin-pagination .page-item .page-link {
        background-color: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--admin-border);
        color: var(--admin-text-muted);
        border-radius: 8px !important;
        padding: 5px 11px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.15s ease;
        box-shadow: none !important;
    }
    .admin-pagination .page-item .page-link:hover {
        background-color: rgba(255, 255, 255, 0.08);
        color: #ffffff;
        border-color: rgba(255, 255, 255, 0.2);
    }
    .admin-pagination .page-item.active .page-link {
        background-color: var(--admin-accent-purple) !important;
        border-color: var(--admin-accent-purple) !important;
        color: #ffffff !important;
    }
    .admin-pagination .page-item.disabled .page-link {
        background-color: transparent !important;
        border-color: rgba(255, 255, 255, 0.04) !important;
        color: rgba(255, 255, 255, 0.2) !important;
    }
</style>
@endpush

@section('content')
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
                                @php $isActive = (bool)$member->email_verified_at; @endphp
                                @if(auth()->id() === $member->id)
                                    <span class="status-toggle-btn {{ $isActive ? 'active-status' : 'inactive-status' }} disabled" title="You cannot change your own status">
                                        <i class="fa-solid {{ $isActive ? 'fa-toggle-on text-success' : 'fa-toggle-off text-muted' }} fa-lg"></i>
                                        <span>{{ $isActive ? 'Active' : 'Inactive' }}</span>
                                    </span>
                                @else
                                    <button type="button"
                                            class="status-toggle-btn {{ $isActive ? 'active-status' : 'inactive-status' }}"
                                            title="Click to toggle status"
                                            onclick="confirmToggleStatus('{{ route('admin.members.toggle-status', $member->id) }}', '{{ addslashes($member->name) }}', {{ $isActive ? 'true' : 'false' }})">
                                        <i class="fa-solid {{ $isActive ? 'fa-toggle-on text-success' : 'fa-toggle-off text-muted' }} fa-lg"></i>
                                        <span>{{ $isActive ? 'Active' : 'Inactive' }}</span>
                                    </button>
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
            <div class="admin-pagination">
                @if(method_exists($members, 'links'))
                    {{ $members->links('pagination::bootstrap-5') }}
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
                            <input type="email" id="add_email" name="email" class="form-control" placeholder="Enter email address" autocomplete="off" required>
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
                            <input type="email" id="edit_email" name="email" class="form-control" autocomplete="off" required>
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
                        <button type="button" class="btn btn-purple px-4 py-2" onclick="promptEditConfirmation()">Update Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT CONFIRMATION MODAL -->
    <div class="modal fade admin-modal" id="editConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content p-3 text-center">
                <div class="modal-body p-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="width: 56px; height: 56px; background-color: rgba(99, 102, 241, 0.15);">
                        <i class="fa-solid fa-pen-to-square text-primary fa-lg"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Save Member Changes?</h5>
                    <p class="text-subtle small mb-4">Are you sure you want to update this member's account information?</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-outline-light rounded-3 px-4" onclick="cancelEditConfirmation()">Back</button>
                        <button type="button" class="btn btn-purple rounded-3 px-4" onclick="submitEditForm()">Yes, Update Member</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- STATUS TOGGLE CONFIRMATION MODAL -->
    <div class="modal fade admin-modal" id="toggleStatusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content p-3 text-center">
                <div class="modal-body p-4">
                    <div id="toggleIconBox" class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 56px; height: 56px;">
                        <i id="toggleModalIcon" class="fa-solid fa-lg"></i>
                    </div>
                    <h5 class="fw-bold mb-2" id="toggleModalTitle">Change Member Status?</h5>
                    <p class="text-subtle small mb-4" id="toggleModalBody">Are you sure you want to change this member's active status?</p>

                    <form id="toggleStatusForm" method="POST" action="">
                        @csrf
                        @method('PATCH')
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" id="toggleConfirmBtn" class="btn rounded-3 px-4">Confirm</button>
                        </div>
                    </form>
                </div>
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
    let editModalInstance = null;
    let editConfirmModalInstance = null;

    const EMAIL_CHECK_URL = "{{ route('admin.members.check-email') }}";
    let editMemberId = null;
    let editOriginalEmail = '';
    let addEmailChecker = null;
    let editEmailChecker = null;

    /**
     * Live "email already used" check. Debounced, ignores stale responses,
     * and disables the submit button while the typed email is taken.
     * The server-side unique rules in MemberController still enforce this on submit.
     */
    function createEmailChecker(input, submitBtn, getIgnoreId, getOriginalEmail) {
        const feedback = document.createElement('div');
        feedback.className = 'form-text';
        feedback.style.fontSize = '0.78rem';
        feedback.style.display = 'none';
        input.insertAdjacentElement('afterend', feedback);

        let timer = null;
        let latest = 0;

        function show(kind, message) {
            input.classList.remove('is-valid', 'is-invalid');
            feedback.classList.remove('text-success', 'text-danger', 'text-muted');

            if (!kind) {
                feedback.style.display = 'none';
                feedback.textContent = '';
                return;
            }

            feedback.style.display = 'block';
            feedback.textContent = message;

            if (kind === 'taken') {
                input.classList.add('is-invalid');
                feedback.classList.add('text-danger');
            } else if (kind === 'available') {
                input.classList.add('is-valid');
                feedback.classList.add('text-success');
            } else {
                feedback.classList.add('text-muted');
            }
        }

        function reset() {
            clearTimeout(timer);
            latest++;
            show(null);
            submitBtn.disabled = false;
        }

        input.addEventListener('input', () => {
            clearTimeout(timer);
            latest++;
            submitBtn.disabled = false;

            const value = input.value.trim();
            if (!value || !input.checkValidity()) {
                show(null);
                return;
            }

            const original = getOriginalEmail ? getOriginalEmail() : '';
            if (original && value.toLowerCase() === original) {
                show(null);
                return;
            }

            show('checking', 'Checking email...');
            const thisRequest = latest;

            timer = setTimeout(async () => {
                try {
                    const params = new URLSearchParams({ email: value });
                    const ignoreId = getIgnoreId ? getIgnoreId() : null;
                    if (ignoreId) {
                        params.append('ignore_id', ignoreId);
                    }

                    const response = await fetch(EMAIL_CHECK_URL + '?' + params.toString(), {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        credentials: 'same-origin'
                    });
                    if (!response.ok) throw new Error('Request failed');

                    const data = await response.json();
                    if (thisRequest !== latest) return; // a newer keystroke superseded this check

                    if (data.available) {
                        show('available', data.message);
                        submitBtn.disabled = false;
                    } else {
                        show('taken', data.message);
                        submitBtn.disabled = true;
                    }
                } catch (error) {
                    // If the check can't run, don't block the admin; the server still validates on submit.
                    if (thisRequest === latest) show(null);
                }
            }, 400);
        });

        return { reset };
    }

    document.addEventListener('DOMContentLoaded', function () {
        addEmailChecker = createEmailChecker(
            document.getElementById('add_email'),
            document.querySelector('#addMemberModal button[type="submit"]'),
            null,
            null
        );

        editEmailChecker = createEmailChecker(
            document.getElementById('edit_email'),
            document.querySelector('#editMemberModal .btn-purple'),
            () => editMemberId,
            () => editOriginalEmail
        );

        document.getElementById('addMemberModal').addEventListener('hidden.bs.modal', () => addEmailChecker.reset());
    });

    function editMember(data) {
        document.getElementById('editMemberForm').action = '/admin/members/' + data.id;
        document.getElementById('edit_name').value = data.name;
        document.getElementById('edit_email').value = data.email;
        document.getElementById('edit_role').value = data.role || 'member';

        editMemberId = data.id;
        editOriginalEmail = (data.email || '').trim().toLowerCase();
        if (editEmailChecker) editEmailChecker.reset();

        editModalInstance = new bootstrap.Modal(document.getElementById('editMemberModal'));
        editModalInstance.show();
    }

    function promptEditConfirmation() {
        const form = document.getElementById('editMemberForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        if (editModalInstance) {
            editModalInstance.hide();
        }

        editConfirmModalInstance = new bootstrap.Modal(document.getElementById('editConfirmModal'));
        editConfirmModalInstance.show();
    }

    function cancelEditConfirmation() {
        if (editConfirmModalInstance) {
            editConfirmModalInstance.hide();
        }
        if (editModalInstance) {
            editModalInstance.show();
        }
    }

    function submitEditForm() {
        document.getElementById('editMemberForm').submit();
    }

    function confirmToggleStatus(actionUrl, memberName, isCurrentlyActive) {
        const form = document.getElementById('toggleStatusForm');
        form.action = actionUrl;

        const iconBox = document.getElementById('toggleIconBox');
        const icon = document.getElementById('toggleModalIcon');
        const title = document.getElementById('toggleModalTitle');
        const body = document.getElementById('toggleModalBody');
        const confirmBtn = document.getElementById('toggleConfirmBtn');

        if (isCurrentlyActive) {
            iconBox.style.backgroundColor = 'rgba(244, 63, 94, 0.15)';
            icon.className = 'fa-solid fa-toggle-off text-danger fa-lg';
            title.innerText = 'Deactivate Member?';
            body.innerHTML = `Are you sure you want to deactivate <strong>${memberName}</strong>? They will temporarily lose active privileges.`;
            confirmBtn.className = 'btn btn-danger rounded-3 px-4';
            confirmBtn.innerText = 'Deactivate';
        } else {
            iconBox.style.backgroundColor = 'rgba(34, 197, 94, 0.15)';
            icon.className = 'fa-solid fa-toggle-on text-success fa-lg';
            title.innerText = 'Activate Member?';
            body.innerHTML = `Are you sure you want to activate <strong>${memberName}</strong>?`;
            confirmBtn.className = 'btn btn-success rounded-3 px-4';
            confirmBtn.innerText = 'Activate';
        }

        const modal = new bootstrap.Modal(document.getElementById('toggleStatusModal'));
        modal.show();
    }

    function confirmDelete(actionUrl) {
        document.getElementById('deleteForm').action = actionUrl;
        const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        modal.show();
    }
</script>
@endpush
