<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Records - UYA Connect</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --admin-bg: #0b1120;
            --admin-sidebar-bg: #0f172a;
            --admin-card-bg: #151e32;
            --admin-card-hover: #1e293b;
            --admin-accent-purple: #6366f1;
            --admin-accent-purple-hover: #4f46e5;
            --admin-text-main: #ffffff;
            --admin-text-subtle: #cbd5e1;
            --admin-text-muted: #94a3b8;
            --admin-border: rgba(255, 255, 255, 0.08);
            --admin-input-bg: #0f172a;
        }

        body {
            background-color: var(--admin-bg);
            color: var(--admin-text-main);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Standardized Mobile-to-Desktop Padding Scaffolding */
        .admin-content-container {
            width: 100% !important;
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        @media (min-width: 768px) {
            .admin-content-container {
                padding-left: 2.5rem !important;
                padding-right: 2.5rem !important;
            }
        }

        /* Sidebar Styling */
        .admin-sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--admin-sidebar-bg);
            border-right: 1px solid var(--admin-border);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 1040;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 24px 20px;
            font-weight: 700;
            font-size: 1.15rem;
            color: #ffffff;
            letter-spacing: 0.5px;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0 12px;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 10px;
            color: var(--admin-text-muted);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar-nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .sidebar-nav-link.active {
            background-color: var(--admin-accent-purple);
            color: #ffffff !important;
        }

        .sidebar-nav-link i {
            width: 18px;
            text-align: center;
            font-size: 1rem;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid var(--admin-border);
        }

        /* Main Area Layout */
        .admin-main {
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Header Bar */
        .admin-topbar {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--admin-border);
            background-color: rgba(11, 17, 32, 0.95);
            backdrop-filter: blur(8px);
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .topbar-user-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
        }

        .topbar-user-role {
            font-size: 0.75rem;
            color: var(--admin-text-subtle);
            margin: 0;
        }

        /* Card Container Base */
        .admin-card {
            background-color: var(--admin-card-bg);
            border: 1px solid var(--admin-border);
            border-radius: 14px;
            padding: 20px;
        }

        /* Compact Metric Stat Cards */
        .stat-card {
            padding: 14px 18px !important;
        }

        .stat-card-title {
            font-size: 0.76rem;
            color: var(--admin-text-subtle);
            font-weight: 600;
        }

        .stat-card-value {
            font-size: 1.55rem;
            font-weight: 700;
            color: #ffffff;
            margin-top: 4px;
            line-height: 1.2;
        }

        .stat-card-value.text-present { color: #4ade80; }
        .stat-card-value.text-late { color: #818cf8; }
        .stat-card-value.text-absent { color: #94a3b8; }
        .stat-card-value.text-rate { color: #818cf8; }

        /* Table Styling */
        .admin-table {
            color: var(--admin-text-main);
            margin-bottom: 0;
        }

        .admin-table th {
            background-color: transparent;
            color: var(--admin-text-subtle);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--admin-border);
            padding: 14px 18px;
        }

        .admin-table td {
            background-color: transparent;
            color: var(--admin-text-main);
            font-size: 0.88rem;
            border-bottom: 1px solid var(--admin-border);
            padding: 14px 18px;
            vertical-align: middle;
        }

        .admin-table tbody tr:hover td {
            background-color: rgba(255, 255, 255, 0.02);
        }

        /* Status Pills High Contrast */
        .badge-status-present {
            background-color: rgba(34, 197, 94, 0.15);
            color: #4ade80;
            border: 1px solid rgba(34, 197, 94, 0.35);
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.72rem;
        }

        .badge-status-late {
            background-color: rgba(245, 158, 11, 0.15);
            color: #fcd34d;
            border: 1px solid rgba(245, 158, 11, 0.35);
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.72rem;
        }

        .badge-status-absent {
            background-color: rgba(244, 63, 94, 0.15);
            color: #fb7185;
            border: 1px solid rgba(244, 63, 94, 0.35);
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.72rem;
        }

        /* Action Buttons */
        .btn-action-icon {
            background: transparent;
            border: none;
            color: var(--admin-text-subtle);
            padding: 4px 6px;
            transition: color 0.2s ease;
        }
        .btn-action-icon:hover {
            color: #ffffff;
        }

        .btn-purple {
            background-color: var(--admin-accent-purple);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 9px 18px;
            transition: background-color 0.2s ease;
        }

        .btn-purple:hover {
            background-color: var(--admin-accent-purple-hover);
            color: #ffffff;
        }

        /* Text Contrast Helper */
        .text-subtle {
            color: var(--admin-text-subtle) !important;
        }

        /* Modal Overrides */
        .admin-modal .modal-content {
            background-color: var(--admin-card-bg);
            border: 1px solid var(--admin-border);
            color: #ffffff;
            border-radius: 16px;
        }

        .admin-modal .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #ffffff;
        }

        .admin-modal .form-control, .admin-modal .form-select {
            background-color: var(--admin-input-bg);
            border: 1px solid var(--admin-border);
            color: #ffffff;
            border-radius: 10px;
            font-size: 0.88rem;
            padding: 10px 14px;
        }

        .admin-modal .form-control:focus, .admin-modal .form-select:focus {
            background-color: var(--admin-input-bg);
            color: #ffffff;
            border-color: var(--admin-accent-purple);
            box-shadow: none;
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(11, 17, 32, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1039;
        }

        @media (max-width: 991.98px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.show { transform: translateX(0); }
            .sidebar-backdrop.show { display: block; }
            .admin-main { margin-left: 0; }
        }
    </style>
</head>
<body>

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

    <!-- Mobile Sidebar Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleSidebar()"></div>

    <!-- Sidebar Navigation -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div>
            <div class="sidebar-brand d-flex align-items-center gap-2">
                <span>UYA Connect</span>
            </div>

            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-border-all"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.members') }}" class="sidebar-nav-link {{ request()->routeIs('admin.members*') ? 'active' : '' }}">
                        <i class="fa-regular fa-user"></i>
                        <span>Manage Members</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('activities') }}" class="sidebar-nav-link {{ request()->routeIs('activities*') ? 'active' : '' }}">
                        <i class="fa-regular fa-calendar-check"></i>
                        <span>Manage Activities</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.calendar') }}" class="sidebar-nav-link {{ request()->routeIs('admin.calendar') ? 'active' : '' }}">
                        <i class="fa-regular fa-calendar"></i>
                        <span>Calendar</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('proposals') }}" class="sidebar-nav-link {{ request()->routeIs('proposals*') ? 'active' : '' }}">
                        <i class="fa-regular fa-lightbulb"></i>
                        <span>Manage Proposals</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.announcements') }}" class="sidebar-nav-link {{ request()->routeIs('admin.announcements*') ? 'active' : '' }}">
                        <i class="fa-solid fa-bullhorn"></i>
                        <span>Announcements</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.attendance') }}" class="sidebar-nav-link {{ request()->routeIs('admin.attendance*') ? 'active' : '' }}">
                        <i class="fa-regular fa-circle-check"></i>
                        <span>Attendance</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile') }}" class="sidebar-nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                        <i class="fa-regular fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <button type="button" class="sidebar-nav-link border-0 bg-transparent w-100 text-start text-danger"
                data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Logout</span>
            </button>
        </div>
    </aside>

    <!-- Main Content Layout -->
    <main class="admin-main">

        <!-- Top Header Bar -->
        <header class="admin-topbar admin-content-container">
            <div class="d-flex align-items-center gap-3">
                <button class="btn text-white p-0 d-lg-none shadow-none border-0" type="button" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </button>
                <div>
                    <h6 class="topbar-user-title">Welcome back, {{ $authName }}!</h6>
                    <p class="topbar-user-role">{{ $authRole }}</p>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <button class="btn p-2 text-white border-0 position-relative shadow-none">
                    <i class="fa-regular fa-bell fa-lg"></i>
                </button>
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; font-size: 0.85rem;">
                    {{ strtoupper(substr($authName, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Main Workspace (Padding matching 0.75rem mobile / 2.5rem desktop) -->
        <div class="admin-content-container py-3 py-md-4">

            @if (session('success'))
                <div class="alert alert-success bg-success bg-opacity-20 text-success border-0 rounded-3 mb-3" style="font-size: 0.85rem;">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Row 1: 5 Metric Stat Cards -->
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

            <!-- Table Header -->
            <div class="mb-3">
                <h5 class="fw-bold mb-1 text-white">Attendance Records</h5>
            </div>

            <!-- Attendance Records Table Card -->
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
                                        @php
                                            $st = strtolower($record->status ?? 'absent');
                                        @endphp
                                        @if($st === 'present')
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

                <!-- Footer Pagination -->
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

        </div>
    </main>

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

    <!-- LOGOUT MODAL -->
    <div class="modal fade admin-modal" id="logoutConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 text-center">
                <div class="modal-body p-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="width: 56px; height: 56px; background-color: rgba(244, 63, 94, 0.15);">
                        <i class="fa-solid fa-arrow-right-from-bracket text-danger fa-lg"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Log out of Admin Portal?</h5>
                    <p class="text-subtle small mb-4">You'll need to sign in again to access your admin account.</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-outline-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger rounded-3 px-4">Yes, Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('show');
            document.getElementById('sidebarBackdrop').classList.toggle('show');
        }

        function editAttendance(record) {
            document.getElementById('editAttendanceForm').action = '/admin/attendance/' + record.id;
            document.getElementById('edit_member_name').value = record.member_name || (record.user ? record.user.name : '');
            document.getElementById('edit_activity_name').value = record.activity_name || (record.activity ? record.activity.title : '');

            let statusVal = (record.status || 'absent').toLowerCase();
            if (statusVal === 'present but late') statusVal = 'late';
            document.getElementById('edit_status').value = statusVal;

            const modal = new bootstrap.Modal(document.getElementById('editAttendanceModal'));
            modal.show();
        }
    </script>
</body>
</html>
