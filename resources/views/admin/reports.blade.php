@extends('layouts.admin')

@section('title', 'Reports & Analytics - UYA Connect')

@push('styles')
<style>
    .admin-card { background-color: var(--admin-card-bg); border: 1px solid var(--admin-border); border-radius: 14px; padding: 20px; }
    .stat-card { padding: 14px 18px !important; }
    .stat-card-title { font-size: 0.76rem; color: var(--admin-text-subtle); font-weight: 600; }
    .stat-card-value { font-size: 1.55rem; font-weight: 700; color: #ffffff; margin-top: 4px; line-height: 1.2; }
    .stat-card-value.text-present { color: #4ade80; }
    .stat-card-value.text-late { color: #818cf8; }
    .stat-card-value.text-absent { color: #f87171; }
    .stat-card-value.text-rate { color: #818cf8; }
    .stat-card-value.text-male { color: #38bdf8; }
    .stat-card-value.text-female { color: #f472b6; }

    .chart-wrapper {
        position: relative;
        height: 270px;
        width: 100%;
    }

    .admin-table { color: var(--admin-text-main); margin-bottom: 0; }
    .admin-table th { background-color: transparent; color: var(--admin-text-subtle); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--admin-border); padding: 14px 18px; }
    .admin-table td { background-color: transparent; color: var(--admin-text-main); font-size: 0.88rem; border-bottom: 1px solid var(--admin-border); padding: 14px 18px; vertical-align: middle; }
    .admin-table tbody tr:hover td { background-color: rgba(255, 255, 255, 0.02); }

    .nav-pills-admin .nav-link {
        color: var(--admin-text-subtle);
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 8px;
        padding: 8px 18px;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .nav-pills-admin .nav-link.active {
        background-color: var(--admin-accent-purple);
        color: #ffffff;
    }

    .form-select-admin, .form-control-admin {
        background-color: var(--admin-input-bg);
        border: 1px solid var(--admin-border);
        color: #ffffff;
        border-radius: 10px;
        font-size: 0.85rem;
        padding: 8px 14px;
        height: 38px;
        width: auto;
    }
    .form-select-admin {
        padding-right: 34px;
    }
    .form-control-admin::placeholder {
        color: var(--admin-text-subtle);
        opacity: 0.75;
    }
    .form-select-admin:focus, .form-control-admin:focus {
        background-color: var(--admin-input-bg);
        color: #ffffff;
        border-color: var(--admin-accent-purple);
        box-shadow: none;
    }

    .badge-gender-male {
        background-color: rgba(56, 189, 248, 0.15);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.3);
    }
    .badge-gender-female {
        background-color: rgba(244, 114, 182, 0.15);
        color: #f472b6;
        border: 1px solid rgba(244, 114, 182, 0.3);
    }
    .badge-status-completed {
        background-color: rgba(74, 222, 128, 0.15);
        color: #4ade80;
        border: 1px solid rgba(74, 222, 128, 0.35);
    }
    .badge-turnout {
        background-color: rgba(129, 140, 248, 0.15);
        color: #818cf8;
        border: 1px solid rgba(129, 140, 248, 0.35);
    }

    /* Hidden on screen, visible only on Print / PDF */
    .print-org-header {
        display: none;
    }

    /* Print Styles */
    @page {
        size: landscape;
        margin: 10mm;
    }

    @media print {
        html, body {
            width: 100% !important;
            background-color: #ffffff !important;
            color: #0f172a !important;
            margin: 0 !important;
            padding: 0 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .admin-sidebar,
        .admin-topbar,
        .nav-pills-admin,
        .report-filter-form,
        .screen-page-header,
        .report-toolbar-row,
        .print-charts-row,
        .no-print,
        .pagination,
        .modal {
            display: none !important;
        }
        .print-org-header {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #224d5b;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .print-org-header img {
            height: 46px;
            width: auto;
            object-fit: contain;
        }
        .admin-main {
            margin-left: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        .admin-content-container {
            padding: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
        }
        /* Keep KPI cards in a single clean horizontal grid on print */
        .print-kpi-row {
            display: flex !important;
            flex-wrap: nowrap !important;
            gap: 8px !important;
            margin-bottom: 14px !important;
        }
        .print-kpi-row > div {
            flex: 1 1 0% !important;
            width: auto !important;
            max-width: none !important;
            padding: 0 !important;
        }
        .stat-card {
            padding: 8px 10px !important;
        }
        .stat-card-title {
            font-size: 0.68rem !important;
            color: #475569 !important;
            white-space: nowrap !important;
        }
        .stat-card-value {
            font-size: 1.15rem !important;
            color: #0f172a !important;
        }
        .admin-card {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
            box-shadow: none !important;
            padding: 12px !important;
        }
        .print-table-card {
            padding: 0 !important;
            overflow: visible !important;
        }
        .fw-semibold, .fw-bold, .text-white, .text-subtle {
            color: #0f172a !important;
        }
        .table-responsive {
            overflow: visible !important;
            width: 100% !important;
        }
        .admin-table {
            width: 100% !important;
            max-width: 100% !important;
            table-layout: fixed !important;
            border-collapse: collapse !important;
        }
        .admin-table th,
        .admin-table td {
            min-width: 0 !important;
            width: auto !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            padding: 7px 6px !important;
        }
        .admin-table th {
            color: #1e293b !important;
            background-color: #f1f5f9 !important;
            border-bottom: 1.5px solid #94a3b8 !important;
            font-size: 0.64rem !important;
            letter-spacing: 0.2px !important;
        }
        .admin-table td {
            color: #0f172a !important;
            border-bottom: 1px solid #cbd5e1 !important;
            font-size: 0.72rem !important;
            line-height: 1.35 !important;
        }
        /* Explicit proportional column widths for 7-col Activity Report on print */
        .print-activity-table th:nth-child(1),
        .print-activity-table td:nth-child(1) { width: 17% !important; }
        .print-activity-table th:nth-child(2),
        .print-activity-table td:nth-child(2) { width: 25% !important; }
        .print-activity-table th:nth-child(3),
        .print-activity-table td:nth-child(3) { width: 11% !important; }
        .print-activity-table th:nth-child(4),
        .print-activity-table td:nth-child(4) { width: 16% !important; }
        .print-activity-table th:nth-child(5),
        .print-activity-table td:nth-child(5) { width: 10% !important; }
        .print-activity-table th:nth-child(6),
        .print-activity-table td:nth-child(6) { width: 9% !important; }
        .print-activity-table th:nth-child(7),
        .print-activity-table td:nth-child(7) { width: 12% !important; }

        /* Explicit proportional column widths for 8-col Attendance Report on print */
        .print-attendance-table th:nth-child(1),
        .print-attendance-table td:nth-child(1) { width: 23% !important; }
        .print-attendance-table th:nth-child(2),
        .print-attendance-table td:nth-child(2) { width: 12% !important; }
        .print-attendance-table th:nth-child(3),
        .print-attendance-table td:nth-child(3) { width: 10% !important; }
        .print-attendance-table th:nth-child(4),
        .print-attendance-table td:nth-child(4) { width: 9% !important; }
        .print-attendance-table th:nth-child(5),
        .print-attendance-table td:nth-child(5) { width: 8% !important; }
        .print-attendance-table th:nth-child(6),
        .print-attendance-table td:nth-child(6) { width: 8% !important; }
        .print-attendance-table th:nth-child(7),
        .print-attendance-table td:nth-child(7) { width: 17% !important; }
        .print-attendance-table th:nth-child(8),
        .print-attendance-table td:nth-child(8) { width: 13% !important; }

        .badge {
            border: 1px solid #94a3b8 !important;
            color: #0f172a !important;
            background-color: #f8fafc !important;
            font-size: 0.64rem !important;
            padding: 2px 5px !important;
            display: inline-block !important;
            margin-bottom: 2px !important;
        }
    }
</style>
@endpush

@section('content')
    <!-- OFFICIAL PRINT / PDF HEADER (Hidden on screen, shown on print) -->
    <div class="print-org-header">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="UYA Connect Logo">
            <div>
                <h4 class="fw-bold mb-0" style="color: #224d5b; letter-spacing: 0.3px;">UYA Connect</h4>
                <div class="small fw-semibold" style="color: #475569;">United Youth Association • Official Organization Report</div>
            </div>
        </div>
        <div class="text-end">
            <div class="fw-bold" style="color: #0f172a; font-size: 0.95rem;">
                {{ $tab === 'attendance' ? 'Attendance Report' : 'Activity Report (Completed Events)' }}
            </div>
            <div class="small" style="color: #475569;">Period: {{ $periodLabel }}</div>
            <div class="small" style="color: #64748b; font-size: 0.72rem;">Generated: {{ now()->format('M j, Y g:i A') }}</div>
        </div>
    </div>

    <!-- Row 1: Page Title & Export Actions -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3 screen-page-header no-print">
        <div>
            <h4 class="fw-bold mb-1 text-white">Reports & Analytics</h4>
            <p class="text-subtle small mb-0">
                {{ $tab === 'attendance'
                    ? 'Summary of registered, on-time, late, and absent participants per activity.'
                    : 'Compilation of completed activities, events, and programs organized by UYA.' }}
            </p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-shrink-0 no-print">
            <a href="{{ route('admin.reports.export', ['tab' => $tab, 'search' => $search, 'activity_id' => $activityFilter, 'period' => $period]) }}" class="btn btn-outline-light btn-sm rounded-pill px-3 py-2 fw-semibold" style="height: 38px; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;">
                <i class="fa-solid fa-file-csv"></i> Export CSV
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm rounded-pill px-3 py-2 fw-semibold" style="height: 38px; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;">
                <i class="fa-solid fa-print"></i> Print / PDF
            </button>
        </div>
    </div>

    <!-- Row 2: Navigation Tabs (Left) & Filter Controls (Right) -->
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4 report-toolbar-row no-print">
        <ul class="nav nav-pills nav-pills-admin bg-black bg-opacity-25 p-1 rounded-3 border border-white border-opacity-10 align-self-start">
            <li class="nav-item">
                <a class="nav-link {{ $tab === 'activities' ? 'active' : '' }}" href="{{ route('admin.reports.index', ['tab' => 'activities', 'search' => $search, 'activity_id' => $activityFilter, 'period' => $period]) }}">
                    <i class="fa-regular fa-calendar-check me-1.5"></i> Activity Report
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $tab === 'attendance' ? 'active' : '' }}" href="{{ route('admin.reports.index', ['tab' => 'attendance', 'search' => $search, 'activity_id' => $activityFilter, 'period' => $period]) }}">
                    <i class="fa-solid fa-chart-line me-1.5"></i> Attendance Report
                </a>
            </li>
        </ul>

        <form method="GET" action="{{ route('admin.reports.index') }}" class="d-flex align-items-center gap-2 flex-wrap m-0 report-filter-form">
            <input type="hidden" name="tab" value="{{ $tab }}">

            <!-- Period Filter -->
            <select name="period" class="form-select form-select-admin" onchange="this.form.submit()" style="width: 155px;">
                <option value="all" {{ $period === 'all' ? 'selected' : '' }}>All Time</option>
                <option value="past_30_days" {{ $period === 'past_30_days' ? 'selected' : '' }}>Past 30 Days</option>
                <option value="this_month" {{ $period === 'this_month' ? 'selected' : '' }}>This Month</option>
                <option value="last_month" {{ $period === 'last_month' ? 'selected' : '' }}>Last Month</option>
                <option value="past_3_months" {{ $period === 'past_3_months' ? 'selected' : '' }}>Past 3 Months</option>
            </select>

            <!-- Activity Filter -->
            <select name="activity_id" class="form-select form-select-admin" onchange="this.form.submit()" style="width: 185px;">
                <option value="">All Activities</option>
                @foreach($activitiesList as $act)
                    <option value="{{ $act->id }}" {{ (string)$activityFilter === (string)$act->id ? 'selected' : '' }}>
                        {{ Str::limit($act->title, 25) }}
                    </option>
                @endforeach
            </select>

            <!-- Search Box -->
            <div class="input-group" style="width: 210px;">
                <input type="text" name="search" value="{{ $search }}" class="form-control form-control-admin border-end-0" placeholder="Search report...">
                @if(!empty($search) || !empty($activityFilter) || $period !== 'all')
                    <a href="{{ route('admin.reports.index', ['tab' => $tab]) }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center px-2.5 border-start-0" style="background-color: var(--admin-input-bg); border-color: var(--admin-border);" title="Reset Filters">
                        <i class="fa-solid fa-xmark text-subtle"></i>
                    </a>
                @else
                    <button type="submit" class="btn btn-outline-secondary d-flex align-items-center justify-content-center px-2.5 border-start-0" style="background-color: var(--admin-input-bg); border-color: var(--admin-border);">
                        <i class="fa-solid fa-magnifying-glass text-subtle"></i>
                    </button>
                @endif
            </div>
        </form>
    </div>

    @if($tab === 'activities')
        <!-- Activity Report KPI Stats -->
        <div class="row g-2 g-md-3 mb-4 print-kpi-row">
            <div class="col-6 col-md-4 col-xl">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Completed Activities</span>
                    <div class="stat-card-value">{{ $stats['totalCompletedActivities'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Total Participants</span>
                    <div class="stat-card-value text-present">{{ $stats['totalParticipants'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Avg. per Activity</span>
                    <div class="stat-card-value text-late">{{ $stats['avgParticipants'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Male Participants</span>
                    <div class="stat-card-value text-male">{{ $stats['maleCount'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Female Participants</span>
                    <div class="stat-card-value text-female">{{ $stats['femaleCount'] ?? 0 }}</div>
                </div>
            </div>
        </div>

        <!-- Visual Analytics Charts (Screen Only — Hidden on Print / PDF) -->
        <div class="row g-3 mb-4 print-charts-row no-print">
            <div class="col-12 col-lg-8">
                <div class="admin-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="fw-bold text-white mb-0">Completed Activities Turnout ({{ $periodLabel }})</h6>
                            <span class="text-subtle small" style="font-size: 0.75rem;">Total participants per completed UYA activity</span>
                        </div>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="activityLineChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="admin-card h-100">
                    <div class="mb-3">
                        <h6 class="fw-bold text-white mb-0">Participant Gender Split</h6>
                        <span class="text-subtle small" style="font-size: 0.75rem;">Gender breakdown across completed events</span>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="activityGenderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Activities Compilation Table -->
        <div class="admin-card p-0 overflow-hidden mb-4 print-table-card">
            <div class="table-responsive">
                <table class="table admin-table align-middle print-activity-table">
                    <thead>
                        <tr>
                            <th style="min-width: 170px;">Activity Title</th>
                            <th style="min-width: 240px;">Description</th>
                            <th style="min-width: 130px;">Date</th>
                            <th style="min-width: 150px;">Venue</th>
                            <th>Status</th>
                            <th class="text-center">Participants</th>
                            <th class="text-center">Male / Female</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activityReports as $actRow)
                            @php
                                $participants = ($actRow->total_attended ?? 0) + ($actRow->total_late ?? 0);
                                $male = $actRow->male_count ?? 0;
                                $female = $actRow->female_count ?? 0;
                            @endphp
                            <tr>
                                <td class="fw-semibold text-white">{{ $actRow->title }}</td>
                                <td class="text-subtle small" style="line-height: 1.45;">
                                    {{ Str::limit($actRow->description ?? 'No description provided.', 110) }}
                                </td>
                                <td class="text-subtle small">
                                    {{ $actRow->date ? \Carbon\Carbon::parse($actRow->date)->format('M j, Y') : 'N/A' }}
                                    <span class="d-block" style="font-size: 0.75rem;">
                                        {{ $actRow->date ? \Carbon\Carbon::parse($actRow->date)->format('g:i A') : '' }}
                                    </span>
                                </td>
                                <td class="text-subtle small">
                                    <i class="fa-solid fa-location-dot me-1 opacity-75"></i>
                                    {{ $actRow->location ?? 'N/A' }}
                                </td>
                                <td>
                                    <span class="badge badge-status-completed px-2.5 py-1 rounded-pill" style="font-size: 0.72rem; font-weight: 600;">
                                        {{ ucfirst($actRow->status ?? 'Completed') }}
                                    </span>
                                </td>
                                <td class="text-center fw-bold text-success fs-6">{{ $participants }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill badge-gender-male px-2 py-1 me-1" title="Male Participants">
                                        <i class="fa-solid fa-mars me-1"></i>{{ $male }}
                                    </span>
                                    <span class="badge rounded-pill badge-gender-female px-2 py-1" title="Female Participants">
                                        <i class="fa-solid fa-venus me-1"></i>{{ $female }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-subtle py-5">
                                    <i class="fa-regular fa-calendar-xmark fs-3 mb-2 d-block opacity-50"></i>
                                    No completed activities found for the selected period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($activityReports, 'links') && $activityReports->hasPages())
                <div class="d-flex justify-content-between align-items-center p-3 border-top border-white border-opacity-10 flex-wrap gap-2 no-print" style="font-size: 0.8rem;">
                    <div class="text-subtle">
                        Showing {{ $activityReports->firstItem() ?? 0 }}-{{ $activityReports->lastItem() ?? 0 }} of {{ $activityReports->total() ?? 0 }} completed activities
                    </div>
                    <div>
                        {{ $activityReports->links() }}
                    </div>
                </div>
            @endif
        </div>

    @else
        <!-- Attendance Report Stats -->
        <div class="row g-2 g-md-3 mb-4 print-kpi-row">
            <div class="col-6 col-md-4 col-xl-2">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Total Registered</span>
                    <div class="stat-card-value">{{ $stats['totalRegistrations'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">On-Time</span>
                    <div class="stat-card-value text-present">{{ $stats['totalOnTime'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Late</span>
                    <div class="stat-card-value text-late">{{ $stats['totalLate'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Absent</span>
                    <div class="stat-card-value text-absent">{{ $stats['totalAbsent'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Male / Female</span>
                    <div class="d-flex align-items-center gap-2 mt-1">
                        <span class="fw-bold fs-5 text-male">{{ $stats['maleCount'] ?? 0 }}</span>
                        <span class="text-subtle">/</span>
                        <span class="fw-bold fs-5 text-female">{{ $stats['femaleCount'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Turnout Rate</span>
                    <div class="stat-card-value text-rate">{{ $stats['overallRate'] ?? 0 }}%</div>
                </div>
            </div>
        </div>

        <!-- Visual Analytics Charts (Screen Only — Hidden on Print / PDF) -->
        <div class="row g-3 mb-4 print-charts-row no-print">
            <div class="col-12 col-lg-8">
                <div class="admin-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="fw-bold text-white mb-0">Participation Trend Across Activities</h6>
                            <span class="text-subtle small" style="font-size: 0.75rem;">Comparison of Registered vs. Attended (On-Time & Late)</span>
                        </div>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="attendanceLineChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="admin-card h-100">
                    <div class="mb-3">
                        <h6 class="fw-bold text-white mb-0">Attendee Gender Breakdown</h6>
                        <span class="text-subtle small" style="font-size: 0.75rem;">Verified participants by gender</span>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="attendanceGenderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Summary Table -->
        <div class="admin-card p-0 overflow-hidden mb-4 print-table-card">
            <div class="table-responsive">
                <table class="table admin-table align-middle print-attendance-table">
                    <thead>
                        <tr>
                            <th>Activity Title</th>
                            <th>Event Date</th>
                            <th class="text-center">Registered</th>
                            <th class="text-center">On-Time</th>
                            <th class="text-center">Late</th>
                            <th class="text-center">Absent</th>
                            <th class="text-center">Male / Female</th>
                            <th class="text-end">Turnout Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendanceSummary as $actSummary)
                            @php
                                $reg = $actSummary->total_registered ?? 0;
                                $att = $actSummary->total_attended ?? 0;
                                $late = $actSummary->total_late ?? 0;
                                $abs = $actSummary->total_absent ?? 0;
                                $male = $actSummary->male_count ?? 0;
                                $female = $actSummary->female_count ?? 0;
                                $rate = $reg > 0 ? round((($att + $late) / $reg) * 100) : 0;
                            @endphp
                            <tr>
                                <td class="fw-semibold text-white">{{ $actSummary->title }}</td>
                                <td class="text-subtle small">
                                    {{ $actSummary->date ? \Carbon\Carbon::parse($actSummary->date)->format('M j, Y') : 'N/A' }}
                                </td>
                                <td class="text-center fw-medium text-white">{{ $reg }}</td>
                                <td class="text-center fw-semibold text-success">{{ $att }}</td>
                                <td class="text-center fw-semibold text-warning">{{ $late }}</td>
                                <td class="text-center fw-semibold text-danger">{{ $abs }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill badge-gender-male px-2 py-1 me-1" title="Male Attendees">
                                        <i class="fa-solid fa-mars me-1"></i>{{ $male }}
                                    </span>
                                    <span class="badge rounded-pill badge-gender-female px-2 py-1" title="Female Attendees">
                                        <i class="fa-solid fa-venus me-1"></i>{{ $female }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <span class="badge badge-turnout px-2.5 py-1.5 rounded-pill" style="font-size: 0.72rem; font-weight: 600;">
                                        {{ $rate }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-subtle py-5">
                                    <i class="fa-solid fa-chart-column fs-3 mb-2 d-block opacity-50"></i>
                                    No attendance summary reports found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($attendanceSummary, 'links') && $attendanceSummary->hasPages())
                <div class="d-flex justify-content-between align-items-center p-3 border-top border-white border-opacity-10 flex-wrap gap-2 no-print" style="font-size: 0.8rem;">
                    <div class="text-subtle">
                        Showing {{ $attendanceSummary->firstItem() ?? 0 }}-{{ $attendanceSummary->lastItem() ?? 0 }} of {{ $attendanceSummary->total() ?? 0 }} activities
                    </div>
                    <div>
                        {{ $attendanceSummary->links() }}
                    </div>
                </div>
            @endif
        </div>
    @endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const activeTab = @json($tab);
    const chartData = @json($chartData);

    const commonGridColor = 'rgba(255, 255, 255, 0.08)';
    const commonTickColor = '#94a3b8';

    function renderGenderChart(canvasId, genderCounts) {
        const ctx = document.getElementById(canvasId);
        if (!ctx) return;

        const labels = ['Male', 'Female'];
        const values = [genderCounts.male || 0, genderCounts.female || 0];
        const colors = ['#38bdf8', '#f472b6'];

        if ((genderCounts.other || 0) > 0) {
            labels.push('Other / Unspecified');
            values.push(genderCounts.other);
            colors.push('#94a3b8');
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderColor: '#151e32',
                    borderWidth: 3,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '66%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#cbd5e1',
                            padding: 14,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 12, weight: '600' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#ffffff',
                        bodyColor: '#cbd5e1',
                        borderColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 1,
                        padding: 10
                    }
                }
            }
        });
    }

    if (activeTab === 'attendance') {
        const lineCtx = document.getElementById('attendanceLineChart');
        if (lineCtx) {
            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: chartData.labels || [],
                    datasets: [
                        {
                            label: 'Registered',
                            data: chartData.registered || [],
                            borderColor: '#818cf8',
                            backgroundColor: 'rgba(129, 140, 248, 0.15)',
                            borderWidth: 2.5,
                            tension: 0.35,
                            fill: true,
                            pointBackgroundColor: '#818cf8',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Attended (On-Time & Late)',
                            data: chartData.attended || [],
                            borderColor: '#4ade80',
                            backgroundColor: 'rgba(74, 222, 128, 0.15)',
                            borderWidth: 2.5,
                            tension: 0.35,
                            fill: true,
                            pointBackgroundColor: '#4ade80',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#cbd5e1',
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: { size: 12, weight: '600' }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleColor: '#ffffff',
                            bodyColor: '#cbd5e1',
                            borderColor: 'rgba(255,255,255,0.1)',
                            borderWidth: 1,
                            padding: 10
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: commonGridColor },
                            ticks: { color: commonTickColor, font: { size: 11 } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: commonGridColor },
                            ticks: { color: commonTickColor, precision: 0, font: { size: 11 } }
                        }
                    }
                }
            });
        }

        renderGenderChart('attendanceGenderChart', chartData.gender || {});
    } else {
        const actLineCtx = document.getElementById('activityLineChart');
        if (actLineCtx) {
            new Chart(actLineCtx, {
                type: 'line',
                data: {
                    labels: chartData.labels || [],
                    datasets: [
                        {
                            label: 'Participants',
                            data: chartData.participants || [],
                            borderColor: '#4ade80',
                            backgroundColor: 'rgba(74, 222, 128, 0.15)',
                            borderWidth: 2.5,
                            tension: 0.35,
                            fill: true,
                            pointBackgroundColor: '#4ade80',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#cbd5e1',
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: { size: 12, weight: '600' }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleColor: '#ffffff',
                            bodyColor: '#cbd5e1',
                            borderColor: 'rgba(255,255,255,0.1)',
                            borderWidth: 1,
                            padding: 10
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: commonGridColor },
                            ticks: { color: commonTickColor, font: { size: 11 } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: commonGridColor },
                            ticks: { color: commonTickColor, precision: 0, font: { size: 11 } }
                        }
                    }
                }
            });
        }

        renderGenderChart('activityGenderChart', chartData.gender || {});
    }
});
</script>
@endpush
