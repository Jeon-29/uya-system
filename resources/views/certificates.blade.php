<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificates - UYA Connect</title>

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

        .stat-card {
            background-color: #ffffff;
            border: 1px solid #dce5e8 !important;
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.03);
            transition: all 0.2s ease;
        }
        .stat-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            background-color: #f3f7f9;
            border: 1px solid #dce5e8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--uya-dark-teal);
        }

        .certificate-item {
            background-color: #ffffff;
            border: 1px solid #dce5e8 !important;
            border-radius: 16px;
            transition: all 0.2s ease;
        }
        .certificate-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
            border-color: var(--uya-light-blue) !important;
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
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <div class="container-fluid py-3" style="max-width: 1200px;">

        <!-- Header Section -->
        <div class="mb-4">
            <h2 class="fw-bold mb-1 text-brand">My Certificates</h2>
            <p class="text-muted small mb-0">View and download your certificates from UYA activities you have successfully attended.</p>
        </div>

        <!-- Statistics Overview Cards -->
        <div class="row g-3 mb-4">
            <!-- Stat 1 -->
            <div class="col-md-4">
                <div class="stat-card d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted d-block mb-1" style="font-size: 0.8rem; font-weight: 500;">Available Certificates</span>
                        <h2 class="fw-bold mb-0 text-brand">2</h2>
                    </div>
                    <div class="stat-icon">
                        <i class="fa-solid fa-ribbon"></i>
                    </div>
                </div>
            </div>

            <!-- Stat 2 -->
            <div class="col-md-4">
                <div class="stat-card d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted d-block mb-1" style="font-size: 0.8rem; font-weight: 500;">QR Validated Attendance</span>
                        <h2 class="fw-bold mb-0 text-brand">2</h2>
                    </div>
                    <div class="stat-icon">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="col-md-4">
                <div class="stat-card d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted d-block mb-1" style="font-size: 0.8rem; font-weight: 500;">Joined Activities</span>
                        <h2 class="fw-bold mb-0 text-brand">6</h2>
                    </div>
                    <div class="stat-icon">
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Certificates List -->
        <div class="d-flex flex-column gap-3">

            <!-- Certificate Card 1: Annual Sports Festival -->
            <div class="card p-4 certificate-item shadow-sm">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-3 mb-lg-0">
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <h5 class="fw-bold mb-0 text-brand">Annual Sports Festival</h5>
                            <span class="badge rounded-pill text-success px-2.5 py-1 fw-semibold" style="background-color: rgba(25, 135, 84, 0.12); font-size: 0.7rem;">Present</span>
                            <span class="badge rounded-pill text-primary px-2.5 py-1 fw-semibold" style="background-color: rgba(13, 110, 253, 0.12); font-size: 0.7rem;">Available</span>
                        </div>
                        <p class="text-muted small mb-3">Certificate of Attendance from Union of Youth Alliance activities.</p>

                        <div class="text-muted small d-flex flex-wrap gap-4" style="font-size: 0.8rem;">
                            <div><i class="fa-regular fa-calendar me-1 text-secondary"></i> Activity: May 15, 2026</div>
                            <div><i class="fa-regular fa-file-lines me-1 text-secondary"></i> Issued: May 16, 2026</div>
                            <div><i class="fa-solid fa-hashtag me-1 text-secondary"></i> Certificate No: UYA-CERT-2026-001</div>
                        </div>
                    </div>

                    <div class="col-lg-5 d-flex justify-content-lg-end gap-2 align-items-center">
                        <a href="#" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold custom-btn-outline d-flex align-items-center gap-1" style="font-size: 0.85rem;">
                            <i class="fa-regular fa-file-lines"></i> View Certificate
                        </a>
                        <a href="#" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold custom-btn-filled d-flex align-items-center gap-1 shadow-sm" style="font-size: 0.85rem;">
                            <i class="fa-solid fa-download"></i> Download PDF
                        </a>
                    </div>
                </div>
            </div>

            <!-- Certificate Card 2: Cultural Night -->
            <div class="card p-4 certificate-item shadow-sm">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-3 mb-lg-0">
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <h5 class="fw-bold mb-0 text-brand">Cultural Night</h5>
                            <span class="badge rounded-pill text-success px-2.5 py-1 fw-semibold" style="background-color: rgba(25, 135, 84, 0.12); font-size: 0.7rem;">Present</span>
                            <span class="badge rounded-pill text-primary px-2.5 py-1 fw-semibold" style="background-color: rgba(13, 110, 253, 0.12); font-size: 0.7rem;">Available</span>
                        </div>
                        <p class="text-muted small mb-3">Certificate of Attendance from Union of Youth Alliance activities.</p>

                        <div class="text-muted small d-flex flex-wrap gap-4" style="font-size: 0.8rem;">
                            <div><i class="fa-regular fa-calendar me-1 text-secondary"></i> Activity: May 18, 2026</div>
                            <div><i class="fa-regular fa-file-lines me-1 text-secondary"></i> Issued: May 19, 2026</div>
                            <div><i class="fa-solid fa-hashtag me-1 text-secondary"></i> Certificate No: UYA-CERT-2026-005</div>
                        </div>
                    </div>

                    <div class="col-lg-5 d-flex justify-content-lg-end gap-2 align-items-center">
                        <a href="#" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold custom-btn-outline d-flex align-items-center gap-1" style="font-size: 0.85rem;">
                            <i class="fa-regular fa-file-lines"></i> View Certificate
                        </a>
                        <a href="#" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold custom-btn-filled d-flex align-items-center gap-1 shadow-sm" style="font-size: 0.85rem;">
                            <i class="fa-solid fa-download"></i> Download PDF
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
