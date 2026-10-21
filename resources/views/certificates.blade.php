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
            min-height: 100vh;
        }

        .text-brand { color: var(--uya-dark-teal) !important; }

        .app-container {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            padding-left: 1rem;
            padding-right: 1rem;
            padding-bottom: 2rem;
        }

        @media (min-width: 768px) {
            .app-container {
                padding-left: 2rem;
                padding-right: 2rem;
                padding-bottom: 3rem;
            }
        }

        /* Primary Outer Liquid Glass Panels */
        .stat-card,
        .certificate-item {
            background: rgba(255, 255, 255, 0.22) !important;
            border-radius: 18px !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08) !important;
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            border: 1px solid rgba(255, 255, 255, 0.45) !important;
            transition: all 0.25s ease;
        }

        .certificate-item:hover {
            border-color: rgba(255, 255, 255, 0.8) !important;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.12) !important;
            transform: translateY(-2px);
        }

        /* Stat Card Styling */
        .stat-card {
            padding: 1.25rem 1.25rem;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--uya-dark-teal);
            font-size: 1.1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        /* Mobile Compressed 3x1 Layout Styles (< 768px) */
        @media (max-width: 767.98px) {
            .stat-card {
                padding: 0.75rem 0.5rem;
                border-radius: 14px !important;
                text-align: center;
                flex-direction: column !important;
                justify-content: center !important;
                gap: 4px;
            }
            .stat-card .stat-label {
                font-size: 0.65rem !important;
                line-height: 1.15;
                white-space: normal;
            }
            .stat-card h2 {
                font-size: 1.25rem !important;
            }
            .stat-icon {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
                margin: 0 auto 2px auto;
            }
        }

        /* Liquid Glass Nested Subcard for Metadata */
        .glass-subcard {
            background: rgba(255, 255, 255, 0.45) !important;
            backdrop-filter: blur(6px) !important;
            -webkit-backdrop-filter: blur(6px) !important;
            border: 1px solid rgba(255, 255, 255, 0.75) !important;
            border-radius: 12px;
            padding: 0.75rem 0.9rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .subcard-label {
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #475569;
            display: block;
            margin-bottom: 4px;
        }

        .subcard-value {
            font-size: 0.82rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0;
            line-height: 1.25;
        }

        /* Refined Custom Buttons */
        .custom-btn-outline {
            border: 2px solid var(--uya-dark-teal);
            color: var(--uya-dark-teal);
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .custom-btn-outline:hover {
            background-color: var(--uya-dark-teal);
            color: #fff;
            box-shadow: 0 4px 12px rgba(34, 77, 91, 0.2);
        }

        .custom-btn-filled {
            background-color: var(--uya-dark-teal);
            color: #fff;
            border: none;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(34, 77, 91, 0.2);
            transition: background-color 0.2s ease;
        }
        .custom-btn-filled:hover {
            background-color: #193a44;
            color: #fff;
        }

        .compact-search-bar {
            max-width: 320px;
            width: 100%;
        }

        /* RESPONSIVE TAB STYLES */
        @media (min-width: 768px) {
            .mobile-segmented-toggle {
                display: none !important;
            }
            .desktop-nav-pills {
                display: flex !important;
            }
        }

        @media (max-width: 767.98px) {
            .desktop-nav-pills {
                display: none !important;
            }
            .mobile-segmented-toggle {
                display: flex !important;
                background-color: #dce5e8;
                padding: 4px;
                border-radius: 16px;
                gap: 4px;
                width: 100%;
            }
            .mobile-segmented-toggle .segmented-btn {
                flex: 1;
                text-align: center;
                padding: 8px 6px;
                font-size: 0.75rem;
                font-weight: 700;
                color: var(--uya-dark-teal);
                border-radius: 12px;
                text-decoration: none;
                transition: all 0.2s ease;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 4px;
            }
            .mobile-segmented-toggle .segmented-btn.active {
                background-color: var(--uya-dark-teal);
                color: #ffffff;
                box-shadow: 0 2px 6px rgba(34, 77, 91, 0.2);
            }
        }

        .nav-pills .nav-link {
            color: var(--uya-dark-teal);
            background-color: #e2eaf0;
            font-weight: 600;
            font-size: 0.82rem;
            padding: 0.5rem 1.15rem;
            border-radius: 50rem;
            border: 1px solid #cbd9df;
            transition: all 0.2s ease;
            text-decoration: none !important;
            white-space: nowrap;
        }
        .nav-pills .nav-link.active {
            background-color: var(--uya-dark-teal);
            color: #ffffff;
            border-color: var(--uya-dark-teal);
        }

        /* Glass Modal Popup Styles */
        .glass-modal-content {
            background: rgba(255, 255, 255, 0.88) !important;
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 20px 50px rgba(34, 77, 91, 0.2), inset 0 1px 0 rgba(255, 255, 255, 1) !important;
        }
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <div class="app-container py-3 py-md-4">

        <!-- Header Section with Search -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-brand fs-3 fs-md-2">My Certificates</h2>
            </div>

            <!-- Compact Search Bar -->
            <div class="compact-search-bar ms-md-auto">
                <form method="GET" action="{{ route('certificates') }}">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <div class="input-group bg-white border rounded-pill overflow-hidden px-3 py-1 shadow-sm">
                        <span class="input-group-text bg-transparent border-0 text-muted pe-2">
                            <i class="fa-solid fa-magnifying-glass small"></i>
                        </span>
                        <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control bg-transparent border-0 shadow-none text-dark fw-medium small" style="font-size: 0.85rem;" placeholder="Search certificates...">
                        @if(!empty($search))
                            <a href="{{ route('certificates', ['tab' => $tab]) }}" class="btn text-muted d-flex align-items-center py-0 px-2">
                                <i class="fa-solid fa-xmark small"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @php
            $user = auth()->user();
            $validatedAttendanceCount =$user->activities()->wherePivotIn('status', ['attended', 'late'])->count();
            $joinedActivitiesCount =$user->activities()->count();
        @endphp

        <!-- Compressed 3x1 Statistics Overview Cards -->
        <div class="row g-2 g-md-3 mb-4">
            <div class="col-4 col-md-4">
                <div class="stat-card d-flex align-items-center justify-content-between h-100">
                    <div class="stat-icon order-0 order-md-1">
                        <i class="fa-solid fa-ribbon"></i>
                    </div>
                    <div class="order-1 order-md-0">
                        <span class="text-secondary fw-bold d-block mb-1 stat-label" style="font-size: 0.78rem;">Available</span>
                        <h2 class="fw-bold mb-0 text-brand fs-4 fs-md-2">{{ $activeCount }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-4 col-md-4">
                <div class="stat-card d-flex align-items-center justify-content-between h-100">
                    <div class="stat-icon order-0 order-md-1">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                    <div class="order-1 order-md-0">
                        <span class="text-secondary fw-bold d-block mb-1 stat-label" style="font-size: 0.78rem;">Validated</span>
                        <h2 class="fw-bold mb-0 text-brand fs-4 fs-md-2">{{ $validatedAttendanceCount }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-4 col-md-4">
                <div class="stat-card d-flex align-items-center justify-content-between h-100">
                    <div class="stat-icon order-0 order-md-1">
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                    <div class="order-1 order-md-0">
                        <span class="text-secondary fw-bold d-block mb-1 stat-label" style="font-size: 0.78rem;">Joined</span>
                        <h2 class="fw-bold mb-0 text-brand fs-4 fs-md-2">{{ $joinedActivitiesCount }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Navigation Tabs Bar -->
        <div class="mb-4">
            <!-- Mobile Segmented Toggle (< 768px) -->
            <div class="mobile-segmented-toggle">
                <a href="{{ route('certificates', ['tab' => 'active', 'search' => $search]) }}" class="segmented-btn {{ $tab === 'archived' ? '' : 'active' }}">
                    <i class="fa-solid fa-ribbon me-1"></i> Active ({{ $activeCount }})
                </a>
                <a href="{{ route('certificates', ['tab' => 'archived', 'search' => $search]) }}" class="segmented-btn {{ $tab === 'archived' ? 'active' : '' }}">
                    <i class="fa-solid fa-box-archive me-1"></i> Archived ({{ $archivedCount }})
                </a>
            </div>

            <!-- Desktop Pill Tabs (>= 768px) -->
            <div class="desktop-nav-pills nav nav-pills gap-2 w-100">
                <a href="{{ route('certificates', ['tab' => 'active', 'search' => $search]) }}" class="nav-link {{ $tab === 'archived' ? '' : 'active' }}">
                    <i class="fa-solid fa-ribbon me-1"></i> Active <span class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">{{ $activeCount }}</span>
                </a>
                <a href="{{ route('certificates', ['tab' => 'archived', 'search' => $search]) }}" class="nav-link {{ $tab === 'archived' ? 'active' : '' }}">
                    <i class="fa-solid fa-box-archive me-1"></i> Archived <span class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">{{ $archivedCount }}</span>
                </a>
            </div>
        </div>

        <!-- Certificates List -->
        <div class="d-flex flex-column gap-3 gap-md-4 mb-5">
            @forelse ($certificates as $cert)
                @php
                    $act =$cert->activity;
                    $eventDate = $act &&$act->date ? \Carbon\Carbon::parse($act->date)->format('M j, Y') : 'N/A';$issueDate = $cert->issued_at ? $cert->issued_at->format('M j, Y') : 'N/A';
                    $certNo = 'UYA-CERT-' . ($cert->issued_at ? $cert->issued_at->format('Y') : '2026') . '-' . str_pad($cert->id, 3, '0', STR_PAD_LEFT);
                @endphp

                <div class="card p-3 p-md-4 certificate-item shadow-sm border-0">
                    <div class="row align-items-center g-3">

                        <!-- Main Info & Metadata Grid -->
                        <div class="col-12 col-lg-8">
                            <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                <h5 class="fw-bold mb-0 text-brand fs-5">{{ $act->title ?? 'Activity Certificate' }}</h5>
                                <span class="badge rounded-pill text-white px-2.5 py-1 fw-bold" style="background-color: #15803d; font-size: 0.68rem;">Present</span>
                                <span class="badge rounded-pill text-white px-2.5 py-1 fw-bold" style="background-color: #0284c7; font-size: 0.68rem;">Verified</span>
                            </div>

                            <p class="text-dark small mb-3 fw-medium" style="font-size: 0.83rem; line-height: 1.45;">{{ $act->description ?? 'Certificate of Attendance from Union of Youth Alliance activities.' }}</p>

                            <!-- Structured Inner Subcards Layout for Proper Spacing -->
                            <div class="row g-2">
                                <div class="col-6 col-md-4">
                                    <div class="glass-subcard h-100">
                                        <span class="subcard-label">EVENT DATE</span>
                                        <div class="subcard-value d-flex align-items-center">
                                            <i class="fa-regular fa-calendar text-brand flex-shrink-0 me-2"></i>
                                            <span>{{ $eventDate }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-4">
                                    <div class="glass-subcard h-100">
                                        <span class="subcard-label">ISSUED DATE</span>
                                        <div class="subcard-value d-flex align-items-center">
                                            <i class="fa-regular fa-file-lines text-brand flex-shrink-0 me-2"></i>
                                            <span>{{ $issueDate }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="glass-subcard h-100">
                                        <span class="subcard-label">CERTIFICATE NO.</span>
                                        <div class="subcard-value d-flex align-items-center overflow-hidden">
                                            <i class="fa-solid fa-hashtag text-brand flex-shrink-0 me-2"></i>
                                            <span class="text-truncate">{{ $certNo }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-12 col-lg-4 d-flex justify-content-start justify-content-lg-end align-items-center gap-2 flex-wrap mt-3 mt-lg-0 pt-2 pt-lg-0 border-top border-lg-0">
                            @if($tab === 'active')
                                <button type="button" class="btn btn-sm rounded-pill px-3 py-2 fw-bold custom-btn-outline d-inline-flex align-items-center justify-content-center gap-2 flex-grow-1 flex-md-grow-0" style="font-size: 0.82rem;"
                                        onclick="previewCertificate('{{ asset('storage/' . $cert->pdf_path) }}', '{{ addslashes($act->title ?? 'Certificate') }}')">
                                    <i class="fa-regular fa-eye me-1"></i> View
                                </button>
                                <a href="{{ route('certificates.download', $cert->id) }}" class="btn btn-sm rounded-pill px-3.5 py-2 fw-bold custom-btn-filled d-inline-flex align-items-center justify-content-center gap-2 shadow-sm flex-grow-1 flex-md-grow-0" style="font-size: 0.82rem;">
                                    <i class="fa-solid fa-download me-1"></i> Download
                                </a>
                                <!-- Archive Button -->
                                <button type="button" class="btn btn-sm btn-outline-secondary bg-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 p-0 shadow-sm ms-auto ms-md-0" style="width: 38px; height: 38px;" title="Archive Certificate"
                                        onclick="confirmArchive('{{ route('certificates.archive', $cert->id) }}', '{{ addslashes($act->title ?? 'Certificate') }}')">
                                    <i class="fa-solid fa-box-archive"></i>
                                </button>
                            @else
                                <!-- Restore Button -->
                                <form method="POST" action="{{ route('certificates.restore', $cert->id) }}" class="flex-grow-1 flex-md-grow-0">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-success bg-white rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center justify-content-center gap-2 w-100 shadow-sm" style="font-size: 0.82rem;">
                                        <i class="fa-solid fa-rotate-left me-1"></i> Restore
                                    </button>
                                </form>
                                <!-- Permanent Delete Button -->
                                <button type="button" class="btn btn-sm btn-outline-danger bg-white rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center justify-content-center gap-2 flex-grow-1 flex-md-grow-0 shadow-sm" style="font-size: 0.82rem;"
                                        onclick="confirmDelete('{{ route('certificates.destroy', $cert->id) }}', '{{ addslashes($act->title ?? 'Certificate') }}')">
                                    <i class="fa-solid fa-trash-can me-1"></i> Delete
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <div class="card p-5 text-center certificate-item shadow-sm text-dark">
                    <i class="fa-solid fa-certificate fs-1 mb-3 d-block text-brand opacity-75"></i>
                    <h6 class="fw-bold text-brand mb-1">No {{ ucfirst($tab) }} Certificates Found</h6>
                    <p class="small mb-0 text-dark fw-medium">
                        @if($tab === 'active')
                            You haven't earned any certificates yet. Attend UYA activities to earn certificates!
                        @else
                            No certificates have been archived.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        @if($certificates->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $certificates->links() }}
            </div>
        @endif

    </div>

    <!-- PREVIEW MODAL -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content rounded-4 border-0 p-2 glass-modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-brand" id="previewModalTitle"><i class="fa-solid fa-certificate text-warning me-2"></i>Certificate Preview</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <iframe id="pdfPreviewFrame" src="" style="width: 100%; height: 75vh; border: none; border-radius: 12px; background-color: #000;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- ARCHIVE CONFIRMATION MODAL -->
    <div class="modal fade" id="archiveConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content rounded-4 border-0 p-3 text-center glass-modal-content">
                <div class="modal-body p-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 56px; height: 56px; background-color: rgba(34, 77, 91, 0.15);">
                        <i class="fa-solid fa-box-archive text-brand fa-lg"></i>
                    </div>
                    <h5 class="fw-bold text-brand mb-2">Archive Certificate?</h5>
                    <p class="text-dark small mb-4 fw-medium">Are you sure you want to archive the certificate for <strong id="archiveCertTitle" class="text-dark"></strong>? You can restore it anytime from the Archived tab.</p>

                    <form id="archiveForm" method="POST" action="">
                        @csrf
                        @method('PATCH')
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn custom-btn-filled rounded-pill px-4 fw-bold">Archive</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- PERMANENT DELETE CONFIRMATION MODAL -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content rounded-4 border-0 p-3 text-center glass-modal-content">
                <div class="modal-body p-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 56px; height: 56px; background-color: rgba(220, 38, 38, 0.15);">
                        <i class="fa-solid fa-trash-can text-danger fa-lg"></i>
                    </div>
                    <h5 class="fw-bold text-danger mb-2">Permanently Delete Certificate?</h5>
                    <p class="text-dark small mb-4 fw-medium">Are you sure you want to permanently delete <strong id="deleteCertTitle" class="text-dark"></strong>? This action is permanent and cannot be undone.</p>

                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm">Delete Permanently</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewCertificate(pdfUrl, title) {
            document.getElementById('previewModalTitle').innerHTML = `<i class="fa-solid fa-certificate text-warning me-2"></i> ${title}`;
            document.getElementById('pdfPreviewFrame').src = pdfUrl;
            const modal = new bootstrap.Modal(document.getElementById('previewModal'));
            modal.show();
        }

        function confirmArchive(actionUrl, certTitle) {
            document.getElementById('archiveForm').action = actionUrl;
            document.getElementById('archiveCertTitle').innerText = certTitle;
            const modal = new bootstrap.Modal(document.getElementById('archiveConfirmModal'));
            modal.show();
        }

        function confirmDelete(actionUrl, certTitle) {
            document.getElementById('deleteForm').action = actionUrl;
            document.getElementById('deleteCertTitle').innerText = certTitle;
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            modal.show();
        }
    </script>
</body>
</html>
