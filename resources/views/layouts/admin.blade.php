<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - UYA Connect')</title>

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

        .text-muted { color: var(--admin-text-muted) !important; }
        .text-subtle { color: var(--admin-text-subtle) !important; }

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

        /* Sidebar Navigation */
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

        /* Main Workspace Area */
        .admin-main {
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Sticky Top Bar Header */
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
            color: var(--admin-text-muted);
            margin: 0;
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(11, 17, 32, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1039;
        }

        /* Custom Notification Dropdown Styling */
        .notif-dropdown-menu {
            width: 340px;
            max-width: calc(100vw - 32px);
            background-color: #151e32;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            margin-top: 10px !important;
        }

        .notif-item {
            padding: 12px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            transition: background-color 0.15s ease;
        }
        .notif-item:hover {
            background-color: rgba(255, 255, 255, 0.04);
        }

        .notif-icon-circle {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background-color: rgba(99, 102, 241, 0.15);
            color: #818cf8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        /* Mobile Dropdown Centering */
        @media (max-width: 575.98px) {
            .dropdown-menu-end[data-bs-popper] {
                right: auto !important;
                left: 50% !important;
                transform: translateX(-50%) translateY(10px) !important;
            }
        }

        /* Custom Floating Dark Mode Toast */
        .admin-toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1090;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 360px;
            width: calc(100% - 40px);
        }

        .admin-toast {
            background-color: #1e293b;
            border: 1px solid var(--admin-border);
            color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            font-size: 0.85rem;
            overflow: hidden;
            animation: slideInRight 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .admin-toast-success { border-left: 4px solid #22c55e; }
        .admin-toast-danger { border-left: 4px solid #f43f5e; }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @media (max-width: 991.98px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.show { transform: translateX(0); }
            .sidebar-backdrop.show { display: block; }
            .admin-main { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

    @php
        $authUser = auth()->user();
        $authName = $authUser->name ?? 'User';
        $authRole = ucfirst($authUser->role ?? 'Officer');
        $isOfficer = ($authUser->role ?? '') === 'officer';
    @endphp

    <!-- Mobile Sidebar Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleSidebar()"></div>

    <!-- Master Toast Notifications Container -->
    <div class="admin-toast-container">
        @if (session('success'))
            <div class="toast admin-toast admin-toast-success align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000" data-bs-autohide="true">
                <div class="d-flex p-3">
                    <div class="toast-body p-0 d-flex align-items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-success fa-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto shadow-none" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="toast admin-toast admin-toast-danger align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000" data-bs-autohide="true">
                <div class="d-flex p-3">
                    <div class="toast-body p-0 d-flex align-items-center gap-2.5">
                        <i class="fa-solid fa-circle-exclamation text-danger fa-lg"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto shadow-none" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar Navigation Layout -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div>
            <div class="sidebar-brand d-flex align-items-center gap-2">
                <span>UYA Connect</span>
            </div>

            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
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
                    <a href="{{ route('admin.activities.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.activities*') ? 'active' : '' }}">
                        <i class="fa-regular fa-calendar-check"></i>
                        <span>Manage Activities</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.calendar') }}" class="sidebar-nav-link {{ request()->routeIs('admin.calendar*') ? 'active' : '' }}">
                        <i class="fa-regular fa-calendar"></i>
                        <span>Calendar</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.proposals.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.proposals*') ? 'active' : '' }}">
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
                    <a href="{{ route('admin.certificates.templates.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.certificates*') ? 'active' : '' }}">
                        <i class="fa-solid fa-certificate"></i>
                        <span>Certificates</span>
                    </a>
                </li>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <li>
                        <a href="{{ route('admin.reports.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('admin.profile') }}" class="sidebar-nav-link {{ request()->routeIs('admin.profile*') ? 'active' : '' }}">
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

    <!-- Main Content Area -->
    <main class="admin-main">
        <!-- Sticky Top Header Bar -->
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
                @php
                    $unreadCount = auth()->user()->unreadNotifications->count();
                    $recentNotifs = auth()->user()->unreadNotifications->take(4);
                @endphp

                <!-- Notifications Dropdown -->
                <div class="dropdown">
                    <button class="btn p-2 text-white border-0 position-relative shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        <i class="fa-regular fa-bell fa-lg"></i>
                        @if($unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-primary" style="font-size: 0.65rem; padding: 4px 6px;">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                        @endif
                    </button>

                    <div class="dropdown-menu dropdown-menu-end notif-dropdown-menu p-0">
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center px-3 py-3 border-bottom border-white border-opacity-10">
                            <h6 class="fw-bold mb-0 text-white" style="font-size: 0.95rem;">Notifications</h6>
                            @if($unreadCount > 0)
                                <form method="POST" action="{{ route('admin.notifications.read-all') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 text-decoration-none border-0 shadow-none text-primary fw-semibold" style="font-size: 0.78rem;">
                                        Mark all as read
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- Notification Feed Items -->
                        <div class="d-flex flex-column" style="max-height: 320px; overflow-y: auto;">
                            @forelse($recentNotifs as $notif)
                                @php $notifData = $notif->data ?? []; @endphp
                                <div class="notif-item d-flex align-items-start gap-3">
                                    <div class="notif-icon-circle">
                                        <i class="{{ $notifData['icon'] ?? 'fa-solid fa-bullhorn' }}"></i>
                                    </div>
                                    <div class="flex-grow-1 min-width-0">
                                        <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                            <span class="fw-semibold text-white text-truncate" style="font-size: 0.85rem;">
                                                {{ $notifData['title'] ?? 'Notification' }}
                                            </span>
                                            <form method="POST" action="{{ route('admin.notifications.read', $notif->id) }}" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-link text-muted p-0 border-0 shadow-none" title="Mark as read" style="font-size: 0.75rem;">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <p class="text-subtle mb-1 text-truncate" style="font-size: 0.78rem; line-height: 1.35;">
                                            {{ $notifData['message'] ?? '' }}
                                        </p>
                                        <div class="text-muted" style="font-size: 0.7rem;">
                                            <i class="fa-regular fa-clock me-1 opacity-75"></i>{{ $notif->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-subtle small">
                                    <i class="fa-regular fa-bell-slash fa-2x mb-2 d-block opacity-50"></i>
                                    You have no unread notifications.
                                </div>
                            @endforelse
                        </div>

                        <!-- Footer Link -->
                        <div class="p-2 text-center border-top border-white border-opacity-10">
                            <a href="{{ route('admin.notifications') }}" class="text-primary text-decoration-none fw-semibold d-block py-1" style="font-size: 0.82rem;">
                                View All Notifications
                            </a>
                        </div>
                    </div>
                </div>

                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; font-size: 0.85rem;">
                    {{ strtoupper(substr($authName, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Dynamic Content Section -->
        <div class="admin-content-container py-3 py-md-4">
            @yield('content')
        </div>
    </main>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 bg-dark text-white border-secondary p-3">
                <div class="modal-body text-center p-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="width: 56px; height: 56px; background-color: rgba(220, 53, 69, 0.15);">
                        <i class="fa-solid fa-arrow-right-from-bracket text-danger fa-lg"></i>
                    </div>
                    <h5 class="fw-bold mb-2">
                        {{ $isOfficer ? 'Log out of Officer Portal?' : 'Log out of Admin Portal?' }}
                    </h5>
                    <p class="text-muted small mb-4">
                        You'll need to sign in again to access your {{ $isOfficer ? 'officer' : 'admin' }} account.
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-outline-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-semibold">Yes, Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('show');
            document.getElementById('sidebarBackdrop').classList.toggle('show');
        }

        // Auto-initialize & show Bootstrap Toasts with 3s autohide delay
        document.addEventListener('DOMContentLoaded', function () {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.forEach(function (toastEl) {
                var toast = new bootstrap.Toast(toastEl, { delay: 3000, autohide: true });
                toast.show();
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
