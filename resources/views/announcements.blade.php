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

        .announcement-card {
            background-color: #ffffff;
            border: 1px solid rgba(131, 182, 190, 0.25) !important;
            border-radius: 16px;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.04);
            transition: all 0.2s ease;
        }
        .announcement-card:hover {
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

        .action-dropdown-btn {
            color: #6c757d;
            background: transparent;
            border: none;
            padding: 4px 8px;
            border-radius: 50%;
        }
        .action-dropdown-btn:hover {
            background-color: #f1f5f9;
            color: var(--uya-dark-teal);
        }

        /* Audience Badges */
        .badge-audience-all {
            background-color: rgba(34, 77, 91, 0.1);
            color: var(--uya-dark-teal);
            font-weight: 600;
        }
        .badge-audience-officers {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            font-weight: 600;
        }
        .badge-audience-admin {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <div class="container-fluid py-3 py-md-4">

        <!-- Header & Action Section -->
        <div class="row mb-3 mb-md-4 px-2 px-md-0 align-items-center">
            <div class="col-7 col-sm-8">
                <h2 class="fw-bold mb-1 text-brand">Announcements</h2>
            </div>
            <div class="col-5 col-sm-4 text-end">
                @php
                    $isOfficerOrAdmin = in_array(strtolower(auth()->user()->role ?? 'member'), ['admin', 'officer']);
                @endphp

                @if($isOfficerOrAdmin)
                    <button type="button" data-bs-toggle="modal" data-bs-target="#createAnnouncementModal"
                        class="btn rounded-pill px-3 px-md-4 py-2 fw-semibold custom-btn-filled d-inline-flex align-items-center gap-2 shadow-sm"
                        style="font-size: 0.85rem;">
                        <i class="fa-solid fa-plus"></i> <span class="d-none d-sm-inline">Post Announcement</span><span class="d-sm-none">Post</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- Desktop 2-Column Grid Layout -->
        <div class="row g-3 g-md-4">

            <!-- Left Column: Main Announcement Feed -->
            <div class="col-lg-8 order-2 order-lg-1">
                <div class="d-flex flex-column gap-3">
                    @forelse ($announcements as $announcement)
                        <div class="card p-3 p-md-4 announcement-card">
                            <div class="d-flex align-items-start gap-3">
                                <div class="announcement-icon-box">
                                    <i class="fa-solid fa-bullhorn"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-1 flex-wrap gap-2">
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <h5 class="fw-bold mb-0 text-brand" style="font-size: 1.05rem;">{{ $announcement->title }}</h5>

                                            @if($announcement->is_pinned)
                                                <span class="badge rounded-pill bg-warning text-dark px-2 py-1 fw-normal" style="font-size: 0.65rem;">
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

                                        <div class="d-flex align-items-center gap-2">
                                            <span class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> {{ $announcement->created_at->format('F j, Y') }}</span>

                                            @if($isOfficerOrAdmin)
                                                <div class="dropdown">
                                                    <button class="action-dropdown-btn shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3" style="font-size: 0.85rem;">
                                                        <li>
                                                            <button class="dropdown-item py-2 d-flex align-items-center gap-2"
                                                                onclick="editAnnouncement({{ json_encode($announcement) }})">
                                                                <i class="fa-regular fa-pen-to-square text-secondary"></i> Edit
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item py-2 d-flex align-items-center gap-2 text-danger"
                                                                onclick="confirmDelete('{{ route('announcements.destroy', $announcement->id) }}')">
                                                                <i class="fa-regular fa-trash-can"></i> Delete
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
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
                            <p class="mb-0">No announcements found.</p>
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
                    <div class="input-group shadow-sm rounded-pill border overflow-hidden bg-white">
                        <span class="input-group-text bg-white border-0 ps-3 text-muted" style="font-size: 0.85rem;">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 py-2 shadow-none" placeholder="Search announcements..." style="font-size: 0.85rem;">
                        @if(request('search'))
                            <a href="{{ route('announcements') }}" class="btn btn-white border-0 text-muted d-flex align-items-center pe-3">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Pinned Notices Quick Summary Card -->
                <div class="card p-3 p-md-4 announcement-card d-none d-lg-block">
                    <h6 class="fw-bold mb-3 text-brand" style="font-size: 0.95rem;"><i class="fa-solid fa-thumbtack me-2 text-warning"></i>Pinned Notices</h6>
                    <div class="d-flex flex-column gap-2">
                        @php
                            $pinnedList = $announcements->where('is_pinned', true);
                        @endphp

                        @forelse($pinnedList as $pinned)
                            <div class="p-2.5 rounded-3 border bg-light bg-opacity-50">
                                <span class="fw-bold text-dark d-block text-truncate" style="font-size: 0.85rem;">{{ $pinned->title }}</span>
                                <span class="text-muted" style="font-size: 0.7rem;">{{ $pinned->created_at->format('M j, Y') }}</span>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">No pinned announcements.</p>
                        @endforelse
                    </div>
                </div>

            </div>

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

                <form method="POST" action="{{ route('announcements.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Title *</label>
                        <input type="text" class="form-control rounded-pill py-2 px-3 shadow-none border" style="font-size: 0.85rem;"
                            name="title" value="{{ old('title') }}" placeholder="e.g., New Activity Schedule Released" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Target Audience *</label>
                        <select name="target_audience" class="form-select rounded-pill py-2 px-3 shadow-none border" style="font-size: 0.85rem;" required>
                            <option value="all" selected>All (Members, Officers & Admins)</option>
                            <option value="officers">Officers Only</option>
                            <option value="admin">Admin Only</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Content *</label>
                        <textarea class="form-control rounded-4 p-3 shadow-none border" rows="4" style="font-size: 0.85rem; resize: none;"
                            name="content" placeholder="Write the announcement details here..." required>{{ old('content') }}</textarea>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_pinned" value="1" id="create_is_pinned">
                        <label class="form-check-label text-dark small" for="create_is_pinned">
                            Pin this announcement to top
                        </label>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <button type="button" class="btn btn-light border rounded-pill px-3 py-1.5 fw-semibold text-secondary" style="font-size: 0.8rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill px-4 py-1.5 fw-semibold text-dark shadow-sm" style="font-size: 0.8rem; background-color: var(--uya-gold);">Publish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT ANNOUNCEMENT MODAL -->
    <div class="modal fade" id="editAnnouncementModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 540px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                    <h5 class="fw-bold text-brand mb-0" style="font-size: 1.05rem;">Edit Announcement</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="editForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Title *</label>
                        <input type="text" id="edit_title" class="form-control rounded-pill py-2 px-3 shadow-none border" style="font-size: 0.85rem;"
                            name="title" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Target Audience *</label>
                        <select id="edit_target_audience" name="target_audience" class="form-select rounded-pill py-2 px-3 shadow-none border" style="font-size: 0.85rem;" required>
                            <option value="all">All (Members, Officers & Admins)</option>
                            <option value="officers">Officers Only</option>
                            <option value="admin">Admin Only</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Content *</label>
                        <textarea id="edit_content" class="form-control rounded-4 p-3 shadow-none border" rows="4" style="font-size: 0.85rem; resize: none;"
                            name="content" required></textarea>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_pinned" value="1" id="edit_is_pinned">
                        <label class="form-check-label text-dark small" for="edit_is_pinned">
                            Pin this announcement to top
                        </label>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <button type="button" class="btn btn-light border rounded-pill px-3 py-1.5 fw-semibold text-secondary" style="font-size: 0.8rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill px-4 py-1.5 fw-semibold text-dark shadow-sm" style="font-size: 0.8rem; background-color: var(--uya-gold);">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE CONFIRMATION MODAL -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-lg border-0 p-4 text-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                    style="width: 56px; height: 56px; background-color: rgba(220, 53, 69, 0.1);">
                    <i class="fa-solid fa-trash-can text-danger fa-lg"></i>
                </div>
                <h5 class="fw-bold mb-2">Delete Announcement?</h5>
                <p class="text-muted small mb-4">This action cannot be undone.</p>

                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4 fw-semibold">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function editAnnouncement(data) {
            document.getElementById('editForm').action = '/announcements/' + data.id;
            document.getElementById('edit_title').value = data.title;
            document.getElementById('edit_target_audience').value = data.target_audience || 'all';
            document.getElementById('edit_content').value = data.content;
            document.getElementById('edit_is_pinned').checked = Boolean(data.is_pinned);

            const modal = new bootstrap.Modal(document.getElementById('editAnnouncementModal'));
            modal.show();
        }

        function confirmDelete(actionUrl) {
            document.getElementById('deleteForm').action = actionUrl;
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            modal.show();
        }
    </script>
</body>
</html>
