<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $activity->title }} - UYA Connect</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- HTML5 QR Code Scanner Library -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

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

        .app-container {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        @media (min-width: 768px) {
            .app-container {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }

        /* Custom Liquid Glass Card Layout */
        .pastel-card-primary {
            background: rgba(255, 255, 255, 0.19) !important;
            border-radius: 16px !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1) !important;
            backdrop-filter: blur(4.2px) !important;
            -webkit-backdrop-filter: blur(4.2px) !important;
            border: 1px solid rgba(255, 255, 255, 0.36) !important;
        }

        .detail-subcard {
            background-color: #ffffff;
            border: 1px solid #cbd5e1 !important;
            border-radius: 14px;
            padding: 0.75rem 0.9rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .subcard-label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            display: block;
            margin-bottom: 0.25rem;
        }

        .subcard-value {
            font-size: 0.88rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0;
            line-height: 1.25;
        }

        /* High contrast status pills */
        .status-badge-gold {
            background-color: #d97706 !important;
            color: #ffffff !important;
            font-weight: 700;
        }
        .status-badge-green {
            background-color: #15803d !important;
            color: #ffffff !important;
            font-weight: 700;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.35rem 0.8rem;
            font-size: 0.72rem;
            font-weight: 700;
            border-radius: 50rem;
        }

        .custom-btn-filled {
            background-color: var(--uya-dark-teal);
            color: #fff;
            border: none;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(34, 77, 91, 0.25);
        }
        .custom-btn-filled:hover {
            background-color: #193a44;
            color: #fff;
        }

        /* Exact Scan QR Button Styling matching reference design */
        .btn-scan-qr {
            background-color: var(--uya-dark-teal);
            color: #ffffff;
            border: none;
            font-weight: 700;
            padding: 0.65rem 1.25rem;
            border-radius: 50rem;
            box-shadow: 0 4px 14px rgba(34, 77, 91, 0.28);
            transition: all 0.2s ease;
        }
        .btn-scan-qr:hover {
            background-color: #193a44;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(34, 77, 91, 0.35);
        }

        .btn-action-primary {
            background-color: var(--uya-dark-teal);
            color: #ffffff;
            border: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-action-primary:hover {
            background-color: #193a44;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .ig-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }
        .ig-grid-item {
            position: relative;
            width: 100%;
            padding-top: 100%;
            overflow: hidden;
            border-radius: 10px;
            background-color: #0d1117;
            cursor: pointer;
        }
        .ig-grid-item img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.25s ease, filter 0.25s ease;
        }
        .ig-grid-item:hover img {
            transform: scale(1.05);
            filter: brightness(0.85);
        }

        .multi-photo-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(4px);
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 2;
        }

        /* Solid Modal Content for Readability */
        .glass-modal-content {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
        }

        /* QR Reader Viewport Styling */
        #qr-reader {
            border: none !important;
        }
        #qr-reader video {
            border-radius: 16px;
            object-fit: cover !important;
        }
    </style>
