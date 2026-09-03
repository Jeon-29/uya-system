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

        /* Full space container extension */
        .container-fluid {
            width: 100% !important;
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }

        /* Main Wrapper Cards */
        .pastel-card-primary {
            background-color: #ffffff;
            border: 1px solid rgba(131, 182, 190, 0.25) !important;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.04);
        }

        /* Distinct Inner Sub-cards for Announcements */
        .announcement-subcard {
            background-color: #f3f7f9;
            border: 1px solid #dce5e8 !important;
            transition: all 0.2s ease;
        }
        .announcement-subcard:hover {
            background-color: #ebf3f6;
            border-color: var(--uya-light-blue) !important;
        }

        /* Distinct Inner Sub-cards for Upcoming Activities */
        .activity-item {
            background-color: #f3f7f9;
            border: 1px solid #dce5e8 !important;
            transition: all 0.2s ease;
        }
        .activity-item:hover {
            background-color: #ebf3f6;
            border-color: var(--uya-light-blue) !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .custom-btn-outline {
            border-color: var(--uya-dark-teal);
            color: var(--uya-dark-teal);
            background-color: #ffffff;
        }
        .custom-btn-outline:hover {
            background-color: var(--uya-dark-teal);
            color: #fff;
        }
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <!-- Dashboard Main Contents (Edge-to-Edge Container) -->
    <div class="container-fluid py-3">

        <!-- Metric Cards Row -->
        <div class="row g-3 mb-4">

            <div class="col-6 col-md-6 col-xl-3">
                <div class="card shadow-sm rounded-4 p-2 p-md-3 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">My Activities</span>
                            <h2 class="fw-bold mb-0 mt-1 text-brand" style="font-size: 1.4rem;">{{ $stats['myActivities'] }}</h2>
                            <span class="text-muted" style="font-size: 0.75rem;">Activities joined</span>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: rgba(131, 182, 190, 0.2); color: var(--uya-dark-teal);">
                            <i class="fa-regular fa-calendar-days"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-6 col-xl-3">
                <div class="card shadow-sm rounded-4 p-2 p-md-3 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Upcoming</span>
                            <h2 class="fw-bold mb-0 mt-1 text-brand" style="font-size: 1.4rem;">{{ $stats['upcoming'] }}</h2>
                            <span class="text-muted" style="font-size: 0.75rem;">Upcoming activities</span>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: rgba(216, 178, 87, 0.2); color: var(--uya-gold);">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-6 col-xl-3">
                <div class="card shadow-sm rounded-4 p-2 p-md-3 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Notifications</span>
                            <h2 class="fw-bold mb-0 mt-1 text-brand" style="font-size: 1.4rem;">{{ $stats['notifications'] }}</h2>
                            <span class="text-muted" style="font-size: 0.75rem;">Active announcements</span>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: rgba(131, 182, 190, 0.2); color: var(--uya-dark-teal);">
                            <i class="fa-regular fa-bell"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-6 col-xl-3">
                <div class="card shadow-sm rounded-4 p-2 p-md-3 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Attendance Rate</span>
                            <h2 class="fw-bold mb-0 mt-1 text-brand" style="font-size: 1.4rem;">{{ $stats['attendanceRate'] }}%</h2>
                            <span class="text-muted" style="font-size: 0.75rem;">Your attendance</span>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: rgba(40, 167, 69, 0.15); color: #28a745;">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Main Content Section: Announcements & Upcoming Activities -->
        <div class="row g-4">

            <!-- Left Column: Recent Announcements -->
            <div class="col-lg-6">
                <div class="card shadow-sm rounded-4 p-4 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-brand">Recent Announcements</h5>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        @forelse ($announcements as $announcement)
                            <div class="p-3 rounded-3 announcement-subcard shadow-sm">
                                <h6 class="fw-bold mb-1 text-brand">{{ $announcement->title }}</h6>
                                <p class="text-muted small mb-2">{{ $announcement->content }}</p>
                                <div class="d-flex justify-content-between align-items-center" style="font-size: 0.75rem;">
                                    <span class="text-muted fw-semibold">{{ $announcement->author->name ?? 'Admin' }}</span>
                                    <span class="text-muted">{{ $announcement->created_at->format('M j, Y') }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small text-center py-3">No announcements yet.</p>
                        @endforelse
                    </div>

                    <div class="mt-3 text-end">
                        <a href="{{ route('announcements') }}" class="text-decoration-none small fw-bold text-brand">View all announcements &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Upcoming Activities -->
            <div class="col-lg-6">
                <div class="card shadow-sm rounded-4 p-4 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-brand">Upcoming Activities</h5>
                    </div>

                    <div class="d-flex flex-column gap-3">

                        @forelse ($upcomingActivities as $activity)
                            <div class="card rounded-3 p-3 activity-item shadow-sm">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold mb-0 text-brand">{{ $activity->title }}</h6>
                                    <span class="badge rounded-pill px-2 py-1" style="background-color: var(--uya-gold); color: #fff; font-size: 0.65rem;">{{ strtoupper($activity->status) }}</span>
                                </div>
                                <div class="text-muted small d-flex flex-column gap-1 mb-3">
                                    <div><i class="fa-regular fa-calendar me-2 text-secondary"></i> {{ $activity->date->format('D, M j, Y') }}</div>
                                    <div><i class="fa-solid fa-location-dot me-2 text-secondary"></i> {{ $activity->location }}</div>
                                    <div><i class="fa-solid fa-users me-2 text-secondary"></i> {{ $activity->participants_count ?? 0 }} participants</div>
                                </div>
                                <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm rounded-pill w-100 py-1 fw-semibold custom-btn-outline">View Activity</a>
                            </div>
                        @empty
                            <p class="text-muted small text-center py-3">No upcoming activities.</p>
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
