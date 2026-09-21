@extends('layouts.admin')

@section('title', 'Attendance Records - UYA Connect')

@push('styles')
<style>
    .admin-card { background-color: var(--admin-card-bg); border: 1px solid var(--admin-border); border-radius: 14px; padding: 20px; }
    .stat-card { padding: 14px 18px !important; }
    .stat-card-title { font-size: 0.76rem; color: var(--admin-text-subtle); font-weight: 600; }
    .stat-card-value { font-size: 1.55rem; font-weight: 700; color: #ffffff; margin-top: 4px; line-height: 1.2; }
    .stat-card-value.text-present { color: #4ade80; }
    .stat-card-value.text-late { color: #818cf8; }
    .stat-card-value.text-absent { color: #94a3b8; }
    .stat-card-value.text-rate { color: #818cf8; }

    .admin-table { color: var(--admin-text-main); margin-bottom: 0; }
    .admin-table th { background-color: transparent; color: var(--admin-text-subtle); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--admin-border); padding: 14px 18px; }
    .admin-table td { background-color: transparent; color: var(--admin-text-main); font-size: 0.88rem; border-bottom: 1px solid var(--admin-border); padding: 14px 18px; vertical-align: middle; }
    .admin-table tbody tr:hover td { background-color: rgba(255, 255, 255, 0.02); }

    .badge-status-present { background-color: rgba(34, 197, 94, 0.15); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.35); font-weight: 500; padding: 4px 12px; border-radius: 12px; font-size: 0.72rem; }
    .badge-status-late { background-color: rgba(245, 158, 11, 0.15); color: #fcd34d; border: 1px solid rgba(245, 158, 11, 0.35); font-weight: 500; padding: 4px 12px; border-radius: 12px; font-size: 0.72rem; }
    .badge-status-absent { background-color: rgba(244, 63, 94, 0.15); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.35); font-weight: 500; padding: 4px 12px; border-radius: 12px; font-size: 0.72rem; }

    .btn-action-icon { background: transparent; border: none; color: var(--admin-text-subtle); padding: 4px 6px; transition: color 0.2s ease; }
    .btn-action-icon:hover { color: #ffffff; }

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

        $totalCount = $stats['totalRecords'] ?? 0;
        $presentCount = $stats['presentCount'] ?? 0;
        $lateCount = $stats['lateCount'] ?? 0;
        $absentCount = $stats['absentCount'] ?? 0;
        $attendanceRate = $stats['attendanceRate'] ?? 0;
    @endphp

    @if (session('success'))
        <div class="alert alert-success bg-success bg-opacity-20 text-success border-0 rounded-3 mb-3" style="font-size: 0.85rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-2 g-md-3 mb-4">
        <div class="col-6 col-md-4 col-xl">
            <div class="admin-card stat-card h-100">
                <span class="stat-card-title">Total Records</span>
                <div class="stat-card-value">{{ $totalCount }}</div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl">
            <div class="admin-card stat-card h-100">
                <span class="stat-card-title">Present</span>
                <div class="stat-card-value text-present">{{ $presentCount }}</div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl">
            <div class="admin-card stat-card h-100">
                <span class="stat-card-title">Late</span>
                <div class="stat-card-value text-late">{{ $lateCount }}</div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl">
            <div class="admin-card stat-card h-100">
                <span class="stat-card-title">Absent</span>
                <div class="stat-card-value text-absent">{{ $absentCount }}</div>
            </div>
        </div>

        <div class="col-12 col-md-4 col-xl">
            <div class="admin-card stat-card h-100">
                <span class="stat-card-title">Attendance Rate</span>
                <div class="stat-card-value text-rate">{{ $attendanceRate }}%</div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <h5 class="fw-bold mb-1 text-white">Attendance Records</h5>
    </div>

    <div class="admin-card p-0 overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table admin-table align-middle">
                <thead>
                    <tr>
                        <th>Member Name</th>
                        <th>Activity</th>
                        <th>Status</th>
                        <th>Timestamp</th>
                        <th class="text-end" style="width: 80px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                        <tr>
                            <td class="fw-semibold text-white">{{ $record->member_name ?? ($record->user->name ?? 'N/A') }}</td>
                            <td class="text-subtle">{{ $record->activity_name ?? ($record->activity->title ?? 'N/A') }}</td>
                            <td>
                                @php $st = strtolower($record->status ?? 'registered'); @endphp
                                @if($st === 'attended' || $st === 'present')
                                    <span class="badge badge-status-present">Present</span>
                                @elseif($st === 'late' || $st === 'present but late')
                                    <span class="badge badge-status-late">Present but Late</span>
                                @else
                                    <span class="badge badge-status-absent">Absent</span>
                                @endif
                            </td>
                            <td class="text-subtle">
                                @if(isset($record->timestamp))
                                    {{ $record->timestamp }}
                                @elseif(isset($record->created_at))
                                    {{ \Carbon\Carbon::parse($record->created_at)->format('n/j/Y, g:i:s A') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-end">
                                <button class="btn-action-icon" title="Edit Record" onclick="editAttendance({{ json_encode($record) }})">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-subtle py-4">No attendance records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($records, 'links') && $records->hasPages())
            <div class="d-flex justify-content-between align-items-center p-3 border-top border-white border-opacity-10 flex-wrap gap-2" style="font-size: 0.8rem;">
                <div class="text-subtle">
                    Showing {{ $records->firstItem() ?? 0 }}-{{ $records->lastItem() ?? 0 }} of {{ $records->total() ?? 0 }} records
                </div>
                <div>
                    {{ $records->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- EDIT ATTENDANCE MODAL -->
    <div class="modal fade admin-modal" id="editAttendanceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content p-2">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom border-white border-opacity-10">
                    <h5 class="fw-bold mb-0" style="font-size: 1.05rem;">Edit Attendance Record</h5>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="editAttendanceForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-3">
                        <div class="mb-3">
                            <label class="form-label">Member</label>
                            <input type="text" id="edit_member_name" class="form-control" readonly disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Activity</label>
                            <input type="text" id="edit_activity_name" class="form-control" readonly disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Attendance Status</label>
                            <select id="edit_status" name="status" class="form-select" required>
                                <option value="present">Present</option>
                                <option value="late">Present but Late</option>
                                <option value="absent">Absent</option>
                            </select>
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
@endsection

@push('scripts')
<script>
    function editAttendance(record) {
        document.getElementById('editAttendanceForm').action = '/admin/attendance/' + record.id;
        document.getElementById('edit_member_name').value = record.member_name || (record.user ? record.user.name : '');
        document.getElementById('edit_activity_name').value = record.activity_name || (record.activity ? record.activity.title : '');

        let statusVal = (record.status || 'registered').toLowerCase();
        if (statusVal === 'attended') statusVal = 'present';
        if (statusVal === 'registered') statusVal = 'absent';
        document.getElementById('edit_status').value = statusVal;

        const modal = new bootstrap.Modal(document.getElementById('editAttendanceModal'));
        modal.show();
    }
</script>
@endpush