</head>
<body>

    @include('layouts.navbar')

    <div class="app-container py-2 py-md-4">

        <!-- Back Button -->
        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('activities') }}" class="btn btn-light border rounded-pill px-3 py-1.5 text-brand fw-bold shadow-sm text-decoration-none" style="font-size: 0.85rem; background-color: #ffffff;">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Activities
                </a>
            </div>
        </div>

        @php
            $isDeadlinePassed = $activity->registration_deadline && now()->greaterThan($activity->registration_deadline);
            $canRegister =$activity->is_registration_open && !$isDeadlinePassed &&$activity->hasAvailableSlots();
            $userParticipant =$activity->participants->where('user_id', auth()->id())->first();
            $hasAttended =$userParticipant && in_array($userParticipant->status, ['attended', 'late']);$userFeedback = $activity->feedback->where('user_id', auth()->id())->first();$groupedPhotos = $activity->photos->groupBy(function ($photo) {
                return $photo->batch_id ?? ('single_' . $photo->id);
            });
        @endphp

        <!-- Main Overview Banner Card -->
        <div class="row mb-3 mb-md-4">
            <div class="col-12">
                <div class="card shadow-sm rounded-4 p-3 p-md-4 pastel-card-primary">
                    <div class="row align-items-start justify-content-between g-3">

                        <!-- Left Info Section -->
                        <div class="col-12 col-lg-8">
                            <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                                <h3 class="fw-bold mb-0 text-brand fs-5 fs-md-3 text-wrap">{{ $activity->title }}</h3>
                                @if($activity->status === 'completed')
                                    <span class="status-pill status-badge-green flex-shrink-0">
                                        <i class="fa-solid fa-check-circle me-1"></i> Completed
                                    </span>
                                @else
                                    <span class="status-pill status-badge-gold flex-shrink-0">
                                        {{ ucfirst($activity->status) }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-dark small mb-3 fw-medium" style="font-size: 0.85rem; line-height: 1.45;">{{ $activity->description }}</p>

                            <!-- Attendance & Certificate Verification Card -->
                            @if($activity->status === 'completed')
                                <div class="detail-subcard mb-3 border-success border-opacity-25 bg-success bg-opacity-10 px-3 py-2.5">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                        <div>
                                            @if($hasAttended)
                                                <div class="text-success fw-bold" style="font-size: 0.83rem;">
                                                    <i class="fa-solid fa-circle-check me-1"></i> Successfully Attended
                                                </div>
                                            @else
                                                <div class="text-secondary fw-bold" style="font-size: 0.83rem;">
                                                    <i class="fa-solid fa-circle-xmark me-1"></i> Not Verified Present
                                                </div>
                                            @endif
                                        </div>

                                        @if($hasAttended)
                                            <a href="{{ route('certificates') }}" class="btn btn-sm custom-btn-filled rounded-pill px-3 py-1 fw-bold d-inline-flex align-items-center gap-1.5 shadow-sm" style="font-size: 0.78rem;">
                                                <i class="fa-solid fa-award"></i> Certificate
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- 2x2 Sub-Cards Metadata Grid -->
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="detail-subcard h-100">
                                        <span class="subcard-label">DATE</span>
                                        <div class="subcard-value d-flex align-items-center gap-2">
                                            <i class="fa-regular fa-calendar text-brand"></i>
                                            <span>{{ $activity->date->format('M j, Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="detail-subcard h-100">
                                        <span class="subcard-label">TIME</span>
                                        <div class="subcard-value d-flex align-items-center gap-2">
                                            <i class="fa-regular fa-clock text-brand"></i>
                                            <span>{{ $activity->date->format('g:i A') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="detail-subcard h-100">
                                        <span class="subcard-label">LOCATION</span>
                                        <div class="subcard-value d-flex align-items-center gap-2 overflow-hidden">
                                            <i class="fa-solid fa-location-dot text-brand flex-shrink-0"></i>
                                            <span class="text-truncate" title="{{ $activity->location }}">{{ $activity->location ?? 'TBD' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="detail-subcard h-100">
                                        <span class="subcard-label">ORGANIZER</span>
                                        <div class="subcard-value d-flex align-items-center gap-2 overflow-hidden">
                                            <i class="fa-regular fa-user text-brand flex-shrink-0"></i>
                                            <span class="text-truncate">{{ $activity->organizer_name ?? 'Admin' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Right Summary Widget -->
                        <div class="col-12 col-lg-4">
                            <div class="detail-subcard d-flex flex-column gap-2 mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-secondary fw-semibold" style="font-size: 0.8rem;">Registration</span>
                                    <span class="badge {{ $canRegister ? 'status-badge-green' : 'bg-secondary text-white' }} px-2 py-0.5" style="font-size: 0.65rem;">
                                        {{ $canRegister ? 'Open' : 'Closed' }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-secondary fw-semibold" style="font-size: 0.8rem;">Attendance</span>
                                    <span class="badge {{ $activity->is_attendance_open ? 'status-badge-green' : 'bg-secondary text-white' }} px-2 py-0.5" style="font-size: 0.65rem;">
                                        {{ $activity->is_attendance_open ? 'Open' : 'Closed' }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-secondary fw-semibold" style="font-size: 0.8rem;">Feedback</span>
                                    <span class="fw-bold text-dark" style="font-size: 0.8rem;">{{ $activity->feedback->count() }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-secondary fw-semibold" style="font-size: 0.8rem;">Photos</span>
                                    <span class="fw-bold text-dark" style="font-size: 0.8rem;">{{ $activity->photos->count() }}</span>
                                </div>
                            </div>

                            <!-- Registration & Check-In Action Button Block -->
                            <div class="mt-2">
                                @if($activity->is_attendance_open && $userParticipant &&$userParticipant->status !== 'cancelled')
                                    @if($hasAttended)
                                        <button class="btn btn-success rounded-pill py-2 w-100 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2" style="font-size: 0.85rem;" disabled>
                                            <i class="fa-solid fa-circle-check"></i> Checked In
                                        </button>
                                    @else
                                        <button onclick="openInPageQRScanner()" class="btn btn-scan-qr w-100 d-flex align-items-center justify-content-center gap-2" style="font-size: 0.92rem;">
                                            <i class="fa-solid fa-camera"></i> Scan QR Code
                                        </button>
                                    @endif
                                @elseif($userParticipant &&$userParticipant->status !== 'cancelled')
                                    <form method="POST" action="{{ route('activities.register', $activity->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger rounded-pill py-2 w-100 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2" style="font-size: 0.85rem;" onclick="return confirm('Are you sure you want to cancel your registration?')">
                                            <i class="fa-solid fa-user-xmark"></i> Cancel Registration
                                        </button>
                                    </form>
                                @elseif($canRegister)
                                    <form method="POST" action="{{ route('activities.register', $activity->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-action-primary rounded-pill py-2 w-100 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2" style="font-size: 0.85rem;">
                                            <i class="fa-solid fa-user-plus"></i> Join Activity
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary rounded-pill py-2 w-100 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 opacity-75" style="font-size: 0.85rem;" disabled>
                                        <i class="fa-solid fa-ban"></i> Registration Closed
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Documentation & Feedback Grid -->
        <div class="row g-3 g-md-4">
            <!-- Documentation Column -->
            <div class="col-12 col-lg-7">
                <div class="card p-3 p-md-4 pastel-card-primary h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2 text-brand fw-bold" style="font-size: 0.95rem;">
                            <i class="fa-regular fa-images"></i> Event Gallery ({{ $groupedPhotos->count() }} Posts)
                        </div>
                    </div>

                    @if($groupedPhotos->count() > 0)
                        <div class="ig-grid">
                            @foreach($groupedPhotos as $batchId =>$photos)
                                @php
                                    $coverPhoto = $photos->first();$photoCount = $photos->count();$batchJson = json_encode($photos->map(function($p) {
                                        return [
                                            'id' => $p->id,
                                            'url' => asset('storage/' . $p->photo_path),
                                            'caption' => $p->caption ?? 'No caption provided.'
                                        ];
                                    })->values());
                                @endphp
                                <div class="ig-grid-item" onclick='openSlideshowModal({{ $batchJson }})'>
                                    <img src="{{ asset('storage/' . $coverPhoto->photo_path) }}" alt="Documentation Photo">
                                    @if($photoCount > 1)
                                        <div class="multi-photo-badge">
                                            <i class="fa-solid fa-layer-group me-1"></i> {{ $photoCount }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-dark fw-semibold py-4 detail-subcard">
                            <i class="fa-regular fa-images fa-2x mb-2 opacity-75 d-block"></i>
                            No documentation photos uploaded yet.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Feedback Column -->
            <div class="col-12 col-lg-5">
                <div class="card p-3 p-md-4 pastel-card-primary h-100">
                    <div class="d-flex align-items-center gap-2 text-brand fw-bold mb-3" style="font-size: 0.95rem;">
                        <i class="fa-regular fa-comment"></i> Your Feedback
                    </div>

                    @if($userFeedback)
                        <div class="detail-subcard">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                @if(auth()->user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                                         alt="{{ auth()->user()->name }}"
                                         class="rounded-circle object-fit-cover shadow-sm flex-shrink-0"
                                         style="width: 28px; height: 28px;">
                                @else
                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold shadow-sm flex-shrink-0"
                                         style="width: 28px; height: 28px; background-color: var(--uya-dark-teal); font-size: 0.75rem;">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif

                                <div class="d-flex flex-wrap align-items-baseline gap-1.5 overflow-hidden">
                                    <span class="fw-bold text-dark text-truncate" style="font-size: 0.82rem;">{{ auth()->user()->name }}</span>
                                    <span class="text-secondary small fw-semibold" style="font-size: 0.7rem;">
                                        • {{ $userFeedback->created_at->format('M j, Y') }}
                                    </span>
                                </div>
                            </div>

                            <div class="px-3 py-2 rounded-3 bg-light border border-light-subtle shadow-sm">
                                <p class="text-dark small mb-0 fw-medium" style="font-size: 0.82rem; line-height: 1.4; white-space: pre-line;">
                                    {{ $userFeedback->comment ?? $userFeedback->comments }}
                                </p>
                            </div>
                        </div>
                    @elseif($hasAttended)
                        <div class="detail-subcard d-flex flex-column gap-2.5">
                            <span class="text-dark small fw-semibold" style="font-size: 0.78rem;">Share your thoughts or experience regarding this activity.</span>
                            <button onclick="openFeedbackModal()" class="btn rounded-pill py-2 custom-btn-filled d-flex align-items-center justify-content-center gap-2 shadow-sm w-100" style="font-size: 0.82rem;">
                                <i class="fa-regular fa-comment-dots"></i> Add Feedback
                            </button>
                        </div>
                    @else
                        <div class="detail-subcard text-center text-dark py-3">
                            <i class="fa-solid fa-lock text-brand opacity-75 fa-lg mb-1.5 d-block"></i>
                            <span class="fw-bold text-dark d-block mb-1" style="font-size: 0.85rem;">Feedback Unavailable</span>
                            <span class="small d-block text-secondary fw-semibold" style="font-size: 0.75rem;">
                                Submit feedback after attending and verifying your QR check-in.
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- IN-PAGE QR CODE SCANNER MODAL -->
    <div class="modal fade" id="qrScannerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3 glass-modal-content">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 border-secondary border-opacity-10">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; background-color: var(--uya-dark-teal); font-size: 0.85rem;">
                            <i class="fa-solid fa-qrcode"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-0" style="font-size: 1.05rem;">Scan Attendance QR Code</h5>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close" onclick="stopQRScanner()"></button>
                </div>

                <div class="modal-body p-0 text-center">
                    <p class="text-secondary small mb-3 fw-medium" style="font-size: 0.82rem;">
                        Align the activity QR code inside the camera frame below to check in.
                    </p>

                    <!-- Camera Viewport Container -->
                    <div id="qr-reader" class="rounded-4 overflow-hidden bg-dark shadow-inner mb-3" style="width: 100%; min-height: 280px;"></div>

                    <!-- Scanner Status / Result Feedback -->
                    <div id="scanStatus" class="alert alert-info py-2 px-3 rounded-pill small mb-0 d-none text-truncate fw-semibold">
                        Scanning for QR Code...
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3 border-top pt-2">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold shadow-sm" data-bs-dismiss="modal" onclick="stopQRScanner()">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- INSTAGRAM-STYLE LIGHTBOX MODAL POPUP -->
    <div class="modal fade" id="slideshowModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-0 border-0 overflow-hidden rounded-4 bg-dark text-white shadow-lg">
                <div class="row g-0">
                    <div class="col-12 col-md-8 bg-black position-relative d-flex align-items-center justify-content-center">
                        <div id="lightboxCarousel" class="carousel slide w-100" data-bs-ride="false">
                            <div class="carousel-inner" id="carouselInner"></div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 p-3 d-flex flex-column justify-content-between border-start border-white border-opacity-10 bg-dark">
                        <div>
                            <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom border-white border-opacity-10">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.75rem; background-color: var(--uya-dark-teal);">
                                        <i class="fa-solid fa-camera"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-white small d-block">UYA Connect</span>
                                        <span class="text-white-50 micro-text d-block" style="font-size: 0.65rem;" id="carouselCounter">Photo 1 of 1</span>
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <p id="slideshowCaption" class="text-white small mb-3" style="line-height: 1.5; font-size: 0.85rem;"></p>
                        </div>

                        <div class="pt-3 border-top border-white border-opacity-10 d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-light btn-sm rounded-pill px-3 shadow-sm fw-bold" data-bs-dismiss="modal" style="font-size: 0.78rem;">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DETAILS PAGE FEEDBACK MODAL -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3 p-md-4 glass-modal-content">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 border-secondary border-opacity-10">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.1rem;">Add Activity Feedback</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('activities.feedback.store', $activity->id) }}">
                    @csrf
                    <div class="mb-3">
                        <span class="text-secondary d-block mb-1 fw-semibold" style="font-size: 0.75rem;">Activity</span>
                        <h6 class="fw-bold text-brand mb-0" style="font-size: 0.95rem;">{{ $activity->title }}</h6>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-dark fw-bold" style="font-size: 0.85rem;">Your Feedback</label>
                        <textarea name="comments" class="form-control rounded-4 p-3 shadow-none border bg-light" rows="3" placeholder="Share your thoughts about this activity..." required style="font-size: 0.88rem; resize: none;"></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary rounded-pill py-2 w-50 fw-bold shadow-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-btn-filled rounded-pill py-2 w-50 shadow-sm">Submit Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentBatchPhotos = [];
        let html5QrCode = null;

        function openInPageQRScanner() {
            const modalElem = document.getElementById('qrScannerModal');
            const qrModal = new bootstrap.Modal(modalElem);
            qrModal.show();

            const statusElem = document.getElementById('scanStatus');
            statusElem.classList.remove('d-none', 'alert-danger', 'alert-success');
            statusElem.classList.add('alert-info');
            statusElem.innerText = "Initializing camera...";

            setTimeout(() => {
                if (!html5QrCode) {
                    html5QrCode = new Html5Qrcode("qr-reader");
                }

                html5QrCode.start(
                    { facingMode: "environment" },
                    {
                        fps: 10,
                        qrbox: { width: 220, height: 220 }
                    },
                    (decodedText) => {
                        handleQRScanSuccess(decodedText);
                    },
                    (errorMessage) => {
                        // Keep scanning
                    }
                ).then(() => {
                    statusElem.innerText = "Align QR code inside the frame to check in.";
                }).catch((err) => {
                    statusElem.classList.remove('alert-info');
                    statusElem.classList.add('alert-danger');
                    statusElem.innerText = "Unable to access camera. Please allow camera permissions.";
                });
            }, 300);
        }

        function stopQRScanner() {
            if (html5QrCode && html5QrCode.isScanning) {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear();
                }).catch(() => {});
            }
        }

        function handleQRScanSuccess(decodedUrl) {
            stopQRScanner();
            const statusElem = document.getElementById('scanStatus');
            statusElem.classList.remove('alert-info', 'alert-danger');
            statusElem.classList.add('alert-success');
            statusElem.innerText = "QR Code detected! Processing check-in...";

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

            // Submit scanned attendance via POST/Fetch or direct navigation
            if (decodedUrl) {
                window.location.href = decodedUrl;
            }
        }

        document.getElementById('qrScannerModal')?.addEventListener('hidden.bs.modal', function () {
            stopQRScanner();
        });

        function openFeedbackModal() {
            const modal = new bootstrap.Modal(document.getElementById('feedbackModal'));
            modal.show();
        }

        function openSlideshowModal(photosList) {
            currentBatchPhotos = photosList;
            const inner = document.getElementById('carouselInner');
            inner.innerHTML = '';

            photosList.forEach((photo, index) => {
                const item = document.createElement('div');
                item.className = `carousel-item ${index === 0 ? 'active' : ''}`;
                item.innerHTML = `
                    <div class="w-100 position-relative" style="aspect-ratio: 1 / 1; max-height: 480px; background: #000;">
                        <img src="${photo.url}" class="w-100 h-100" style="object-fit: cover;">
                    </div>
                `;
                inner.appendChild(item);
            });

            updateCarouselMetadata(0);

            const carouselElem = document.getElementById('lightboxCarousel');
            carouselElem.addEventListener('slid.bs.carousel', function (e) {
                updateCarouselMetadata(e.to);
            });

            const modal = new bootstrap.Modal(document.getElementById('slideshowModal'));
            modal.show();
        }

        function updateCarouselMetadata(index) {
            if (currentBatchPhotos.length > 0 && currentBatchPhotos[index]) {
                const photo = currentBatchPhotos[index];
                document.getElementById('slideshowCaption').innerText = photo.caption || 'No caption provided.';
                document.getElementById('carouselCounter').innerText = `Photo ${index + 1} of ${currentBatchPhotos.length}`;
            }
        }
    </script>
</body>
</html>
