<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar Management - UYA Connect</title>

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
            --admin-cyan: #38bdf8;
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

        /* Top Bar Header */
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
            border-radius: 16px;
            padding: 20px;
        }

        /* High Contrast Header Labels */
        .cal-weekday-header {
            color: var(--admin-text-subtle) !important;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Calendar Grid Scaffolding */
        .cal-week-row {
            display: flex;
            gap: 4px;
            width: 100%;
        }

        .cal-day-cell {
            flex: 1;
            min-width: 0;
            background-color: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--admin-border);
            border-radius: 10px;
            min-height: 80px;
            padding: 6px 8px;
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .cal-day-cell:hover {
            background-color: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .cal-day-cell .day-num {
            color: #ffffff !important;
            font-size: 0.88rem;
            font-weight: 700;
        }

        .cal-day-cell.other-month {
            background-color: rgba(0, 0, 0, 0.25);
            border-color: rgba(255, 255, 255, 0.03);
        }

        .cal-day-cell.other-month .day-num {
            color: #64748b !important;
        }

        .cal-day-cell.today-cell {
            border: 2px solid var(--admin-accent-purple) !important;
            background-color: rgba(99, 102, 241, 0.12) !important;
        }

        .cal-day-cell.selected-cell {
            box-shadow: 0 0 0 2px var(--admin-accent-purple) inset;
        }

        .event-pill {
            font-size: 0.68rem;
            padding: 3px 6px;
            border-radius: 4px;
            font-weight: 600;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 4px;
            background-color: var(--admin-accent-purple);
            color: #ffffff;
            transition: transform 0.15s ease;
        }

        .event-pill:hover {
            transform: translateY(-1px);
        }

        /* Icon Colors */
        .icon-cyan {
            color: var(--admin-cyan) !important;
        }

        /* Buttons Styling */
        .btn-purple {
            background-color: var(--admin-accent-purple);
            color: #ffffff;
            border: none;
            border-radius: 50rem;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 9px 18px;
            transition: background-color 0.2s ease;
        }
        .btn-purple:hover {
            background-color: var(--admin-accent-purple-hover);
            color: #ffffff;
        }

        .btn-outline-pill {
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            border-radius: 50rem;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 9px 18px;
            background: transparent;
            transition: all 0.2s ease;
        }
        .btn-outline-pill:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: #ffffff;
            color: #ffffff;
        }

        /* High-Legibility Text Helper Classes */
        .text-high-legibility {
            color: var(--admin-text-subtle) !important;
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(11, 17, 32, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1039;
        }

        /* Responsive Mobile Layout Alignments */
        @media (max-width: 991.98px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.show { transform: translateX(0); }
            .sidebar-backdrop.show { display: block; }
            .admin-main { margin-left: 0; }

            .cal-day-cell {
                min-height: 55px;
                padding: 4px;
            }
            .event-pill {
                font-size: 0.6rem;
                padding: 2px 4px;
            }
        }
    </style>
</head>
<body>

    @php
        $authUser = auth()->user();
        $authName = $authUser->name ?? 'User';
        $authRole = ucfirst($authUser->role ?? 'Officer');

        // Build dynamic calendar days array
        $calendarDays = [];
        $dayIter = $startOfCalendar->copy();
        while ($dayIter->lte($endOfCalendar)) {
            $calendarDays[] = $dayIter->copy();
            $dayIter->addDay();
        }
        $weeks = array_chunk($calendarDays, 7);

        // Initial default activity selection
        $initialActivity = $upcomingActivities->first();
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
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link">
                        <i class="fa-solid fa-border-all"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.members') }}" class="sidebar-nav-link">
                        <i class="fa-regular fa-user"></i>
                        <span>Manage Members</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('activities') }}" class="sidebar-nav-link">
                        <i class="fa-regular fa-calendar-check"></i>
                        <span>Manage Activities</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.calendar') }}" class="sidebar-nav-link active">
                        <i class="fa-regular fa-calendar"></i>
                        <span>Calendar</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('proposals') }}" class="sidebar-nav-link">
                        <i class="fa-regular fa-lightbulb"></i>
                        <span>Manage Proposals</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('announcements') }}" class="sidebar-nav-link">
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
                    <a href="{{ route('profile') }}" class="sidebar-nav-link">
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

            <!-- Title Header -->
            <div class="mb-4">
                <h4 class="fw-bold mb-1 text-white">Calendar</h4>
            </div>

            <!-- Main Grid Scaffolding -->
            <div class="row g-3 g-md-4">

                <!-- Left Column: Calendar Grid -->
                <div class="col-12 col-lg-8">
                    <div class="admin-card">

                        <!-- Header Month Navigation -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0 text-white" style="font-size: 1.1rem;">
                                <i class="fa-regular fa-calendar-days me-2" style="color: var(--admin-accent-purple);"></i>
                                <span>{{ $currentMonth->format('F Y') }}</span>
                            </h6>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('admin.calendar') }}" class="btn btn-sm btn-outline-light px-3 py-1 rounded-pill fw-semibold text-decoration-none" style="font-size: 0.78rem;">Today</a>
                                <div class="btn-group border border-secondary rounded-pill overflow-hidden shadow-sm" style="background-color: rgba(255,255,255,0.05);">
                                    <a href="{{ route('admin.calendar', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}" class="btn btn-sm btn-dark px-2.5 border-0 text-white"><i class="fa-solid fa-chevron-left fa-xs"></i></a>
                                    <a href="{{ route('admin.calendar', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}" class="btn btn-sm btn-dark px-2.5 border-0 text-white"><i class="fa-solid fa-chevron-right fa-xs"></i></a>
                                </div>
                            </div>
                        </div>

                        <!-- Readable Weekday Headers -->
                        <div class="row text-center mb-2 g-0">
                            <div class="col cal-weekday-header">Sun</div>
                            <div class="col cal-weekday-header">Mon</div>
                            <div class="col cal-weekday-header">Tue</div>
                            <div class="col cal-weekday-header">Wed</div>
                            <div class="col cal-weekday-header">Thu</div>
                            <div class="col cal-weekday-header">Fri</div>
                            <div class="col cal-weekday-header">Sat</div>
                        </div>

                        <!-- Dynamic Calendar Grid -->
                        <div class="d-flex flex-column gap-2" style="font-size: 0.85rem;">
                            @foreach($weeks as $week)
                                <div class="cal-week-row">
                                    @foreach($week as $date)
                                        @php
                                            $dateKey = $date->format('Y-m-d');
                                            $isOtherMonth = $date->month !== $currentMonth->month;
                                            $isToday = $date->isToday();
                                            $dayActivities = $activities->get($dateKey, collect());
                                        @endphp
                                        <div class="cal-day-cell {{ $isOtherMonth ? 'other-month' : '' }} {{ $isToday ? 'today-cell' : '' }}"
                                             onclick="selectDay('{{ $date->format('l, F j, Y') }}', {{ json_encode($dayActivities) }})">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="day-num">{{ $date->day }}</span>
                                            </div>
                                            <div class="mt-1">
                                                @foreach($dayActivities as $act)
                                                    <span class="event-pill" title="{{ $act->title ?? $act->name }}"
                                                          onclick="event.stopPropagation(); displayActivityDetails({{ json_encode($act) }}, '{{ $date->format('l, F j, Y') }}')">
                                                        {{ $act->title ?? $act->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                <!-- Right Column: Event Info Card & Upcoming List -->
                <div class="col-12 col-lg-4 d-flex flex-column gap-3 gap-md-4">

                    <!-- Selected Activity Details Card -->
                    <div class="admin-card">
                        <div id="sideCardDate" class="text-high-legibility mb-2 fw-semibold" style="font-size: 0.85rem;">
                            {{ $initialActivity ? \Carbon\Carbon::parse($initialActivity->date)->format('l, F j, Y') : now()->format('l, F j, Y') }}
                        </div>

                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 id="sideCardTitle" class="fw-bold mb-0 text-white" style="font-size: 1.1rem;">
                                {{ $initialActivity->title ?? 'No Activities Scheduled' }}
                            </h5>
                            <span id="sideCardBadge" class="badge bg-warning bg-opacity-20 text-warning px-2 py-1 {{ $initialActivity ? '' : 'd-none' }}" style="font-size: 0.65rem;">
                                Scheduled
                            </span>
                        </div>

                        <!-- Clean FontAwesome Icons & Legible Subtext -->
                        <div id="sideCardMeta" class="text-high-legibility small d-flex flex-column gap-1.5 mb-3" style="font-size: 0.85rem;">
                            <div>
                                <i class="fa-solid fa-location-dot icon-cyan me-2"></i>
                                <span id="sideCardLocation">{{ $initialActivity->location ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <i class="fa-solid fa-users icon-cyan me-2"></i>
                                <span id="sideCardParticipants">{{ isset($initialActivity->participants) ? $initialActivity->participants . ' participants' : '0 participants' }}</span>
                            </div>
                        </div>

                        <p id="sideCardDesc" class="text-high-legibility small mb-4" style="font-size: 0.85rem; line-height: 1.5;">
                            {{ $initialActivity->description ?? 'There are no activities or events scheduled for this day.' }}
                        </p>

                        <!-- Clean Pill Action Buttons -->
                        <div class="d-flex flex-column gap-2">
                            <a id="btnViewDetails" href="{{ isset($initialActivity->id) ? route('activities.show', $initialActivity->id) : '#' }}"
                               class="btn btn-outline-pill w-100 text-center text-decoration-none d-flex align-items-center justify-content-center gap-2 {{ $initialActivity ? '' : 'disabled opacity-50' }}">
                                <i class="fa-regular fa-eye"></i>
                                <span>View Details</span>
                            </a>
                            <button type="button" id="btnViewQR" class="btn btn-purple w-100 d-flex align-items-center justify-content-center gap-2 {{ $initialActivity ? '' : 'disabled opacity-50' }}">
                                <i class="fa-solid fa-qrcode"></i>
                                <span>View QR / Attendance</span>
                            </button>
                        </div>
                    </div>

                    <!-- Upcoming Activities Card -->
                    <div class="admin-card">
                        <h6 class="fw-bold mb-3 text-white" style="font-size: 0.95rem;">Upcoming Activities</h6>
                        <div class="d-flex flex-column gap-3">
                            @forelse($upcomingActivities as $upcoming)
                                <div class="pb-2 border-bottom border-white border-opacity-10" role="button"
                                     onclick="displayActivityDetails({{ json_encode($upcoming) }}, '{{ \Carbon\Carbon::parse($upcoming->date)->format('l, F j, Y') }}')">
                                    <span class="fw-bold text-white d-block mb-1" style="font-size: 0.88rem;">{{ $upcoming->title ?? $upcoming->name }}</span>
                                    <span class="text-high-legibility" style="font-size: 0.78rem;">
                                        <i class="fa-regular fa-calendar icon-cyan me-1"></i> {{ \Carbon\Carbon::parse($upcoming->date)->format('n/j/Y') }} • {{ $upcoming->location ?? 'TBD' }}
                                    </span>
                                </div>
                            @empty
                                <div class="text-center text-high-legibility py-3 small">No upcoming activities scheduled.</div>
                            @endforelse
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </main>

    <!-- Logout Modal -->
    <div class="modal fade admin-modal" id="logoutConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 bg-dark text-white border-secondary p-3">
                <div class="modal-body text-center p-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="width: 56px; height: 56px; background-color: rgba(244, 63, 94, 0.15);">
                        <i class="fa-solid fa-arrow-right-from-bracket text-danger fa-lg"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Log out of Admin Portal?</h5>
                    <p class="text-high-legibility small mb-4">You'll need to sign in again to access your admin account.</p>
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

        function displayActivityDetails(activity, dateFormatted) {
            if (!activity) return;

            document.getElementById('sideCardDate').innerText = dateFormatted;
            document.getElementById('sideCardTitle').innerText = activity.title || activity.name || 'Activity';
            document.getElementById('sideCardLocation').innerText = activity.location || 'N/A';
            document.getElementById('sideCardParticipants').innerText = activity.participants ? activity.participants + ' participants' : '0 participants';
            document.getElementById('sideCardDesc').innerText = activity.description || 'No detailed description available.';

            document.getElementById('sideCardBadge').classList.remove('d-none');

            const viewBtn = document.getElementById('btnViewDetails');
            viewBtn.classList.remove('disabled', 'opacity-50');
            viewBtn.href = '/activities/' + (activity.id || '');

            const qrBtn = document.getElementById('btnViewQR');
            qrBtn.classList.remove('disabled', 'opacity-50');
        }

        function selectDay(dateFormatted, dayActivities) {
            document.getElementById('sideCardDate').innerText = dateFormatted;

            if (dayActivities && dayActivities.length > 0) {
                displayActivityDetails(dayActivities[0], dateFormatted);
            } else {
                document.getElementById('sideCardTitle').innerText = 'No Activities Scheduled';
                document.getElementById('sideCardLocation').innerText = 'N/A';
                document.getElementById('sideCardParticipants').innerText = '0 participants';
                document.getElementById('sideCardDesc').innerText = 'There are no activities or events scheduled for this day.';
                document.getElementById('sideCardBadge').classList.add('d-none');

                const viewBtn = document.getElementById('btnViewDetails');
                viewBtn.classList.add('disabled', 'opacity-50');
                viewBtn.href = '#';

                const qrBtn = document.getElementById('btnViewQR');
                qrBtn.classList.add('disabled', 'opacity-50');
            }
        }
    </script>
</body>
</html>
