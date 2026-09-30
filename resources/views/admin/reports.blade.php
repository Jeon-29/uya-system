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
    }
    .form-select-admin:focus, .form-control-admin:focus {
        background-color: var(--admin-input-bg);
        color: #ffffff;
        border-color: var(--admin-accent-purple);
        box-shadow: none;
    }

    /* Print Styles */
    @media print {
        .admin-sidebar, .admin-topbar, .nav-pills-admin, form, .no-print, .pagination {
            display: none !important;
        }
        .admin-main {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        body {
            background-color: #ffffff !important;
            color: #000000 !important;
        }
        .admin-card {
            background-color: #ffffff !important;
            border: 1px solid #ddd !important;
            color: #000000 !important;
        }
        .stat-card-value, .fw-semibold, .text-white {
            color: #000000 !important;
        }
        .admin-table th, .admin-table td {
            color: #000000 !important;
            border-bottom: 1px solid #ddd !important;
        }
    }
</style>
@endpush

@section('content')
    <!-- Page Header & Action Controls -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-white">Reports & Analytics</h4>
            <p class="text-subtle small mb-0">Overview of member activity feedback and participation analytics.</p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <!-- Filter Controls -->
            <form method="GET" action="{{ route('admin.reports.index') }}" class="d-flex align-items-center gap-2 m-0">
                <input type="hidden" name="tab" value="{{ $tab }}">

                <select name="activity_id" class="form-select form-select-admin" onchange="this.form.submit()" style="min-width: 170px; max-width: 200px;">
                    <option value="">All Activities</option>
                    @foreach($activitiesList as $act)
                        <option value="{{ $act->id }}" {{ (string)$activityFilter === (string)$act->id ? 'selected' : '' }}>
                            {{ Str::limit($act->title, 25) }}
                        </option>
                    @endforeach
                </select>

                <div class="input-group" style="width: 200px;">
                    <input type="text" name="search" value="{{ $search }}" class="form-control form-control-admin border-end-0" placeholder="Search report...">
                    @if(!empty($search) || !empty($activityFilter))
                        <a href="{{ route('admin.reports.index', ['tab' => $tab]) }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center px-2.5 border-start-0" style="background-color: var(--admin-input-bg); border-color: var(--admin-border);">
                            <i class="fa-solid fa-xmark text-subtle"></i>
                        </a>
                    @else
                        <button type="submit" class="btn btn-outline-secondary d-flex align-items-center justify-content-center px-2.5 border-start-0" style="background-color: var(--admin-input-bg); border-color: var(--admin-border);">
                            <i class="fa-solid fa-magnifying-glass text-subtle"></i>
                        </button>
                    @endif
                </div>
            </form>

            <!-- Export Buttons -->
            <div class="d-flex align-items-center gap-2 no-print">
                <a href="{{ route('admin.reports.export', ['tab' => $tab, 'search' => $search, 'activity_id' => $activityFilter]) }}" class="btn btn-outline-light btn-sm rounded-pill px-3 py-2 fw-semibold" style="height: 38px; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-file-csv"></i> Export CSV
                </a>
                <button onclick="window.print()" class="btn btn-primary btn-sm rounded-pill px-3 py-2 fw-semibold" style="height: 38px; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-print"></i> Print / PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="d-flex align-items-center mb-4 no-print">
        <ul class="nav nav-pills nav-pills-admin bg-black bg-opacity-25 p-1 rounded-3 border border-white border-opacity-10">
            <li class="nav-item">
                <a class="nav-link {{ $tab === 'evaluation' ? 'active' : '' }}" href="{{ route('admin.reports.index', ['tab' => 'evaluation', 'search' => $search, 'activity_id' => $activityFilter]) }}">
                    <i class="fa-regular fa-comments me-1.5"></i> Activity Feedback
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $tab === 'attendance' ? 'active' : '' }}" href="{{ route('admin.reports.index', ['tab' => 'attendance', 'search' => $search, 'activity_id' => $activityFilter]) }}">
                    <i class="fa-solid fa-chart-column me-1.5"></i> Attendance Overview
                </a>
            </li>
        </ul>
    </div>

    @if($tab === 'evaluation')
        <!-- Evaluation Stats -->
        <div class="row g-2 g-md-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Total Responses</span>
                    <div class="stat-card-value text-present">{{ $stats['totalResponses'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Evaluated Activities</span>
                    <div class="stat-card-value text-late">{{ $stats['evaluatedActivitiesCount'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Most Responses</span>
                    <div class="stat-card-value text-white text-truncate" style="font-size: 1.1rem; margin-top: 8px;">
                        {{ $stats['mostEvaluatedTitle'] ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Qualitative Feedback Table -->
        <div class="admin-card p-0 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table admin-table align-middle">
                    <thead>
                        <tr>
                            <th>Member Name</th>
                            <th>Activity</th>
                            <th>Feedback / Comments</th>
                            <th style="width: 160px;">Date Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feedbacks as $fb)
                            <tr>
                                <td class="fw-semibold text-white">
                                    {{ $fb->member_name }}
                                    <span class="d-block text-subtle fw-normal small" style="font-size: 0.75rem;">{{ $fb->member_email }}</span>
                                </td>
                                <td class="text-subtle fw-medium">{{ $fb->activity_title }}</td>
                                <td class="text-white" style="max-width: 380px;">
                                    <div class="bg-black bg-opacity-25 p-2.5 rounded-3 border border-white border-opacity-10 small" style="line-height: 1.4;">
                                        "{{ $fb->comments }}"
                                    </div>
                                </td>
                                <td class="text-subtle small">
                                    {{ \Carbon\Carbon::parse($fb->created_at)->format('M j, Y g:i A') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-subtle py-5">
                                    <i class="fa-regular fa-comments fs-3 mb-2 d-block opacity-50"></i>
                                    No activity feedback responses found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($feedbacks, 'links') && $feedbacks->hasPages())
                <div class="d-flex justify-content-between align-items-center p-3 border-top border-white border-opacity-10 flex-wrap gap-2 no-print" style="font-size: 0.8rem;">
                    <div class="text-subtle">
                        Showing {{ $feedbacks->firstItem() ?? 0 }}-{{ $feedbacks->lastItem() ?? 0 }} of {{ $feedbacks->total() ?? 0 }} responses
                    </div>
                    <div>
                        {{ $feedbacks->links() }}
                    </div>
                </div>
            @endif
        </div>

    @else
        <!-- Attendance Stats -->
        <div class="row g-2 g-md-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Total Registrations</span>
                    <div class="stat-card-value">{{ $stats['totalRegistrations'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Attended (On-Time)</span>
                    <div class="stat-card-value text-present">{{ $stats['totalPresent'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Late</span>
                    <div class="stat-card-value text-late">{{ $stats['totalLate'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="admin-card stat-card h-100">
                    <span class="stat-card-title">Turnout Rate</span>
                    <div class="stat-card-value text-rate">{{ $stats['overallRate'] ?? 0 }}%</div>
                </div>
            </div>
        </div>

        <!-- Attendance Summary Table -->
        <div class="admin-card p-0 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table admin-table align-middle">
                    <thead>
                        <tr>
                            <th>Activity Title</th>
                            <th>Event Date</th>
                            <th class="text-center">Registered</th>
                            <th class="text-center">Attended</th>
                            <th class="text-center">Late</th>
                            <th class="text-center">Absent</th>
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
                                <td class="text-center fw-semibold text-subtle">{{ $abs }}</td>
                                <td class="text-end">
                                    <span class="badge bg-purple bg-opacity-20 text-purple px-2.5 py-1.5 rounded-pill border border-purple border-opacity-30">
                                        {{ $rate }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-subtle py-5">
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
