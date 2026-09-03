<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activities - UYA Connect</title>

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

        .container-fluid {
            width: 100% !important;
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }

        .pastel-card-primary {
            background-color: #ffffff;
            border: 1px solid rgba(131, 182, 190, 0.25) !important;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.04);
        }

        /* Horizontal Pill Tabs */
        .nav-pills .nav-link {
            color: var(--uya-dark-teal);
            background-color: #e2eaf0;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.5rem 1.25rem;
            border-radius: 50rem;
            border: 1px solid #cbd9df;
            transition: all 0.2s ease;
        }
        .nav-pills .nav-link.active {
            background-color: var(--uya-dark-teal);
            color: #ffffff;
            border-color: var(--uya-dark-teal);
        }
        .nav-pills .nav-link:hover:not(.active) {
            background-color: #d1dde3;
        }

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
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .custom-btn-outline:hover {
            background-color: var(--uya-dark-teal);
            color: #fff;
        }

        .custom-btn-filled {
            background-color: var(--uya-dark-teal);
            color: #fff;
            border: none;
        }
        .custom-btn-filled:hover {
            background-color: #193a44;
            color: #fff;
        }

        .qr-viewfinder {
            position: relative;
            width: 100%;
            height: 280px;
            background: #111;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .qr-laser {
            position: absolute;
            width: 80%;
            height: 2px;
            background: #ff3b30;
            box-shadow: 0 0 8px #ff3b30;
            animation: scan 2s infinite ease-in-out;
        }
        @keyframes scan {
            0% { top: 20%; }
            50% { top: 80%; }
            100% { top: 20%; }
        }
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <div class="container-fluid py-3">

        <!-- Header & Search Section -->
        <div class="row mb-3 align-items-center">
            <div class="col-lg-6 mb-2 mb-lg-0">
                <h2 class="fw-bold mb-1 text-brand">Activities</h2>
                <p class="text-muted small mb-0">Browse and join community activities.</p>
            </div>
            <div class="col-lg-6">
                <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white border">
                    <span class="input-group-text bg-white border-0 ps-3 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" class="form-control border-0 shadow-none py-2" placeholder="Search activities..." style="font-size: 0.9rem;">
                </div>
            </div>
        </div>

        <!-- Horizontal Pill Tabs -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <ul class="nav nav-pills gap-2" id="activityTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active shadow-sm" id="active-tab" data-bs-toggle="pill" data-bs-target="#active-activities" type="button" role="tab">
                        <i class="fa-solid fa-bolt me-1"></i> Active Activities <span class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">1</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link shadow-sm" id="my-tab" data-bs-toggle="pill" data-bs-target="#my-activities" type="button" role="tab">
                        <i class="fa-regular fa-calendar-check me-1"></i> My Activities <span class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">3</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link shadow-sm" id="finished-tab" data-bs-toggle="pill" data-bs-target="#finished-activities" type="button" role="tab">
                        <i class="fa-solid fa-check-circle me-1"></i> Finished Activities <span class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">1</span>
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content Containers -->
        <div class="tab-content" id="activityTabsContent">

            <!-- TAB 1: Active Activities (Unregistered Only) -->
            <div class="tab-pane fade show active" id="active-activities" role="tabpanel">
                <div class="row g-4">

                    <!-- Activity Card: Environmental Campaign (Unregistered / Registration Closed) -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card rounded-4 p-4 h-100 activity-item shadow-sm d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold mb-0 text-brand">Environmental Campaign</h6>
                                    <span class="badge rounded-pill px-2 py-1 text-dark fw-semibold" style="background-color: var(--uya-gold); font-size: 0.65rem;">Upcoming</span>
                                </div>
                                <div class="text-muted small d-flex flex-column gap-1 mb-3">
                                    <div><i class="fa-regular fa-calendar me-2 text-secondary"></i> Fri, Aug 29, 2026</div>
                                    <div><i class="fa-solid fa-location-dot me-2 text-secondary"></i> CvSU Carmona</div>
                                    <div><i class="fa-solid fa-user me-2 text-secondary"></i> Organized by Nayeon</div>
                                </div>
                                <p class="text-muted small mb-3">Raise awareness about environmental issues in our community.</p>
                            </div>

                            <div class="d-flex flex-column gap-2">
                                <hr class="text-muted opacity-25 my-1">
                                <a href="{{ route('activities.show', 4) }}" class="btn btn-sm rounded-pill w-100 py-2 fw-semibold custom-btn-outline">View Details</a>
                                <button class="btn btn-sm rounded-pill w-100 py-2 fw-semibold bg-secondary bg-opacity-25 text-muted border-0 cursor-not-allowed" disabled style="font-size: 0.8rem;">Registration closed</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- TAB 2: My Activities (Successfully Registered) -->
            <div class="tab-pane fade" id="my-activities" role="tabpanel">
                <div class="row g-4">

                    <!-- Registered Item 1: Community Service Day -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card rounded-4 p-4 h-100 activity-item shadow-sm d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold mb-0 text-brand">Community Service Day</h6>
                                    <span class="badge rounded-pill text-dark fw-semibold" style="background-color: var(--uya-gold); font-size: 0.65rem;">Upcoming</span>
                                </div>
                                <div class="text-muted small d-flex flex-column gap-1 mb-3">
                                    <div><i class="fa-regular fa-calendar me-2 text-secondary"></i> Fri, Aug 8, 2026</div>
                                    <div><i class="fa-solid fa-location-dot me-2 text-secondary"></i> Carmona City Park</div>
                                    <div><i class="fa-solid fa-user me-2 text-secondary"></i> Organized by Nayeon</div>
                                </div>
                                <p class="text-muted small mb-3">Join us for a day of community service cleaning up the local park.</p>
                            </div>

                            <div class="d-flex flex-column gap-2">
                                <hr class="text-muted opacity-25 my-1">
                                <a href="{{ route('activities.show', 1) }}" class="btn btn-sm rounded-pill w-100 py-2 fw-semibold custom-btn-outline">View Details</a>
                                <button class="btn btn-sm rounded-pill w-100 py-2 fw-semibold border-0 text-white" style="background-color: #198754; font-size: 0.8rem;">Successfully Registered</button>
                            </div>
                        </div>
                    </div>

                    <!-- Registered Item 2: Tech Workshop -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card rounded-4 p-4 h-100 activity-item shadow-sm d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold mb-0 text-brand">Tech Workshop: Web Development</h6>
                                    <span class="badge rounded-pill px-2 py-1 text-white fw-semibold" style="background-color: #0d6efd; font-size: 0.65rem;">Ongoing</span>
                                </div>
                                <div class="text-muted small d-flex flex-column gap-1 mb-3">
                                    <div><i class="fa-regular fa-calendar me-2 text-secondary"></i> Tue, Aug 12, 2026</div>
                                    <div><i class="fa-solid fa-location-dot me-2 text-secondary"></i> SM Aura</div>
                                    <div><i class="fa-solid fa-user me-2 text-secondary"></i> Organized by Jihyo</div>
                                </div>
                                <p class="text-muted small mb-3">Learn the basics of modern web development with React and TypeScript.</p>
                            </div>

                            <div class="d-flex flex-column gap-2">
                                <hr class="text-muted opacity-25 my-1">
                                <a href="{{ route('activities.show', 2) }}" class="btn btn-sm rounded-pill w-100 py-2 fw-semibold custom-btn-outline">View Details</a>
                                <button onclick="openQRScanner()" class="btn btn-sm rounded-pill w-100 py-2 fw-semibold custom-btn-filled d-flex align-items-center justify-content-center gap-2">
                                    <i class="fa-solid fa-camera"></i> Scan QR
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Registered Item 3: Leadership Training -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card rounded-4 p-4 h-100 activity-item shadow-sm d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold mb-0 text-brand">Leadership Training</h6>
                                    <span class="badge rounded-pill text-dark fw-semibold" style="background-color: var(--uya-gold); font-size: 0.65rem;">Upcoming</span>
                                </div>
                                <div class="text-muted small d-flex flex-column gap-1 mb-3">
                                    <div><i class="fa-regular fa-calendar me-2 text-secondary"></i> Fri, Aug 22, 2026</div>
                                    <div><i class="fa-solid fa-location-dot me-2 text-secondary"></i> Conference Room A</div>
                                    <div><i class="fa-solid fa-user me-2 text-secondary"></i> Organized by Jihyo</div>
                                </div>
                                <p class="text-muted small mb-3">Develop leadership skills through interactive workshops and team activities.</p>
                            </div>

                            <div class="d-flex flex-column gap-2">
                                <hr class="text-muted opacity-25 my-1">
                                <a href="{{ route('activities.show', 3) }}" class="btn btn-sm rounded-pill w-100 py-2 fw-semibold custom-btn-outline">View Details</a>
                                <button class="btn btn-sm rounded-pill w-100 py-2 fw-semibold border-0 text-white" style="background-color: #198754; font-size: 0.8rem;">Successfully Registered</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- TAB 3: Finished Activities -->
            <div class="tab-pane fade" id="finished-activities" role="tabpanel">
                <div class="card shadow-sm rounded-4 p-4 pastel-card-primary">
                    <div class="d-flex flex-column gap-3">
                        <div class="card rounded-3 p-3 activity-item shadow-sm">
                            <div class="row align-items-center">
                                <div class="col-lg-7 mb-3 mb-lg-0">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h6 class="fw-bold mb-0 text-brand">Annual Sports Festival</h6>
                                        <span class="badge rounded-pill bg-success bg-opacity-15 text-success px-2 py-1" style="font-size: 0.65rem;">Completed</span>
                                    </div>
                                    <p class="text-muted small mb-2">Annual sports competition featuring various team sports and activities.</p>
                                    <div class="text-muted small d-flex flex-wrap gap-4">
                                        <div><i class="fa-regular fa-calendar me-1 text-secondary"></i> Aug 15, 2026</div>
                                        <div><i class="fa-solid fa-location-dot me-1 text-secondary"></i> CvSU Main Campus</div>
                                        <div><i class="fa-solid fa-user me-1 text-secondary"></i> Jeongyeon</div>
                                        <div><i class="fa-solid fa-check-double me-1 text-secondary"></i> 4 present</div>
                                    </div>
                                </div>
                                <div class="col-lg-5 d-flex justify-content-lg-end gap-2">
                                    <button class="btn btn-sm rounded-pill px-3 py-2 fw-semibold btn-light border text-muted" disabled><i class="fa-solid fa-check me-1"></i> Feedback Submitted</button>
                                    <a href="{{ route('activities.finished.show', 5) }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold custom-btn-outline">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- QR Scanner Modal Popup -->
    <div class="modal fade" id="qrScannerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-lg border-0 p-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <div class="d-flex align-items-center gap-2 text-brand fw-bold">
                        <i class="fa-solid fa-camera fa-lg"></i>
                        <span style="font-size: 1.1rem;">Scan Attendance QR Code</span>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="qr-viewfinder mb-3 shadow-inner">
                    <div class="qr-laser"></div>
                    <div class="text-white-50 small text-center px-3 z-1">
                        <i class="fa-solid fa-qrcode fa-3x mb-2 text-white opacity-50"></i>
                        <p class="mb-0">Align QR code within the frame to scan</p>
                    </div>
                </div>

                <p class="text-muted small text-center mb-4">
                    Scan the QR code displayed by the coordinator to record your attendance.
                </p>

                <button type="button" class="btn btn-outline-dark rounded-pill py-2 w-100 fw-semibold" data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openQRScanner() {
            const modal = new bootstrap.Modal(document.getElementById('qrScannerModal'));
            modal.show();
        }
    </script>
</body>
</html>
