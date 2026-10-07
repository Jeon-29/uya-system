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
            min-height: 100vh;
        }

        .text-brand { color: var(--uya-dark-teal) !important; }

        /* Responsive Container Scaffolding */
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

        /* Primary Outer Liquid Glass Panels */
        .announcement-card {
            background: rgba(255, 255, 255, 0.22) !important;
            border-radius: 18px !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08) !important;
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            border: 1px solid rgba(255, 255, 255, 0.45) !important;
            transition: all 0.25s ease;
        }

        .announcement-card:hover {
            border-color: rgba(255, 255, 255, 0.8) !important;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.12) !important;
            transform: translateY(-2px);
        }

        .announcement-icon-box {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--uya-dark-teal);
            font-size: 1.1rem;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        /* Liquid Glass Subcard for Pinned Items & Metadata */
        .glass-subcard {
            background: rgba(255, 255, 255, 0.45) !important;
            backdrop-filter: blur(6px) !important;
            -webkit-backdrop-filter: blur(6px) !important;
            border: 1px solid rgba(255, 255, 255, 0.75) !important;
            border-radius: 12px;
            padding: 0.5rem 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }

        /* Target Audience Badges */
        .badge-audience-all {
            background-color: rgba(34, 77, 91, 0.15);
            color: var(--uya-dark-teal);
            font-weight: 700;
        }

        .badge-audience-officers {
            background-color: rgba(13, 110, 253, 0.15);
            color: #0284c7;
            font-weight: 700;
        }

        .badge-audience-admin {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc2626;
            font-weight: 700;
        }
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <div class="container-fluid py-3 py-md-4">

        <!-- Header Section -->
        <div class="row mb-3 mb-md-4 px-1 px-md-0 align-items-center">
            <div class="col-12">
                <h2 class="fw-bold mb-0 text-brand fs-3 fs-md-2">Announcements</h2>
            </div>
        </div>

        <!-- Desktop 2-Column Grid Layout -->
        <div class="row g-3 g-md-4">

            <!-- Left Column: Main Announcement Feed -->
            <div class="col-lg-8 order-2 order-lg-1">
                <div class="d-flex flex-column gap-3">
                    @forelse ($announcements as $announcement)
                        <div class="card p-3 p-md-4 announcement-card shadow-sm">
                            <div class="d-flex align-items-start gap-3">

                                <!-- Icon Box (Hidden on Mobile) -->
                                <div class="announcement-icon-box d-none d-md-flex">
                                    <i class="fa-solid fa-bullhorn"></i>
                                </div>

                                <div class="flex-grow-1 overflow-hidden">

                                    <!-- Mobile Responsive Header Layout with Aligned Date -->
                                    <div class="d-flex justify-content-between align-items-start mb-2 gap-2">

                                        <!-- Title & Badges Group -->
                                        <div class="d-flex align-items-center gap-1.5 gap-md-2 flex-wrap">
                                            <!-- Added mb-1.5 margin below the title text -->
                                            <h5 class="fw-bold text-brand mb-1.5 w-100" style="font-size: 1.05rem;">{{ $announcement->title }}</h5>

                                            @if($announcement->is_pinned)
                                                <span class="badge rounded-pill bg-warning text-dark px-2 py-1 fw-bold" style="font-size: 0.65rem;">
                                                    <i class="fa-solid fa-thumbtack me-1"></i> Pinned
                                                </span>
                                            @endif

                                            @php
                                                $audience = $announcement->target_audience ?? 'all';
                                            @endphp
                                            @if($audience === 'officers')
                                                <span class="badge rounded-pill badge-audience-officers px-2 py-1" style="font-size: 0.65rem;">
                                                    <i class="fa-solid fa-user-shield me-1"></i> Officers
                                                </span>
                                            @elseif($audience === 'admin')
                                                <span class="badge rounded-pill badge-audience-admin px-2 py-1" style="font-size: 0.65rem;">
                                                    <i class="fa-solid fa-lock me-1"></i> Admin
                                                </span>
                                            @else
                                                <span class="badge rounded-pill badge-audience-all px-2 py-1" style="font-size: 0.65rem;">
                                                    <i class="fa-solid fa-users me-1"></i> All
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Date Tag -->
                                        <span class="text-secondary fw-semibold flex-shrink-0 ms-auto text-nowrap" style="font-size: 0.72rem;">
                                            <i class="fa-regular fa-calendar me-1"></i> {{ $announcement->created_at->format('M j, Y') }}
                                        </span>
                                    </div>

                                    <!-- Content Paragraph -->
                                    <p class="text-dark small mb-3 fw-medium" style="font-size: 0.86rem; line-height: 1.5; white-space: pre-line;">
                                        {{ $announcement->content }}
                                    </p>

                                    <!-- Author Subcard -->
                                    <div class="d-flex align-items-center">
                                        <div class="glass-subcard py-1 px-2.5 d-inline-flex align-items-center gap-1.5" style="font-size: 0.72rem;">
                                            <i class="fa-regular fa-user text-brand"></i>
                                            <span class="text-dark fw-semibold">Posted by {{ $announcement->author->name ?? 'Admin' }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card p-5 announcement-card text-center text-dark shadow-sm">
                            <i class="fa-solid fa-bullhorn fs-1 text-brand opacity-75 mb-3"></i>
                            <h6 class="fw-bold text-brand mb-1">No Announcements Found</h6>
                            <p class="small mb-0 text-dark fw-medium">There are no updates or notices posted at this time.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination Links -->
                @if(method_exists($announcements, 'links') && $announcements->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $announcements->links() }}
                    </div>
                @endif
            </div>

            <!-- Right Column: Sidebar (Search & Pinned Notices) -->
            <div class="col-lg-4 order-1 order-lg-2 d-flex flex-column gap-3 gap-md-4">

                <!-- Compact Single Search Bar -->
                <form method="GET" action="{{ route('announcements') }}">
                    <div class="input-group shadow-sm rounded-pill border overflow-hidden bg-white px-2 py-0.5">
                        <span class="input-group-text bg-transparent border-0 text-muted pe-1">
                            <i class="fa-solid fa-magnifying-glass small"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-transparent border-0 shadow-none text-dark fw-medium small" placeholder="Search announcements..." style="font-size: 0.85rem;">
                        @if(request('search'))
                            <a href="{{ route('announcements') }}" class="btn text-muted d-flex align-items-center py-0 px-2">
                                <i class="fa-solid fa-xmark small"></i>
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Pinned Notices Quick Summary Card -->
                <div class="card p-3 p-md-4 announcement-card d-none d-lg-block shadow-sm">
                    <h6 class="fw-bold mb-3 text-brand" style="font-size: 0.95rem;">
                        <i class="fa-solid fa-thumbtack me-2 text-warning"></i>Pinned Notices
                    </h6>
                    <div class="d-flex flex-column gap-2">
                        @php
                            $pinnedList = $announcements->where('is_pinned', true);
                        @endphp

                        @forelse($pinnedList as $pinned)
                            <div class="glass-subcard p-2.5">
                                <span class="fw-bold text-dark d-block text-truncate" style="font-size: 0.83rem;">{{ $pinned->title }}</span>
                                <span class="text-secondary fw-semibold" style="font-size: 0.7rem;">{{ $pinned->created_at->format('M j, Y') }}</span>
                            </div>
                        @empty
                            <p class="text-dark small mb-0 fw-medium">No pinned announcements.</p>
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
