<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements Management - UYA Connect</title>

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

        /* Standardized Mobile-to-Desktop Container Spacing */
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

        /* Announcement Card Styling */
        .announcement-card {
            background-color: var(--admin-card-bg);
            border: 1px solid var(--admin-border);
            border-radius: 16px;
            padding: 22px;
            transition: border-color 0.2s ease;
        }

        .announcement-card:hover {
            border-color: rgba(255, 255, 255, 0.18);
        }

        .badge-audience {
            background-color: rgba(99, 102, 241, 0.25);
            color: #a5b4fc;
            font-weight: 600;
            font-size: 0.7rem;
            padding: 4px 10px;
            border-radius: 12px;
            border: 1px solid rgba(99, 102, 241, 0.4);
        }

        .badge-audience-officers {
            background-color: rgba(56, 189, 248, 0.2);
            color: #7dd3fc;
            font-weight: 600;
            font-size: 0.7rem;
            padding: 4px 10px;
            border-radius: 12px;
            border: 1px solid rgba(56, 189, 248, 0.4);
        }

        .badge-audience-admin {
            background-color: rgba(244, 63, 94, 0.2);
            color: #fda4af;
            font-weight: 600;
            font-size: 0.7rem;
            padding: 4px 10px;
            border-radius: 12px;
            border: 1px solid rgba(244, 63, 94, 0.4);
        }

        .badge-pinned {
            background-color: rgba(245, 158, 11, 0.2);
            color: #fcd34d;
            font-weight: 600;
            font-size: 0.7rem;
            padding: 4px 10px;
            border-radius: 12px;
            border: 1px solid rgba(245, 158, 11, 0.4);
        }

        /* Action Buttons */
        .btn-action-icon {
            background: transparent;
            border: none;
            color: var(--admin-text-subtle);
            padding: 6px;
            font-size: 0.95rem;
            transition: color 0.2s ease;
        }

        .btn-action-icon:hover {
            color: #ffffff;
        }

        .btn-action-icon.danger:hover {
            color: #fb7185;
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

        /* Legibility Helpers */
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
                    <a href="#" class="sidebar-nav-link">
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

        <!-- Main Workspace -->
        <div class="admin-content-container py-3 py-md-4">

            @if (session('success'))
                <div class="alert alert-success bg-success bg-opacity-20 text-success border-0 rounded-3 mb-3" style="font-size: 0.85rem;">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Title & Create Button Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold mb-1 text-white">Announcements</h4>
                </div>
                <button type="button" class="btn btn-purple d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createAnnouncementModal">
                    <i class="fa-solid fa-plus"></i> Create Announcement
                </button>
            </div>

            <!-- Announcements Feed Container -->
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

                                @php
                                    $audience = $announcement->target_audience ?? 'all';
                                @endphp
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

            <!-- Pagination Links -->
            @if(method_exists($announcements, 'links'))
                <div class="d-flex justify-content-center">
                    {{ $announcements->links() }}
                </div>
            @endif

        </div>
    </main>

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
</body>
</html>
