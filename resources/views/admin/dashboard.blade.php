<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - UYA Connect</title>

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
            --admin-text-main: #f8fafc;
            --admin-text-muted: #94a3b8;
            --admin-border: rgba(255, 255, 255, 0.08);
        }

        body {
            background-color: var(--admin-bg);
            color: var(--admin-text-main);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Standardized Responsive Container */
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

        /* Main Content Area */
        .admin-main {
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Header */
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

        /* Base Card Styling */
        .admin-card {
            background-color: var(--admin-card-bg);
            border: 1px solid var(--admin-border);
            border-radius: 14px;
            padding: 20px;
            transition: all 0.2s ease;
        }

        /* Stat Card Compact Styling (~20% Height Reduction) */
        .stat-card {
            padding: 13px 16px !important;
        }

        .stat-card-title {
            font-size: 0.76rem;
            color: #cbd5e1;
            font-weight: 600;
        }

        .stat-card-icon {
            font-size: 0.95rem;
            color: #818cf8;
        }

        .stat-card-value {
            font-size: 1.45rem;
            font-weight: 700;
            color: #ffffff;
            margin-top: 2px;
            margin-bottom: 1px;
            line-height: 1.25;
        }

        .stat-card-sub {
            font-size: 0.72rem;
            color: #94a3b8;
            font-weight: 500;
        }

        /* Status Pills */
        .status-pill-card {
            background-color: var(--admin-card-bg);
            border: 1px solid var(--admin-border);
            border-radius: 12px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .status-icon-box {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .status-icon-approved { background-color: rgba(99, 102, 241, 0.2); color: #818cf8; }
        .status-icon-pending { background-color: rgba(148, 163, 184, 0.15); color: #cbd5e1; }
        .status-icon-rejected { background-color: rgba(244, 63, 94, 0.2); color: #fb7185; }

        /* Inner Feed Cards */
        .feed-item {
            padding: 12px 0;
            border-bottom: 1px solid var(--admin-border);
        }

        .feed-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .feed-title {
            font-size: 0.88rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 4px;
        }

        .feed-desc {
            font-size: 0.78rem;
            color: var(--admin-text-muted);
            line-height: 1.4;
            margin-bottom: 6px;
        }

        .feed-meta {
            font-size: 0.72rem;
            color: #94a3b8;
        }

        .upcoming-pill {
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--admin-text-muted);
            font-size: 0.65rem;
            padding: 2px 8px;
            border-radius: 12px;
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(11, 17, 32, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1039;
        }

        /* Mobile Adjustments */
        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .sidebar-backdrop.show {
                display: block;
            }
            .admin-main {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    @php
        $user = auth()->user();
        $userName = $user->name ?? 'User';
        $userRole = ucfirst($user->role ?? 'Officer');
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
                    <h6 class="topbar-user-title">Welcome back, {{ $userName }}!</h6>
                    <p class="topbar-user-role">{{ $userRole }}</p>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <button class="btn p-2 text-white border-0 position-relative shadow-none">
                    <i class="fa-regular fa-bell fa-lg"></i>
                    <span class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-primary" style="font-size: 0.55rem;">
                        {{ $stats['pendingProposals'] }}
                    </span>
                </button>
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; font-size: 0.85rem;">
                    {{ strtoupper(substr($userName, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Body Dashboard Workspace with Standardized Padding -->
        <div class="admin-content-container py-3 py-md-4">

            <!-- Title Header -->
            <div class="mb-4">
                <h4 class="fw-bold mb-1 text-white">{{ $userRole }} Dashboard</h4>
                <p class="text-muted small mb-0">Welcome back, {{ $userName }}! Here's your overview</p>
            </div>

            <!-- Row 1: Compact Metric Cards (Height Reduced 20%, High-Contrast Icons/Text) -->
            <div class="row g-2 g-md-3 mb-3">
                <div class="col-6 col-md-6 col-xl-3">
                    <div class="admin-card stat-card h-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="stat-card-title">Total Members</span>
                            <i class="fa-solid fa-users stat-card-icon"></i>
                        </div>
                        <div class="stat-card-value">{{ $stats['totalMembers'] }}</div>
                        <div class="stat-card-sub">{{ $stats['activeMembers'] }} active members</div>
                    </div>
                </div>

                <div class="col-6 col-md-6 col-xl-3">
                    <div class="admin-card stat-card h-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="stat-card-title">Total Activities</span>
                            <i class="fa-regular fa-calendar-days stat-card-icon"></i>
                        </div>
                        <div class="stat-card-value">{{ $stats['totalActivities'] }}</div>
                        <div class="stat-card-sub">{{ $stats['upcomingActivitiesCount'] }} upcoming</div>
                    </div>
                </div>

                <div class="col-6 col-md-6 col-xl-3">
                    <div class="admin-card stat-card h-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="stat-card-title">Pending Approvals</span>
                            <i class="fa-regular fa-clock stat-card-icon"></i>
                        </div>
                        <div class="stat-card-value">{{ $stats['pendingProposals'] }}</div>
                        <div class="stat-card-sub">Attendance awaiting review</div>
                    </div>
                </div>

                <div class="col-6 col-md-6 col-xl-3">
                    <div class="admin-card stat-card h-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="stat-card-title">Overall Attendance</span>
                            <i class="fa-solid fa-chart-line stat-card-icon"></i>
                        </div>
                        <div class="stat-card-value">{{ $stats['attendanceRate'] }}%</div>
                        <div class="stat-card-sub">Approval rate</div>
                    </div>
                </div>
            </div>

            <!-- Row 2: Dynamic Status Pill Summaries -->
            <div class="row g-2 g-md-3 mb-4">
                <div class="col-4">
                    <div class="status-pill-card">
                        <div class="status-icon-box status-icon-approved">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <span class="d-block text-muted" style="font-size: 0.72rem;">Approved</span>
                            <span class="fw-bold text-white fs-5">{{ $stats['approvedProposals'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="status-pill-card">
                        <div class="status-icon-box status-icon-pending">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div>
                            <span class="d-block text-muted" style="font-size: 0.72rem;">Pending</span>
                            <span class="fw-bold text-white fs-5">{{ $stats['pendingProposals'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="status-pill-card">
                        <div class="status-icon-box status-icon-rejected">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                        <div>
                            <span class="d-block text-muted" style="font-size: 0.72rem;">Rejected</span>
                            <span class="fw-bold text-white fs-5">{{ $stats['rejectedProposals'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 3: Dynamic Announcements & Upcoming Activities -->
            <div class="row g-3 g-md-4">

                <!-- Left Column: Recent Announcements Feed -->
                <div class="col-12 col-lg-6">
                    <div class="admin-card h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0 text-white" style="font-size: 0.95rem;">Recent Announcements</h6>
                            <a href="{{ route('announcements') }}" class="text-decoration-none small text-muted">View all</a>
                        </div>

                        <div class="d-flex flex-column">
                            @forelse($recentAnnouncements as $announcement)
                                <div class="feed-item">
                                    <h6 class="feed-title">{{ $announcement->title }}</h6>
                                    <p class="feed-desc">{{ $announcement->content }}</p>
                                    <span class="feed-meta">{{ $announcement->author->name ?? 'Admin' }} · {{ $announcement->created_at->format('n/j/Y') }}</span>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4 small">No recent announcements posted.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Column: Upcoming Activities List -->
                <div class="col-12 col-lg-6">
                    <div class="admin-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0 text-white" style="font-size: 0.95rem;">Upcoming Activities</h6>
                                <a href="{{ route('activities') }}" class="text-decoration-none small text-muted">View all</a>
                            </div>

                            <div class="d-flex flex-column">
                                @forelse($upcomingActivities as $activity)
                                    <div class="feed-item">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="feed-title mb-0">{{ $activity->title ?? 'Activity' }}</h6>
                                            <span class="upcoming-pill">upcoming</span>
                                        </div>
                                        <div class="feed-meta d-flex flex-column gap-1 mt-2">
                                            <div><i class="fa-regular fa-calendar me-2"></i> {{ \Carbon\Carbon::parse($activity->date)->format('n/j/Y') }}</div>
                                            <div><i class="fa-solid fa-location-dot me-2"></i> {{ $activity->location ?? 'TBD' }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted py-4 small">No upcoming activities scheduled.</div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Footer Role Badge -->
                        <div class="text-end pt-3">
                            <span class="badge border border-secondary text-muted fw-normal px-3 py-1.5" style="font-size: 0.72rem;">
                                {{ $userRole }} <i class="fa-solid fa-chevron-up ms-1" style="font-size: 0.6rem;"></i>
                            </span>
                        </div>
                    </div>
                </div>

            </div>

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
                    <h5 class="fw-bold mb-2">Log out of Admin Portal?</h5>
                    <p class="text-muted small mb-4">You'll need to sign in again to access your admin account.</p>
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

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('show');
            document.getElementById('sidebarBackdrop').classList.toggle('show');
        }
    </script>
</body>
</html>
