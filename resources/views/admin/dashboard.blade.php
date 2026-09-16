@extends('layouts.admin')

@section('title', 'Admin Dashboard - UYA Connect')

@push('styles')
<style>
    .admin-card {
        background-color: var(--admin-card-bg);
        border: 1px solid var(--admin-border);
        border-radius: 14px;
        padding: 20px;
        transition: all 0.2s ease;
    }
    .admin-card-clickable {
        cursor: pointer;
        text-decoration: none !important;
        display: block;
    }
    .admin-card-clickable:hover {
        background-color: var(--admin-card-hover);
        border-color: rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }

    .stat-card { padding: 13px 16px !important; }
    .stat-card-title { font-size: 0.76rem; color: #cbd5e1; font-weight: 600; }
    .stat-card-icon { font-size: 0.95rem; color: #818cf8; }
    .stat-card-value { font-size: 1.45rem; font-weight: 700; color: #ffffff; margin-top: 2px; margin-bottom: 1px; line-height: 1.25; }
    .stat-card-sub { font-size: 0.72rem; color: #94a3b8; font-weight: 500; }

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
        width: 36px; height: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.95rem; flex-shrink: 0;
    }
    .status-icon-approved { background-color: rgba(99, 102, 241, 0.2); color: #818cf8; }
    .status-icon-pending { background-color: rgba(148, 163, 184, 0.15); color: #cbd5e1; }
    .status-icon-rejected { background-color: rgba(244, 63, 94, 0.2); color: #fb7185; }

    .feed-item { padding: 12px 0; border-bottom: 1px solid var(--admin-border); }
    .feed-item:last-child { border-bottom: none; padding-bottom: 0; }
    .feed-title { font-size: 0.88rem; font-weight: 600; color: #ffffff; margin-bottom: 4px; }
    .feed-desc { font-size: 0.78rem; color: var(--admin-text-muted); line-height: 1.4; margin-bottom: 6px; }
    .feed-meta { font-size: 0.72rem; color: #94a3b8; }
    .upcoming-pill { border: 1px solid rgba(255, 255, 255, 0.2); color: var(--admin-text-muted); font-size: 0.65rem; padding: 2px 8px; border-radius: 12px; }

    /* Minimal Log Row Styling */
    .log-row {
        background-color: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        padding: 10px 14px;
        transition: background-color 0.15s ease;
    }
    .log-row:hover {
        background-color: rgba(255, 255, 255, 0.04);
    }
    .log-icon-box {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background-color: rgba(99, 102, 241, 0.15);
        color: #818cf8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')
    @php
        $authUser = auth()->user();
        $authName = $authUser->name ?? 'User';
        $authRole = ucfirst($authUser->role ?? 'Officer');
    @endphp

    <div class="mb-4">
        <h4 class="fw-bold mb-1 text-white">{{ $authRole }} Dashboard</h4>
        <p class="text-muted small mb-0">Welcome back, {{ $authName }}! Here's your overview</p>
    </div>

    <!-- Row 1: Clickable Metric Cards -->
    <div class="row g-2 g-md-3 mb-3">
        <div class="col-6 col-md-6 col-xl-3">
            <a href="{{ route('admin.members') }}" class="admin-card admin-card-clickable stat-card h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="stat-card-title">Total Members</span>
                    <i class="fa-solid fa-users stat-card-icon"></i>
                </div>
                <div class="stat-card-value">{{ $stats['totalMembers'] ?? 0 }}</div>
                <div class="stat-card-sub">{{ $stats['activeMembers'] ?? 0 }} active members</div>
            </a>
        </div>

        <div class="col-6 col-md-6 col-xl-3">
            <a href="{{ route('activities') }}" class="admin-card admin-card-clickable stat-card h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="stat-card-title">Total Activities</span>
                    <i class="fa-regular fa-calendar-days stat-card-icon"></i>
                </div>
                <div class="stat-card-value">{{ $stats['totalActivities'] ?? 0 }}</div>
                <div class="stat-card-sub">{{ $stats['upcomingActivitiesCount'] ?? 0 }} upcoming</div>
            </a>
        </div>

        <div class="col-6 col-md-6 col-xl-3">
            <a href="{{ route('admin.attendance') }}" class="admin-card admin-card-clickable stat-card h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="stat-card-title">Pending Approvals</span>
                    <i class="fa-regular fa-clock stat-card-icon"></i>
                </div>
                <div class="stat-card-value">{{ $stats['pendingProposals'] ?? 0 }}</div>
                <div class="stat-card-sub">Attendance awaiting review</div>
            </a>
        </div>

        <div class="col-6 col-md-6 col-xl-3">
            <a href="{{ route('admin.attendance') }}" class="admin-card admin-card-clickable stat-card h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="stat-card-title">Overall Attendance</span>
                    <i class="fa-solid fa-chart-line stat-card-icon"></i>
                </div>
                <div class="stat-card-value">{{ $stats['attendanceRate'] ?? 0 }}%</div>
                <div class="stat-card-sub">Approval rate</div>
            </a>
        </div>
    </div>

    <!-- Row 2: Status Pill Summaries -->
    <div class="row g-2 g-md-3 mb-4">
        <div class="col-4">
            <a href="{{ route('proposals') }}" class="status-pill-card text-decoration-none">
                <div class="status-icon-box status-icon-approved">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div>
                    <span class="d-block text-muted" style="font-size: 0.72rem;">Approved</span>
                    <span class="fw-bold text-white fs-5">{{ $stats['approvedProposals'] ?? 0 }}</span>
                </div>
            </a>
        </div>

        <div class="col-4">
            <a href="{{ route('proposals') }}" class="status-pill-card text-decoration-none">
                <div class="status-icon-box status-icon-pending">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <div>
                    <span class="d-block text-muted" style="font-size: 0.72rem;">Pending</span>
                    <span class="fw-bold text-white fs-5">{{ $stats['pendingProposals'] ?? 0 }}</span>
                </div>
            </a>
        </div>

        <div class="col-4">
            <a href="{{ route('proposals') }}" class="status-pill-card text-decoration-none">
                <div class="status-icon-box status-icon-rejected">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div>
                    <span class="d-block text-muted" style="font-size: 0.72rem;">Rejected</span>
                    <span class="fw-bold text-white fs-5">{{ $stats['rejectedProposals'] ?? 0 }}</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Row 3: Recent Announcements & Upcoming Activities -->
    <div class="row g-3 g-md-4 mb-4">
        <div class="col-12 col-lg-6">
            <div class="admin-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0 text-white" style="font-size: 0.95rem;">Recent Announcements</h6>
                    <a href="{{ route('admin.announcements') }}" class="text-decoration-none small text-muted">View all</a>
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

                <div class="text-end pt-3">
                    <span class="badge border border-secondary text-muted fw-normal px-3 py-1.5" style="font-size: 0.72rem;">
                        {{ $authRole }} <i class="fa-solid fa-chevron-up ms-1" style="font-size: 0.6rem;"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 4: System Activity Audit Trail -->
    <div class="admin-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="fw-bold text-white mb-0" style="font-size: 0.95rem;">
                    <i class="fa-solid fa-bolt me-2 text-primary"></i>Recent System Activity
                </h6>
            </div>
            <a href="{{ route('admin.profile') }}" class="text-decoration-none small text-muted">View my logs</a>
        </div>

        <div class="d-flex flex-column gap-2">
            @forelse($recentActivityLogs as $log)
                <div class="log-row d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2.5 overflow-hidden">
                        <div class="log-icon-box">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div class="text-truncate">
                            <span class="fw-semibold text-white me-2" style="font-size: 0.85rem;">
                                {{ $log->user->name ?? 'System' }}
                            </span>
                            <span class="badge border border-white border-opacity-10 text-subtle me-2" style="font-size: 0.68rem;">
                                {{ $log->action }}
                            </span>
                            @if($log->description)
                                <span class="text-subtle small text-truncate d-none d-md-inline">• {{ $log->description }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 ms-auto text-muted" style="font-size: 0.75rem;">
                        <span><i class="fa-regular fa-clock me-1 opacity-75"></i>{{ $log->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-4 small">
                    <i class="fa-solid fa-clock-rotate-left fa-2x mb-2 d-block opacity-50"></i>
                    No system activity recorded yet.
                </div>
            @endforelse
        </div>
    </div>
@endsection
