<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - UYA Connect</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --uya-dark-teal: #224d5b;
            --uya-light-blue: #83b6be;
            --uya-gold: #D8B257;
            --pastel-bg: #eaf1f3;
        }

        body {
            background-color: var(--pastel-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 85px;
        }

        .text-brand { color: var(--uya-dark-teal) !important; }

        /* Responsive Container: compact padding on mobile, spacious on desktop */
        .container-fluid {
            width: 100% !important;
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        @media (min-width: 768px) {
            .container-fluid {
                padding-left: 2.5rem !important;
                padding-right: 2.5rem !important;
            }
        }

        /* ============================================================
           Liquid glass design language (Apple style)
           ============================================================ */
        .pastel-card-primary,
        .announcement-subcard,
        .activity-item {
            background: rgba(255, 255, 255, 0.19);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(4.2px);
            -webkit-backdrop-filter: blur(4.2px);
            border: 1px solid rgba(255, 255, 255, 0.36) !important;
        }

        /* Corner radii: larger for primary panels */
        .pastel-card-primary { border-radius: 22px !important; }
        .announcement-subcard,
        .activity-item { border-radius: 16px !important; }

        /* Cards inside the panels: subtle hover effects */
        .announcement-subcard,
        .activity-item {
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .announcement-subcard:hover,
        .activity-item:hover {
            border-color: rgba(255, 255, 255, 0.6) !important;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.15);
            transform: translateY(-1px);
        }

        /* Glassy icon chips on the stat cards */
        .metric-icon {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Glossy status pill */
        .glossy-pill {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            color: #0f172a !important;
            font-weight: 700;
        }

        /* Refined button for sharp readability */
        .custom-btn-outline {
            border: 2px solid var(--uya-dark-teal);
            color: var(--uya-dark-teal);
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            font-weight: 600;
            transition: background 0.2s ease, color 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .custom-btn-outline:hover {
            background: var(--uya-dark-teal);
            border-color: var(--uya-dark-teal);
            color: #fff;
            box-shadow: 0 6px 16px rgba(34, 77, 91, 0.25);
        }

        /* High-contrast text color helpers */
        .card-dark-text {
            color: #0f172a !important;
        }
        .card-dark-subtext {
            color: #334155 !important;
        }
        .card-muted-label {
            color: #475569 !important;
        }

        /* Browsers without backdrop-filter get a fallback */
        @supports not ((backdrop-filter: blur(1px)) or (-webkit-backdrop-filter: blur(1px))) {
            .pastel-card-primary,
            .announcement-subcard,
            .activity-item {
                background: rgba(255, 255, 255, 0.92);
            }
        }
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <!-- Dashboard Main Contents -->
    <div class="container-fluid py-3 py-md-4">

        <!-- Header Section -->
        <div class="row mb-3 mb-md-4 px-2 px-md-0">
            <div class="col-12">
                <h3 class="fw-bold mb-1 text-brand">Hello, {{ auth()->user()->name ?? 'User' }}</h3>
            </div>
        </div>

        <!-- Metric Cards Row -->
        <div class="row g-2 g-md-3 mb-4">

            <div class="col-6 col-md-6 col-xl-3">
                <div class="card shadow-sm rounded-4 p-2 p-md-3 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase card-muted-label fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">My Activities</span>
                            <h2 class="fw-bold mb-0 mt-1 text-brand" style="font-size: 1.3rem;">{{ $stats['myActivities'] }}</h2>
                            <span class="card-dark-subtext fw-semibold" style="font-size: 0.7rem;">Activities joined</span>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 metric-icon" style="width: 35px; height: 35px; color: var(--uya-dark-teal);">
                            <i class="fa-regular fa-calendar-days fa-sm"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-6 col-xl-3">
                <div class="card shadow-sm rounded-4 p-2 p-md-3 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase card-muted-label fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Upcoming</span>
                            <h2 class="fw-bold mb-0 mt-1 text-brand" style="font-size: 1.3rem;">{{ $stats['upcoming'] }}</h2>
                            <span class="card-dark-subtext fw-semibold" style="font-size: 0.7rem;">Upcoming activities</span>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 metric-icon" style="width: 35px; height: 35px; color: var(--uya-gold);">
                            <i class="fa-solid fa-clock fa-sm"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-6 col-xl-3">
                <div class="card shadow-sm rounded-4 p-2 p-md-3 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase card-muted-label fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Notifications</span>
                            <h2 class="fw-bold mb-0 mt-1 text-brand" style="font-size: 1.3rem;">{{ $stats['notifications'] }}</h2>
                            <span class="card-dark-subtext fw-semibold" style="font-size: 0.7rem;">Active announcements</span>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 metric-icon" style="width: 35px; height: 35px; color: var(--uya-dark-teal);">
                            <i class="fa-regular fa-bell fa-sm"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-6 col-xl-3">
                <div class="card shadow-sm rounded-4 p-2 p-md-3 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase card-muted-label fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Attendance Rate</span>
                            <h2 class="fw-bold mb-0 mt-1 text-brand" style="font-size: 1.3rem;">{{ $stats['attendanceRate'] }}%</h2>
                            <span class="card-dark-subtext fw-semibold" style="font-size: 0.7rem;">Your attendance</span>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 metric-icon" style="width: 35px; height: 35px; color: #15803d;">
                            <i class="fa-solid fa-chart-line fa-sm"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Main Content Section: Announcements & Upcoming Activities -->
        <div class="row g-3 g-md-4">

            <!-- Left Column: Recent Announcements -->
            <div class="col-lg-6">
                <div class="card shadow-sm rounded-4 p-3 p-md-4 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-brand fs-6 fs-md-5">Recent Announcements</h5>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        @forelse ($announcements as $announcement)
                            <div class="p-3 rounded-3 announcement-subcard shadow-sm">
                                <h6 class="fw-bold mb-1 text-brand" style="font-size: 0.9rem;">{{ $announcement->title }}</h6>
                                <p class="card-dark-subtext small mb-2 fw-medium" style="font-size: 0.8rem;">{{ $announcement->content }}</p>
                                <div class="d-flex justify-content-between align-items-center" style="font-size: 0.75rem;">
                                    <span class="card-dark-text fw-bold">{{ $announcement->author->name ?? 'Admin' }}</span>
                                    <span class="card-muted-label fw-semibold">{{ $announcement->created_at->format('M j, Y') }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="card-dark-subtext small text-center py-3 fw-medium">No announcements yet.</p>
                        @endforelse
                    </div>

                    <div class="mt-3 text-end">
                        <a href="{{ route('announcements') }}" class="text-decoration-none small fw-bold text-brand">View all announcements &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Upcoming Activities -->
            <div class="col-lg-6">
                <div class="card shadow-sm rounded-4 p-3 p-md-4 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-brand fs-6 fs-md-5">Upcoming Activities</h5>
                    </div>

                    <div class="d-flex flex-column gap-3">

                        @forelse ($upcomingActivities as $activity)
                            <div class="card rounded-3 p-3 activity-item shadow-sm">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold mb-0 text-brand" style="font-size: 0.9rem;">{{ $activity->title }}</h6>
                                    <span class="badge rounded-pill px-2 py-1 glossy-pill" style="font-size: 0.65rem;">{{ strtoupper($activity->status) }}</span>
                                </div>
                                <div class="card-dark-subtext small d-flex flex-column gap-1 mb-3 fw-medium" style="font-size: 0.8rem;">
                                    <div><i class="fa-regular fa-calendar me-2 text-brand"></i> {{ $activity->date->format('D, M j, Y') }}</div>
                                    <div><i class="fa-solid fa-location-dot me-2 text-brand"></i> {{ $activity->location }}</div>
                                    <div><i class="fa-solid fa-users me-2 text-brand"></i> {{ $activity->participants_count ?? 0 }} participants</div>
                                </div>
                                <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm rounded-pill w-100 py-1 custom-btn-outline" style="font-size: 0.8rem;">View Activity</a>
                            </div>
                        @empty
                            <p class="card-dark-subtext small text-center py-3 fw-medium">No upcoming activities.</p>
                        @endforelse

                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
