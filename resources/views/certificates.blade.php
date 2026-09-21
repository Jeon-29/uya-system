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

        .container-fluid {
            width: 100% !important;
            padding-left: 2rem !important;
            padding-right: 2rem !important;
        }

        .stat-card {
            background-color: #ffffff;
            border: 1px solid #dce5e8 !important;
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.03);
            transition: all 0.2s ease;
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .custom-btn-outline:hover {
            background-color: var(--uya-dark-teal);
            color: #fff;
        }

        .custom-btn-filled {
            background-color: var(--uya-dark-teal);
            color: #fff;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .custom-btn-filled:hover {
            background-color: #193a44;
            color: #fff;
        }

        .compact-search-bar {
            max-width: 300px;
            width: 100%;
        }

        .nav-pills .nav-link {
            color: var(--uya-dark-teal);
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 50rem;
            padding: 6px 16px;
        }
        .nav-pills .nav-link.active {
            background-color: var(--uya-dark-teal);
            color: #fff;
        }
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <div class="container-fluid py-3">

        <!-- Header Section with Search -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
            <div>
                <h2 class="fw-bold mb-1 text-brand">My Certificates</h2>
                <p class="text-muted small mb-0">View, download, and manage your certificates from UYA activities.</p>
            </div>

            <!-- Compact Search Bar -->
            <div class="compact-search-bar ms-md-auto">
                <form method="GET" action="{{ route('certificates') }}">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <div class="input-group bg-white border rounded-pill overflow-hidden px-2.5 py-0.5 shadow-sm">
                        <span class="input-group-text bg-transparent border-0 text-muted pe-1">
                            <i class="fa-solid fa-magnifying-glass small"></i>
                        </span>
                        <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control bg-transparent border-0 shadow-none text-dark small" style="font-size: 0.85rem;" placeholder="Search certificates...">
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

        <!-- Statistics Overview Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted d-block mb-1" style="font-size: 0.8rem; font-weight: 500;">Available Certificates</span>
                        <h2 class="fw-bold mb-0 text-brand">{{ $activeCount }}</h2>
                    </div>
                    <div class="stat-icon">
                        <i class="fa-solid fa-ribbon"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted d-block mb-1" style="font-size: 0.8rem; font-weight: 500;">QR Validated Attendance</span>
                        <h2 class="fw-bold mb-0 text-brand">{{ $validatedAttendanceCount }}</h2>
                    </div>
                    <div class="stat-icon">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted d-block mb-1" style="font-size: 0.8rem; font-weight: 500;">Joined Activities</span>
                        <h2 class="fw-bold mb-0 text-brand">{{ $joinedActivitiesCount }}</h2>
                    </div>
                    <div class="stat-icon">
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tab Pills -->
        <div class="d-flex align-items-center mb-3">
            <ul class="nav nav-pills bg-white p-1 rounded-pill shadow-sm border">
                <li class="nav-item">
                    <a class="nav-link {{ $tab === 'active' ? 'active' : '' }}" href="{{ route('certificates', ['tab' => 'active', 'search' => $search]) }}">
                        Active <span class="badge rounded-pill bg-light text-dark ms-1">{{ $activeCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab === 'archived' ? 'active' : '' }}" href="{{ route('certificates', ['tab' => 'archived', 'search' => $search]) }}">
                        Archived <span class="badge rounded-pill bg-light text-dark ms-1">{{ $archivedCount }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Certificates List -->
        <div class="d-flex flex-column gap-3">
            @forelse ($certificates as $cert)
                @php
                    $act =$cert->activity;
                    $eventDate = $act &&$act->date ? \Carbon\Carbon::parse($act->date)->format('M j, Y') : 'N/A';$issueDate = $cert->issued_at ? $cert->issued_at->format('M j, Y') : 'N/A';
                    $certNo = 'UYA-CERT-' . ($cert->issued_at ? $cert->issued_at->format('Y') : '2026') . '-' . str_pad($cert->id, 3, '0', STR_PAD_LEFT);
                @endphp

                <div class="card p-3.5 p-md-4 certificate-item shadow-sm">
                    <div class="row align-items-center">
                        <div class="col-lg-7 mb-3 mb-lg-0">
                            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                <h5 class="fw-bold mb-0 text-brand">{{ $act->title ?? 'Activity Certificate' }}</h5>
                                <span class="badge rounded-pill text-success px-2.5 py-1 fw-semibold" style="background-color: rgba(25, 135, 84, 0.12); font-size: 0.7rem;">Present</span>
                                <span class="badge rounded-pill text-primary px-2.5 py-1 fw-semibold" style="background-color: rgba(13, 110, 253, 0.12); font-size: 0.7rem;">Verified</span>
                            </div>
                            <p class="text-muted small mb-2.5">{{ $act->description ?? 'Certificate of Attendance from Union of Youth Alliance activities.' }}</p>

                            <div class="text-muted small d-flex flex-wrap gap-4" style="font-size: 0.8rem;">
                                <div><i class="fa-regular fa-calendar me-1 text-secondary"></i> Activity: {{ $eventDate }}</div>
                                <div><i class="fa-regular fa-file-lines me-1 text-secondary"></i> Issued: {{ $issueDate }}</div>
                                <div><i class="fa-solid fa-hashtag me-1 text-secondary"></i> Certificate No: {{ $certNo }}</div>
                            </div>
                        </div>

                        <div class="col-lg-5 d-flex justify-content-lg-end gap-2 align-items-center flex-wrap">
                            @if($tab === 'active')
                                <button type="button" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold custom-btn-outline gap-1" style="font-size: 0.85rem;"
                                        onclick="previewCertificate('{{ asset('storage/' . $cert->pdf_path) }}', '{{ addslashes($act->title ?? 'Certificate') }}')">
                                    <i class="fa-regular fa-file-lines"></i> View
                                </button>
                                <a href="{{ route('certificates.download', $cert->id) }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold custom-btn-filled gap-1 shadow-sm" style="font-size: 0.85rem;">
                                    <i class="fa-solid fa-download"></i> Download
                                </a>
                                <!-- Archive Button -->
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-2" title="Archive Certificate"
                                        onclick="confirmArchive('{{ route('certificates.archive', $cert->id) }}', '{{ addslashes($act->title ?? 'Certificate') }}')">
                                    <i class="fa-solid fa-box-archive"></i>
                                </button>
                            @else
                                <!-- Restore Button -->
                                <form method="POST" action="{{ route('certificates.restore', $cert->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3 py-2 fw-semibold gap-1" style="font-size: 0.85rem;">
                                        <i class="fa-solid fa-rotate-left"></i> Restore
                                    </button>
                                </form>
                                <!-- Permanent Delete Button -->
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-2 fw-semibold gap-1" style="font-size: 0.85rem;"
                                        onclick="confirmDelete('{{ route('certificates.destroy', $cert->id) }}', '{{ addslashes($act->title ?? 'Certificate') }}')">
                                    <i class="fa-solid fa-trash-can"></i> Delete
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="card p-5 text-center certificate-item shadow-sm text-muted">
                    <i class="fa-solid fa-certificate fs-1 mb-3 d-block text-brand opacity-50"></i>
                    <h6 class="fw-bold text-brand mb-1">No {{ ucfirst($tab) }} Certificates Found</h6>
                    <p class="small mb-0">
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
            <div class="modal-content text-dark p-2" style="border-radius: 16px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-brand" id="previewModalTitle"><i class="fa-solid fa-certificate text-warning me-2"></i>Certificate Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <iframe id="pdfPreviewFrame" src="" style="width: 100%; height: 75vh; border: none; border-radius: 10px;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- ARCHIVE CONFIRMATION MODAL -->
    <div class="modal fade" id="archiveConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-dark p-3 text-center" style="border-radius: 16px;">
                <div class="modal-body p-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 56px; height: 56px; background-color: rgba(34, 77, 91, 0.1);">
                        <i class="fa-solid fa-box-archive text-brand fa-lg"></i>
                    </div>
                    <h5 class="fw-bold text-brand mb-2">Archive Certificate?</h5>
                    <p class="text-muted small mb-4">Are you sure you want to archive the certificate for <strong id="archiveCertTitle" class="text-dark"></strong>? You can restore it anytime from the Archived tab.</p>

                    <form id="archiveForm" method="POST" action="">
                        @csrf
                        @method('PATCH')
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn custom-btn-filled rounded-pill px-4 fw-semibold">Archive</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- PERMANENT DELETE CONFIRMATION MODAL -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-dark p-3 text-center" style="border-radius: 16px;">
                <div class="modal-body p-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 56px; height: 56px; background-color: rgba(220, 38, 38, 0.12);">
                        <i class="fa-solid fa-trash-can text-danger fa-lg"></i>
                    </div>
                    <h5 class="fw-bold text-danger mb-2">Permanently Delete Certificate?</h5>
                    <p class="text-muted small mb-4">Are you sure you want to permanently delete <strong id="deleteCertTitle" class="text-dark"></strong>? This action is permanent and cannot be undone.</p>

                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-semibold">Delete Permanently</button>
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
