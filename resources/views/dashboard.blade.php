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

        /* =============================================
           ACTIVITY CARD (compact — dashboard preview)
           ============================================= */
        .activity-card {
            position: relative;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
            border-radius: 1rem;
            height: 100%;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.04);
            border: 1px solid rgba(131, 182, 190, 0.25);
            overflow: hidden;
        }

        .activity-card__header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0.85rem 1rem 0.4rem;
        }
        .activity-card__icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--card-gradient);
            color: var(--icon-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .activity-card__badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.6rem;
            font-weight: 700;
            padding: 0.25rem 0.55rem;
            border-radius: 50rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .activity-card__badge--gold      { background-color: var(--uya-gold); color: #2a2a2a; }
        .activity-card__badge--primary   { background-color: rgba(13,110,253,0.12); color: #0d6efd; }
        .activity-card__badge--success    { background-color: rgba(25,135,84,0.12); color: #198754; }
        .activity-card__badge--muted      { background-color: rgba(108,117,125,0.12); color: #6c757d; }
        .activity-card__badge--secondary  { background-color: rgba(108,117,125,0.12); color: #6c757d; }
        .activity-card__badge--pulse {
            background-color: rgba(13,110,253,0.12);
            color: #0d6efd;
        }
        .activity-card__pulse-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #0d6efd;
            animation: dash-pulse 1.6s infinite;
        }
        @keyframes dash-pulse {
            0%   { box-shadow: 0 0 0 0 rgba(13,110,253,0.6); }
            70%  { box-shadow: 0 0 0 6px rgba(13,110,253,0); }
            100% { box-shadow: 0 0 0 0 rgba(13,110,253,0); }
        }

        .activity-card__body {
            padding: 0 1rem 0.6rem;
            flex-shrink: 0;
        }
        .activity-card__title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--uya-dark-teal);
            margin: 0 0 0.4rem;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .activity-card__chip {
            display: inline-block;
            font-size: 0.6rem;
            font-weight: 600;
            padding: 0.12rem 0.45rem;
            border-radius: 50rem;
            background-color: rgba(34,77,91,0.08);
            color: var(--uya-dark-teal);
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 0.4rem;
        }
        .activity-card__meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem 0.75rem;
            padding: 0.5rem 1rem;
            background-color: #f8fbfc;
            border-top: 1px solid rgba(131,182,190,0.18);
        }
        .activity-card__meta-item {
            display: flex;
            align-items: flex-start;
            gap: 0.4rem;
            font-size: 0.72rem;
        }
        .activity-card__meta-item i {
            color: var(--uya-light-blue);
            margin-top: 0.12rem;
            width: 13px;
            text-align: center;
            flex-shrink: 0;
        }
        .activity-card__meta-label {
            font-size: 0.58rem;
            color: #9aa8ad;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            font-weight: 600;
        }
        .activity-card__meta-value {
            font-size: 0.75rem;
            color: #2c3e44;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .activity-card__actions {
            padding: 0.4rem 1rem 1rem;
            display: flex;
            gap: 0.4rem;
            margin-top: auto;
        }
        .activity-card__btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.5rem 0.65rem;
            border-radius: 50rem;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            white-space: nowrap;
        }
        .activity-card__btn--ghost {
            background-color: #ffffff;
            color: var(--uya-dark-teal);
            border-color: var(--uya-dark-teal);
        }
        .activity-card__btn--ghost:hover {
            background-color: var(--uya-dark-teal);
            color: #fff;
        }
        .activity-card__btn--primary {
            background-color: var(--uya-dark-teal);
            color: #fff;
            border-color: var(--uya-dark-teal);
        }
        .activity-card__btn--primary:hover { filter: brightness(0.92); }
        .activity-card__btn--blue {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .activity-card__btn--disabled {
            background-color: #e9ecef;
            color: #6c757d;
            cursor: not-allowed;
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

        /* =============================================
           COMPACT MOBILE LAYOUT
           ============================================= */
        @media (max-width: 575.98px) {
            .activity-card {
                border-radius: 0.85rem;
            }
            .activity-card__header {
                padding: 0.6rem 0.75rem 0.25rem;
            }
            .activity-card__icon {
                width: 34px;
                height: 34px;
                border-radius: 8px;
                font-size: 0.85rem;
            }
            .activity-card__badge {
                font-size: 0.55rem;
                padding: 0.18rem 0.4rem;
            }
            .activity-card__body {
                padding: 0.1rem 0.75rem 0.4rem;
            }
            .activity-card__title {
                font-size: 0.88rem;
                margin-bottom: 0.2rem;
                -webkit-line-clamp: 1;
            }
            .activity-card__chip {
                font-size: 0.55rem;
                padding: 0.08rem 0.4rem;
                margin-bottom: 0.25rem;
            }
            .activity-card__desc {
                font-size: 0.7rem;
                -webkit-line-clamp: 1;
            }
            .activity-card__meta {
                grid-template-columns: 1fr 1fr 1fr;
                gap: 0.25rem 0.4rem;
                padding: 0.35rem 0.75rem;
                overflow: hidden;
            }
            .activity-card__meta-item {
                font-size: 0.62rem;
                gap: 0.25rem;
                align-items: center;
            }
            .activity-card__meta-label {
                display: none;
            }
            .activity-card__meta-value {
                font-size: 0.62rem;
            }
            .activity-card__actions {
                padding: 0.3rem 0.75rem 0.7rem;
                gap: 0.3rem;
            }
            .activity-card__btn {
                font-size: 0.68rem;
                padding: 0.4rem 0.5rem;
            }
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
                        <a href="{{ route('announcements') }}" class="text-decoration-none small fw-bold text-brand">View all announcements <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Upcoming Activities -->
            <div class="col-lg-6">
                <div class="card shadow-sm rounded-4 p-4 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-brand">Upcoming Activities</h5>
                    </div>

                    <div class="row g-3">
                        @forelse ($upcomingActivities as $activity)
                            <div class="col-12">
                                @include('partials.activity-card', ['activity' => $activity, 'context' => 'dashboard'])
                            </div>
                        @empty
                            <div class="col-12 text-center py-4">
                                <i class="fa-regular fa-calendar-xmark fa-2x text-muted mb-2"></i>
                                <p class="text-muted small mb-0">No upcoming activities.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Register button handler
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('[data-action="register"]');
            if (!btn) return;
            const activityId = btn.getAttribute('data-activity-id');
            // TODO: wire to backend register endpoint
            console.log('Register for activity', activityId);
        });
    </script>
</body>
</html>
