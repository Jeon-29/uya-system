<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Details - UYA Connect</title>

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

        /* Sub-cards inside Details */
        .detail-subcard {
            background-color: #ffffff;
            border: 1px solid #dce5e8 !important;
            border-radius: 12px;
            padding: 1rem;
        }

        .metric-mini-box {
            background-color: #f3f7f9;
            border: 1px solid #dce5e8 !important;
            border-radius: 10px;
            padding: 0.85rem 1rem;
        }
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <!-- Main Contents (Edge-to-Edge Container) -->
    <div class="container-fluid py-3">

        <!-- Back Button Header -->
        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('activities') }}" class="btn btn-light border rounded-pill px-3 py-1.5 text-brand fw-semibold shadow-sm text-decoration-none" style="font-size: 0.85rem;">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Activities
                </a>
            </div>
        </div>

        <!-- Top Main Banner Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm rounded-4 p-4 pastel-card-primary">
                    <div class="row align-items-start justify-content-between">

                        <!-- Left Info Section -->
                        <div class="col-lg-8 mb-4 mb-lg-0">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <h3 class="fw-bold mb-0 text-brand">Community Service Day</h3>
                                <span class="badge rounded-pill px-2.5 py-1 text-dark fw-semibold" style="background-color: var(--uya-gold); font-size: 0.7rem;">Upcoming</span>
                            </div>
                            <p class="text-muted small mb-4">Join us for a day of community service cleaning up the local park.</p>

                            <!-- Information Mini-Cards Row -->
                            <div class="row g-3">
                                <div class="col-md-3 col-6">
                                    <div class="detail-subcard h-100">
                                        <span class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Date</span>
                                        <div class="text-dark fw-semibold mt-1" style="font-size: 0.85rem;">
                                            <i class="fa-regular fa-calendar me-1 text-secondary"></i> May 8, 2026
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-6">
                                    <div class="detail-subcard h-100">
                                        <span class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Location</span>
                                        <div class="text-dark fw-semibold mt-1 text-truncate" style="font-size: 0.85rem;">
                                            <i class="fa-solid fa-location-dot me-1 text-secondary"></i> Carmona City Park
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-6">
                                    <div class="detail-subcard h-100">
                                        <span class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Organizer</span>
                                        <div class="text-dark fw-semibold mt-1" style="font-size: 0.85rem;">
                                            <i class="fa-solid fa-user me-1 text-secondary"></i> Nayeon
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-6">
                                    <div class="detail-subcard h-100">
                                        <span class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Duration</span>
                                        <div class="text-dark fw-semibold mt-1" style="font-size: 0.85rem;">
                                            <i class="fa-regular fa-clock me-1 text-secondary"></i> Not set
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Attendance Sub-card -->
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="detail-subcard">
                                        <span class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Attendance</span>
                                        <div class="text-dark fw-semibold mt-1" style="font-size: 0.85rem;">
                                            <i class="fa-solid fa-check-to-slot me-1 text-secondary"></i> 0 present / 3 registered
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Right Status Summary Box -->
                        <div class="col-lg-3">
                            <div class="detail-subcard bg-light bg-opacity-50">
                                <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                    <span class="text-muted small" style="font-size: 0.8rem;">Registration</span>
                                    <span class="badge bg-secondary bg-opacity-15 text-dark px-2 py-1" style="font-size: 0.65rem;">Closed</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                    <span class="text-muted small" style="font-size: 0.8rem;">Attendance</span>
                                    <span class="badge bg-secondary bg-opacity-15 text-dark px-2 py-1" style="font-size: 0.65rem;">Closed</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small" style="font-size: 0.8rem;">Feedback</span>
                                    <span class="fw-bold text-dark" style="font-size: 0.85rem;">0</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small" style="font-size: 0.8rem;">Photos</span>
                                    <span class="fw-bold text-dark" style="font-size: 0.85rem;">0</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Section: Documentation & Attendance Summary Grid -->
        <div class="row g-4">

            <!-- Left Column: Documentation Photos -->
            <div class="col-lg-8">
                <div class="card shadow-sm rounded-4 p-4 h-100 pastel-card-primary">
                    <div class="mb-3">
                        <h6 class="fw-bold mb-1 text-brand"><i class="fa-regular fa-images me-2"></i> Documentation</h6>
                        <p class="text-muted small mb-3">Event photos uploaded by admin or coordinator are visible to members.</p>
                    </div>

                    <div class="metric-mini-box text-center py-5 border-dashed">
                        <p class="text-muted small mb-0">No documentation photos uploaded yet.</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Attendance Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm rounded-4 p-4 h-100 pastel-card-primary">
                    <h6 class="fw-bold mb-3 text-brand">Attendance Summary</h6>

                    <div class="d-flex flex-column gap-3">
                        <div class="metric-mini-box">
                            <span class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.7rem; letter-spacing: 0.5px;">Present</span>
                            <h3 class="fw-bold text-dark mb-0 mt-1">0</h3>
                        </div>

                        <div class="metric-mini-box">
                            <span class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.7rem; letter-spacing: 0.5px;">Registered</span>
                            <h3 class="fw-bold text-dark mb-0 mt-1">3</h3>
                        </div>

                        <div class="metric-mini-box">
                            <span class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.7rem; letter-spacing: 0.5px;">Waiting</span>
                            <h3 class="fw-bold text-dark mb-0 mt-1">3</h3>
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
