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
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .pastel-card-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(34, 77, 91, 0.08) !important;
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

        <!-- Welcome Header Section -->
        <div class="row mb-3">
            <div class="col-12">
                <h2 class="fw-bold mb-1 text-brand">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}!</h2>
                <p class="text-muted small">Here's what's happening in your community today[cite: 1].</p>
            </div>
        </div>

        <!-- Metric Cards Row -->
        <div class="row g-3 mb-4">

            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm rounded-4 p-3 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">My Activities</span>
                            <h2 class="fw-bold mb-0 mt-1 text-brand">6</h2>
                            <span class="text-muted small">Activities joined</span>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background-color: rgba(131, 182, 190, 0.2); color: var(--uya-dark-teal);">
                            <i class="fa-regular fa-calendar-days fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm rounded-4 p-3 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Upcoming</span>
                            <h2 class="fw-bold mb-0 mt-1 text-brand">4</h2>
                            <span class="text-muted small">Upcoming activities</span>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background-color: rgba(216, 178, 87, 0.2); color: var(--uya-gold);">
                            <i class="fa-solid fa-clock fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm rounded-4 p-3 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Notifications</span>
                            <h2 class="fw-bold mb-0 mt-1 text-brand">3</h2>
                            <span class="text-muted small">Active announcements</span>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background-color: rgba(131, 182, 190, 0.2); color: var(--uya-dark-teal);">
                            <i class="fa-regular fa-bell fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm rounded-4 p-3 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Attendance Rate</span>
                            <h2 class="fw-bold mb-0 mt-1 text-brand">50%</h2>
                            <span class="text-muted small">Your attendance</span>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background-color: rgba(40, 167, 69, 0.15); color: #28a745;">
                            <i class="fa-solid fa-chart-line fa-lg"></i>
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
                        <!-- Announcement Sub-card 1 -->
                        <div class="p-3 rounded-3 announcement-subcard shadow-sm">
                            <h6 class="fw-bold mb-1 text-brand">New Activity Schedule Released</h6>
                            <p class="text-muted small mb-2">The schedule for next month activities is now available. Check the Activities page for details.</p>
                            <div class="d-flex justify-content-between align-items-center" style="font-size: 0.75rem;">
                                <span class="text-muted fw-semibold">Nayeon</span>
                                <span class="text-muted">March 18, 2026</span>
                            </div>
                        </div>

                        <!-- Announcement Sub-card 2 -->
                        <div class="p-3 rounded-3 announcement-subcard shadow-sm">
                            <h6 class="fw-bold mb-1 text-brand">Attendance Marking System Update</h6>
                            <p class="text-muted small mb-2">We have updated the attendance marking system. You can now upload proof of attendance directly.</p>
                            <div class="d-flex justify-content-between align-items-center" style="font-size: 0.75rem;">
                                <span class="text-muted fw-semibold">Jihyo</span>
                                <span class="text-muted">March 17, 2026</span>
                            </div>
                        </div>

                        <!-- Announcement Sub-card 3 -->
                        <div class="p-3 rounded-3 announcement-subcard shadow-sm">
                            <h6 class="fw-bold mb-1 text-brand">Welcome New Members!</h6>
                            <p class="text-muted small mb-2">Please join us in welcoming our new members to UYA Connect. Looking forward to great activities together!</p>
                            <div class="d-flex justify-content-between align-items-center" style="font-size: 0.75rem;">
                                <span class="text-muted fw-semibold">Jeongyeon</span>
                                <span class="text-muted">March 15, 2026</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 text-end">
                        <a href="#" class="text-decoration-none small fw-bold text-brand">View all announcements &rarr;</a>
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

                        <!-- Activity Sub-card 1 -->
                        <div class="card rounded-3 p-3 activity-item shadow-sm">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-bold mb-0 text-brand">Community Service Day</h6>
                                <span class="badge rounded-pill px-2 py-1" style="background-color: var(--uya-gold); color: #fff; font-size: 0.65rem;">UPCOMING</span>
                            </div>
                            <div class="text-muted small d-flex flex-column gap-1 mb-3">
                                <div><i class="fa-regular fa-calendar me-2 text-secondary"></i> Fri, Jul 4, 2026</div>
                                <div><i class="fa-solid fa-location-dot me-2 text-secondary"></i> Carmona City Park</div>
                                <div><i class="fa-solid fa-users me-2 text-secondary"></i> 6 participants</div>
                            </div>
                            <button class="btn btn-sm rounded-pill w-100 py-1 fw-semibold custom-btn-outline">View Activity</button>
                        </div>

                        <!-- Activity Sub-card 2 -->
                        <div class="card rounded-3 p-3 activity-item shadow-sm">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-bold mb-0 text-brand">Tech Workshop: Web Development</h6>
                                <span class="badge rounded-pill px-2 py-1" style="background-color: var(--uya-gold); color: #fff; font-size: 0.65rem;">UPCOMING</span>
                            </div>
                            <div class="text-muted small d-flex flex-column gap-1 mb-3">
                                <div><i class="fa-regular fa-calendar me-2 text-secondary"></i> Tue, Jul 8, 2026</div>
                                <div><i class="fa-solid fa-location-dot me-2 text-secondary"></i> SM Aura</div>
                                <div><i class="fa-solid fa-users me-2 text-secondary"></i> 6 participants</div>
                            </div>
                            <button class="btn btn-sm rounded-pill w-100 py-1 fw-semibold custom-btn-outline">View Activity</button>
                        </div>

                        <!-- Activity Sub-card 3 -->
                        <div class="card rounded-3 p-3 activity-item shadow-sm">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-bold mb-0 text-brand">Leadership Training</h6>
                                <span class="badge rounded-pill px-2 py-1" style="background-color: var(--uya-gold); color: #fff; font-size: 0.65rem;">UPCOMING</span>
                            </div>
                            <div class="text-muted small d-flex flex-column gap-1 mb-3">
                                <div><i class="fa-regular fa-calendar me-2 text-secondary"></i> Fri, Jul 18, 2026</div>
                                <div><i class="fa-solid fa-location-dot me-2 text-secondary"></i> Conference Room A</div>
                                <div><i class="fa-solid fa-users me-2 text-secondary"></i> 6 participants</div>
                            </div>
                            <button class="btn btn-sm rounded-pill w-100 py-1 fw-semibold custom-btn-outline">View Activity</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
