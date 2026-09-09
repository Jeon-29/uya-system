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

    <div class="container-fluid py-3 py-md-4" style="max-width: 1000px;">

        @if (session('success'))
            <div class="alert alert-success rounded-4 mb-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger rounded-4 mb-3">{{ session('error') }}</div>
        @endif

        <!-- Header & Action Section -->
        <div class="d-flex justify-content-between align-items-center mb-4 px-2 px-md-0 flex-wrap gap-3">
            <div>
                <h2 class="fw-bold mb-1 text-brand">Announcements</h2>
                <p class="text-muted small mb-0">Stay updated with the latest news</p>
            </div>

            <!-- Only visible to Admin/Officer -->
            @php
                $isOfficerOrAdmin = in_array(auth()->user()->role ?? 'member', ['admin', 'officer']);
            @endphp

            @if($isOfficerOrAdmin)
                <button type="button" data-bs-toggle="modal" data-bs-target="#createAnnouncementModal"
                    class="btn rounded-pill px-4 py-2 fw-semibold custom-btn-filled d-flex align-items-center gap-2 shadow-sm"
                    style="font-size: 0.85rem;">
                    <i class="fa-solid fa-plus"></i> Post Announcement
                </button>
            @endif
        </div>

        <!-- Announcements List Container -->
        <div class="d-flex flex-column gap-3">
            @forelse ($announcements as $announcement)
                <div class="card p-3 p-md-4 announcement-card shadow-sm">
                    <div class="d-flex align-items-start gap-3">
                        <div class="announcement-icon-box">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-1 flex-wrap gap-2">
                                <h5 class="fw-bold mb-0 text-brand" style="font-size: 1.05rem;">{{ $announcement->title }}</h5>
                                <span class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> {{ $announcement->created_at->format('F j, Y') }}</span>
                            </div>
                            <p class="text-muted small mb-3" style="font-size: 0.9rem; line-height: 1.4;">
                                {{ $announcement->content }}
                            </p>
                            <div class="d-flex align-items-center text-muted" style="font-size: 0.75rem;">
                                <span><i class="fa-regular fa-user me-1 text-secondary"></i> Posted by {{ $announcement->author->name ?? 'Admin' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card p-5 announcement-card text-center text-muted">
                    <p class="mb-0">No announcements posted yet.</p>
                </div>
            @endforelse
        </div>

    </div>

    <!-- CREATE ANNOUNCEMENT MODAL (Admin/Officer Only) -->
    @if($isOfficerOrAdmin)
    <div class="modal fade" id="createAnnouncementModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 540px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                    <h5 class="fw-bold text-brand mb-0" style="font-size: 1.05rem;">Post New Announcement</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 py-2 px-3 mb-2" style="font-size: 0.8rem;">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('announcements.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Title *</label>
                        <input type="text" class="form-control rounded-pill py-2 px-3 shadow-none border" style="font-size: 0.85rem;"
                            name="title" value="{{ old('title') }}" placeholder="e.g., New Activity Schedule Released" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Content *</label>
                        <textarea class="form-control rounded-4 p-3 shadow-none border" rows="4" style="font-size: 0.85rem; resize: none;"
                            name="content" placeholder="Write the announcement details here..." required>{{ old('content') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <button type="button" class="btn btn-light border rounded-pill px-3 py-1.5 fw-semibold text-secondary" style="font-size: 0.8rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill px-4 py-1.5 fw-semibold text-dark shadow-sm" style="font-size: 0.8rem; background-color: var(--uya-gold);">Publish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = new bootstrap.Modal(document.getElementById('createAnnouncementModal'));
                modal.show();
            });
        </script>
    @endif
</body>
</html>
