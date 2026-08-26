<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - UYA Connect</title>

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

        .announcement-card {
            background-color: #ffffff;
            border: 1px solid #dce5e8 !important;
            border-radius: 16px;
            transition: all 0.2s ease;
        }
        .announcement-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
            border-color: var(--uya-light-blue) !important;
        }

        .announcement-icon-box {
            width: 42px;
            height: 42px;
            background-color: #f3f7f9;
            border: 1px solid #dce5e8;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--uya-dark-teal);
            flex-shrink: 0;
        }
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <div class="container-fluid py-3" style="max-width: 1000px;">

        <!-- Header Section -->
        <div class="mb-4">
            <h2 class="fw-bold mb-1 text-brand">Announcements</h2>
            <p class="text-muted small mb-0">Stay updated with the latest news</p>
        </div>

        <!-- Announcements List Container -->
        <div class="d-flex flex-column gap-3">

            <!-- Announcement Item 1 -->
            <div class="card p-4 announcement-card shadow-sm">
                <div class="d-flex align-items-start gap-3">
                    <div class="announcement-icon-box">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h5 class="fw-bold mb-0 text-brand" style="font-size: 1.05rem;">New Activity Schedule Released</h5>
                            <span class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> March 18, 2026</span>
                        </div>
                        <p class="text-muted small mb-3" style="font-size: 0.9rem; line-height: 1.4;">
                            The schedule for next month activities is now available. Check the Activities page for details.
                        </p>
                        <div class="d-flex align-items-center text-muted" style="font-size: 0.75rem;">
                            <span><i class="fa-regular fa-user me-1 text-secondary"></i> Posted by Nayeon</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Announcement Item 2 -->
            <div class="card p-4 announcement-card shadow-sm">
                <div class="d-flex align-items-start gap-3">
                    <div class="announcement-icon-box">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h5 class="fw-bold mb-0 text-brand" style="font-size: 1.05rem;">Attendance Marking System Update</h5>
                            <span class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> March 17, 2026</span>
                        </div>
                        <p class="text-muted small mb-3" style="font-size: 0.9rem; line-height: 1.4;">
                            We have updated the attendance marking system. You can now upload proof of attendance directly.
                        </p>
                        <div class="d-flex align-items-center text-muted" style="font-size: 0.75rem;">
                            <span><i class="fa-regular fa-user me-1 text-secondary"></i> Posted by Jihyo</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Announcement Item 3 -->
            <div class="card p-4 announcement-card shadow-sm">
                <div class="d-flex align-items-start gap-3">
                    <div class="announcement-icon-box">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h5 class="fw-bold mb-0 text-brand" style="font-size: 1.05rem;">Welcome New Members!</h5>
                            <span class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> March 15, 2026</span>
                        </div>
                        <p class="text-muted small mb-3" style="font-size: 0.9rem; line-height: 1.4;">
                            Please join us in welcoming our new members to UYA Connect. Looking forward to great activities together!
                        </p>
                        <div class="d-flex align-items-center text-muted" style="font-size: 0.75rem;">
                            <span><i class="fa-regular fa-user me-1 text-secondary"></i> Posted by Jeongyeon</span>
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
