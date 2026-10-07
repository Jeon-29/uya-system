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
    <!-- HTML5 QR Code Camera Scanner Library -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

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
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        @media (min-width: 1400px) {
            .app-container {
                padding-left: 2.5rem;
                padding-right: 2.5rem;
            }
        }

        /* Custom Liquid Glass Card Layout */
        .pastel-card-primary,
        .activity-item {
            background: rgba(255, 255, 255, 0.19) !important;
            border-radius: 16px !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1) !important;
            backdrop-filter: blur(4.2px) !important;
            -webkit-backdrop-filter: blur(4.2px) !important;
            border: 1px solid rgba(255, 255, 255, 0.36) !important;
            transition: all 0.2s ease;
        }

        .activity-item:hover {
            border-color: rgba(255, 255, 255, 0.6) !important;
            box-shadow: 0 8px 35px rgba(0, 0, 0, 0.15) !important;
            transform: translateY(-2px);
        }

        /* Desktop Navigation Tabs (>= 768px) */
        @media (min-width: 768px) {
            .mobile-segmented-toggle {
                display: none !important;
            }
            .desktop-nav-pills {
                display: flex !important;
            }
        }

        /* Mobile Segmented Button Toggle (< 768px) */
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
            .app-container {
                padding-left: 1rem;
                padding-right: 1rem;
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

        /* Refined Buttons for Sharp Contrast */
        .custom-btn-outline {
            border: 2px solid var(--uya-dark-teal);
            color: var(--uya-dark-teal);
            background-color: #ffffff;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.2s ease;
        }
        .custom-btn-outline:hover {
            background-color: var(--uya-dark-teal);
            color: #fff;
        }

        .custom-btn-filled {
            background-color: var(--uya-dark-teal);
            color: #fff;
            border: none;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(34, 77, 91, 0.2);
            transition: background-color 0.2s ease;
        }
        .custom-btn-filled:hover {
            background-color: #193a44;
            color: #fff;
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

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* High-contrast readable metadata box container */
        .meta-box {
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 8px 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .meta-label {
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #475569;
            display: block;
            margin-bottom: 2px;
        }
        .meta-val {
            font-size: 0.8rem;
            font-weight: 700;
            color: #0f172a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 0;
        }

        /* Solid Modal Content for Readability */
        .glass-modal-content {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
        }

        #reader {
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            background-color: #000;
        }
    </style>
</head>
<body>

    @include('layouts.navbar')

    <div class="app-container py-3 py-md-4">

        <!-- Header & Search Section -->
        <div class="row mb-3 align-items-center g-3">
            <div class="col-12 col-md-6">
                <h2 class="fw-bold mb-1 text-brand fs-3 fs-md-2">Activities</h2>
                <p class="text-secondary small mb-0">Browse and join community activities.</p>
            </div>
            <div class="col-12 col-md-6">
                <form method="GET" action="{{ route('activities') }}">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white border">
                        <span class="input-group-text bg-white border-0 ps-3 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" value="{{ $search }}" class="form-control border-0 shadow-none py-2" placeholder="Search activities..." style="font-size: 0.9rem;">
                        @if($search)
                            <a href="{{ route('activities', ['tab' => $tab]) }}" class="btn bg-white border-0 text-muted pe-3 d-flex align-items-center">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Navigation Tabs Bar -->
        <div class="mb-4">
            <!-- Mobile Segmented Toggle (< 768px) -->
            <div class="mobile-segmented-toggle">
                <a href="{{ route('activities', ['tab' => 'active', 'search' => $search]) }}" class="segmented-btn {{ $tab === 'active' ? 'active' : '' }}">
                    <i class="fa-solid fa-bolt"></i> Active ({{ $activeCount }})
                </a>
                <a href="{{ route('activities', ['tab' => 'my-activities', 'search' => $search]) }}" class="segmented-btn {{ $tab === 'my-activities' ? 'active' : '' }}">
                    <i class="fa-regular fa-calendar-check"></i> Mine ({{ $myCount }})
                </a>
                <a href="{{ route('activities', ['tab' => 'finished', 'search' => $search]) }}" class="segmented-btn {{ $tab === 'finished' ? 'active' : '' }}">
                    <i class="fa-solid fa-check-circle"></i> Done ({{ $finishedCount }})
                </a>
            </div>

            <!-- Desktop Pill Tabs (>= 768px) -->
            <div class="desktop-nav-pills nav nav-pills gap-2 w-100">
                <a href="{{ route('activities', ['tab' => 'active', 'search' => $search]) }}" class="nav-link {{ $tab === 'active' ? 'active' : '' }}">
                    <i class="fa-solid fa-bolt me-1"></i> Active Activities <span class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">{{ $activeCount }}</span>
                </a>
                <a href="{{ route('activities', ['tab' => 'my-activities', 'search' => $search]) }}" class="nav-link {{ $tab === 'my-activities' ? 'active' : '' }}">
                    <i class="fa-regular fa-calendar-check me-1"></i> My Activities <span class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">{{ $myCount }}</span>
                </a>
                <a href="{{ route('activities', ['tab' => 'finished', 'search' => $search]) }}" class="nav-link {{ $tab === 'finished' ? 'active' : '' }}">
                    <i class="fa-solid fa-check-circle me-1"></i> Finished Activities <span class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">{{ $finishedCount }}</span>
                </a>
            </div>
        </div>

        @if($tab === 'finished')
            <!-- Finished Activities View -->
            <div class="row g-3 g-md-4 mb-4">
                @forelse($activities as $activity)
                    @php
                        $userFeedback = $activity->feedback->where('user_id', auth()->id())->first();
                        $userParticipant = $activity->participants->where('user_id', auth()->id())->first();
                        $hasAttended = $userParticipant && in_array($userParticipant->status, ['attended', 'late']);
                    @endphp
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="card rounded-4 p-3 p-md-4 h-100 activity-item shadow-sm d-flex flex-column justify-content-between">
                            <div>
                                <!-- Top Row with Title & Fixed Top-Right Status Badge -->
                                <div class="d-flex justify-content-between align-items-start mb-2 gap-2">
                                    <h6 class="fw-bold mb-0 text-brand fs-6 text-wrap">{{ $activity->title }}</h6>
                                    <span class="badge rounded-pill px-2.5 py-1 status-badge-green flex-shrink-0" style="font-size: 0.65rem;">
                                        Completed
                                    </span>
                                </div>

                                <p class="text-dark small mb-3 line-clamp-2 fw-medium" style="font-size: 0.83rem;">{{ $activity->description }}</p>

                                <!-- Individual Sub-Containers for Info -->
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div class="meta-box">
                                            <span class="meta-label">Date</span>
                                            <p class="meta-val"><i class="fa-regular fa-calendar me-1 text-brand"></i> {{ $activity->date->format('M j, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="meta-box">
                                            <span class="meta-label">Time</span>
                                            <p class="meta-val"><i class="fa-regular fa-clock me-1 text-brand"></i> {{ $activity->date->format('g:i A') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="meta-box">
                                            <span class="meta-label">Location</span>
                                            <p class="meta-val"><i class="fa-solid fa-location-dot me-1 text-brand"></i> {{ $activity->location ?? 'TBD' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="meta-box">
                                            <span class="meta-label">Organizer</span>
                                            <p class="meta-val"><i class="fa-regular fa-user me-1 text-brand"></i> {{ $activity->organizer_name ?? 'Admin' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-column gap-2 mt-auto">
                                <hr class="text-secondary opacity-25 my-1">
                                <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm rounded-pill w-100 py-2 custom-btn-outline">View Details</a>

                                @if($userFeedback)
                                    <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm btn-light border rounded-pill py-2 fw-bold text-success w-100 d-flex align-items-center justify-content-center gap-1.5 shadow-sm">
                                        <i class="fa-solid fa-check-double"></i> Feedback Added
                                    </a>
                                @elseif($hasAttended)
                                    <button type="button" onclick="openIndexFeedbackModal({{ $activity->id }}, '{{ addslashes($activity->title) }}')" class="btn btn-sm rounded-pill py-2 custom-btn-filled w-100 d-flex align-items-center justify-content-center gap-1.5" style="font-size: 0.82rem;">
                                        <i class="fa-regular fa-comment-dots"></i> Add Feedback
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-secondary bg-opacity-50 text-dark border-0 rounded-pill py-2 fw-bold w-100 d-flex align-items-center justify-content-center gap-1.5 cursor-not-allowed" disabled style="font-size: 0.82rem;">
                                        <i class="fa-solid fa-lock"></i> Feedback Locked
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card p-5 text-center text-dark fw-semibold pastel-card-primary">
                            <i class="fa-solid fa-box-archive fa-2x mb-2 opacity-75 d-block"></i>
                            No finished activities found.
                        </div>
                    </div>
                @endforelse
            </div>
        @else
            <!-- Responsive Grid View for Active / My Activities -->
            <div class="row g-3 g-md-4 mb-4">
                @forelse($activities as $activity)
                    @php
                        $userParticipant = $activity->participants->where('user_id', auth()->id())->first();
                        $isRegistered = $userParticipant && in_array($userParticipant->status, ['registered', 'attended', 'late']);
                        $isAttended = $userParticipant && in_array($userParticipant->status, ['attended', 'late']);
                        $isDeadlinePassed = $activity->registration_deadline && now()->greaterThan($activity->registration_deadline);
                        $canRegister = $activity->is_registration_open && !$isDeadlinePassed && $activity->hasAvailableSlots();
                    @endphp
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="card rounded-4 p-3 p-md-4 h-100 activity-item shadow-sm d-flex flex-column justify-content-between">
                            <div>
                                <!-- Top Row with Title & Fixed Top-Right Status Badge -->
                                <div class="d-flex justify-content-between align-items-start mb-2 gap-2">
                                    <h6 class="fw-bold mb-0 text-brand fs-6 text-wrap">{{ $activity->title }}</h6>
                                    <span class="badge rounded-pill px-2.5 py-1 status-badge-gold flex-shrink-0" style="font-size: 0.65rem;">
                                        {{ ucfirst($activity->status) }}
                                    </span>
                                </div>

                                <p class="text-dark small mb-3 line-clamp-2 fw-medium" style="font-size: 0.83rem;">{{ $activity->description }}</p>

                                <!-- Individual Sub-Containers for Info -->
                                <div class="row g-2 mb-2">
                                    <div class="col-6">
                                        <div class="meta-box">
                                            <span class="meta-label">Date</span>
                                            <p class="meta-val"><i class="fa-regular fa-calendar me-1 text-brand"></i> {{ $activity->date->format('M j, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="meta-box">
                                            <span class="meta-label">Time</span>
                                            <p class="meta-val"><i class="fa-regular fa-clock me-1 text-brand"></i> {{ $activity->date->format('g:i A') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="meta-box">
                                            <span class="meta-label">Location</span>
                                            <p class="meta-val"><i class="fa-solid fa-location-dot me-1 text-brand"></i> {{ $activity->location ?? 'TBD' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="meta-box">
                                            <span class="meta-label">Organizer</span>
                                            <p class="meta-val"><i class="fa-regular fa-user me-1 text-brand"></i> {{ $activity->organizer_name ?? 'Admin' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3" style="font-size: 0.75rem;">
                                    @if($activity->registration_deadline)
                                        <span class="{{ $isDeadlinePassed ? 'text-danger fw-bold' : 'text-dark fw-semibold' }}">
                                            <i class="fa-solid fa-hourglass-start me-1"></i>
                                            {{ $isDeadlinePassed ? 'Deadline Passed' : 'Closes: ' . $activity->registration_deadline->format('M j, g:i A') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex flex-column gap-2 mt-auto">
                                <hr class="text-secondary opacity-25 my-1">
                                <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm rounded-pill w-100 py-2 custom-btn-outline">View Details</a>

                                @if($isAttended)
                                    <button class="btn btn-sm rounded-pill w-100 py-2 fw-bold border-0 text-white {{ $userParticipant->status === 'late' ? 'bg-warning text-dark' : 'bg-success' }}" style="font-size: 0.8rem;" disabled>
                                        <i class="fa-solid {{ $userParticipant->status === 'late' ? 'fa-clock' : 'fa-check' }} me-1"></i>
                                        Attendance Verified
                                    </button>
                                @elseif($isRegistered)
                                    @if($activity->is_attendance_open)
                                        <button onclick="openQRScanner()" class="btn btn-sm rounded-pill w-100 py-2 custom-btn-filled d-flex align-items-center justify-content-center gap-2">
                                            <i class="fa-solid fa-camera"></i> Scan QR Code
                                        </button>
                                    @else
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="btn btn-sm rounded-pill flex-grow-1 py-2 fw-bold border-0 text-white d-flex align-items-center justify-content-center gap-1.5 shadow-sm" style="background-color: #15803d; font-size: 0.8rem; cursor: default;">
                                                <i class="fa-solid fa-user-check"></i> Registered
                                            </div>
                                            <button type="button"
                                                    onclick="promptCancelModal('{{ route('activities.cancel', $activity->id) }}', '{{ addslashes($activity->title) }}')"
                                                    class="btn btn-sm btn-outline-danger rounded-circle d-flex align-items-center justify-content-center p-0 flex-shrink-0 shadow-sm bg-white"
                                                    style="width: 34px; height: 34px;"
                                                    title="Cancel Registration">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    @endif
                                @else
                                    @if($canRegister)
                                        <button type="button" onclick="promptJoinModal('{{ route('activities.join', $activity->id) }}', '{{ addslashes($activity->title) }}')" class="btn btn-sm rounded-pill w-100 py-2 custom-btn-filled">
                                            Join Activity
                                        </button>
                                    @else
                                        <button class="btn btn-sm rounded-pill w-100 py-2 fw-bold bg-secondary bg-opacity-50 text-dark border-0 cursor-not-allowed" disabled style="font-size: 0.8rem;">
                                            {{ $isDeadlinePassed ? 'Deadline Passed' : 'Registration Closed' }}
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-dark fw-semibold py-5">
                        <i class="fa-regular fa-calendar-xmark fa-2x mb-2 opacity-75 d-block"></i>
                        No activities found for this tab.
                    </div>
                @endforelse
            </div>
        @endif

        @if($activities->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $activities->links() }}
            </div>
        @endif

    </div>

    <!-- INDEX PAGE FEEDBACK MODAL -->
    <div class="modal fade" id="indexFeedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3 p-md-4 glass-modal-content">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 border-secondary border-opacity-10">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.1rem;">Add Activity Feedback</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="indexFeedbackForm" method="POST" action="">
                    @csrf
                    <div class="mb-3">
                        <span class="text-secondary d-block mb-1 fw-semibold" style="font-size: 0.75rem;">Activity</span>
                        <h6 id="indexFeedbackActivityTitle" class="fw-bold text-brand mb-0" style="font-size: 0.95rem;"></h6>
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

    <!-- JOIN CONFIRMATION MODAL -->
    <div class="modal fade" id="joinConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content rounded-4 border-0 p-3 text-center glass-modal-content">
                <div class="modal-body p-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 56px; height: 56px; background-color: rgba(34, 77, 91, 0.15);">
                        <i class="fa-solid fa-calendar-plus text-brand fa-lg"></i>
                    </div>
                    <h5 class="fw-bold text-brand mb-2">Confirm Registration</h5>
                    <p class="text-dark small mb-4 fw-medium">Are you sure you want to register for <strong id="joinActivityTitle" class="text-dark"></strong>?</p>

                    <form id="joinForm" method="POST" action="">
                        @csrf
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm fw-bold" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn custom-btn-filled rounded-pill px-4 shadow-sm">Yes, Join</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- CANCEL REGISTRATION CONFIRMATION MODAL -->
    <div class="modal fade" id="cancelConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content rounded-4 border-0 p-3 text-center glass-modal-content">
                <div class="modal-body p-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 56px; height: 56px; background-color: rgba(220, 53, 69, 0.15);">
                        <i class="fa-solid fa-user-xmark text-danger fa-lg"></i>
                    </div>
                    <h5 class="fw-bold text-danger mb-2">Cancel Registration?</h5>
                    <p class="text-dark small mb-4 fw-medium">Are you sure you want to cancel your registration for <strong id="cancelActivityTitle" class="text-dark"></strong>? Your spot will be released.</p>

                    <form id="cancelForm" method="POST" action="">
                        @csrf
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm fw-bold" data-bs-dismiss="modal">Keep Slot</button>
                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm">Yes, Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- LIVE CAMERA QR SCANNER MODAL -->
    <div class="modal fade" id="qrScannerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-lg border-0 p-4 glass-modal-content">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 border-secondary border-opacity-10">
                    <div class="d-flex align-items-center gap-2 text-brand fw-bold">
                        <i class="fa-solid fa-camera fa-lg"></i>
                        <span style="font-size: 1.1rem;">Scan Attendance QR Code</span>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div id="reader" class="mb-3"></div>

                <form id="qrScanForm" onsubmit="submitQrToken(event)">
                    <input type="text" id="qrTokenInput" class="form-control rounded-pill text-center mb-3 d-none bg-light" placeholder="Paste or scan QR token code..." required style="font-size: 0.85rem;">
                    <button type="submit" id="btnSubmitScan" class="btn custom-btn-filled rounded-pill py-2 w-100 mb-2 shadow-sm">
                        Verify Attendance
                    </button>
                </form>

                <button type="button" class="btn btn-outline-dark rounded-pill py-2 w-100 fw-bold shadow-sm bg-light" data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- SMART ATTENDANCE VERIFICATION FEEDBACK MODAL -->
    <div class="modal fade" id="attendanceFeedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
            <div class="modal-content rounded-4 border-0 p-4 text-center glass-modal-content">
                <div id="feedbackIconContainer" class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 64px; height: 64px;">
                    <i id="feedbackIcon" class="fa-solid fa-3x"></i>
                </div>
                <h5 id="feedbackTitle" class="fw-bold mb-2"></h5>
                <p id="feedbackMessage" class="text-dark small mb-4 fw-medium"></p>
                <button type="button" onclick="window.location.reload()" class="btn custom-btn-filled rounded-pill w-100 py-2 shadow-sm">
                    Done
                </button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let html5QrCode = null;

        function openIndexFeedbackModal(activityId, title) {
            document.getElementById('indexFeedbackForm').action = `/activities/${activityId}/feedback`;
            document.getElementById('indexFeedbackActivityTitle').innerText = title;
            const modal = new bootstrap.Modal(document.getElementById('indexFeedbackModal'));
            modal.show();
        }

        function openQRScanner() {
            const modalElement = document.getElementById('qrScannerModal');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();

            if (html5QrCode) {
                html5QrCode.clear();
            }

            html5QrCode = new Html5Qrcode("reader");

            html5QrCode.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: { width: 220, height: 220 } },
                (decodedText) => {
                    document.getElementById('qrTokenInput').value = decodedText;
                    if (html5QrCode.isScanning) {
                        html5QrCode.stop().then(() => {
                            const qrModal = bootstrap.Modal.getInstance(document.getElementById('qrScannerModal'));
                            if (qrModal) qrModal.hide();
                            document.getElementById('qrScanForm').dispatchEvent(new Event('submit'));
                        });
                    }
                },
                (errorMessage) => {}
            ).catch(err => {
                alert("Camera permission denied or camera device not detected.");
            });
        }

        document.getElementById('qrScannerModal').addEventListener('hidden.bs.modal', function () {
            if (html5QrCode && html5QrCode.isScanning) {
                html5QrCode.stop();
            }
        });

        function promptJoinModal(actionUrl, title) {
            document.getElementById('joinForm').action = actionUrl;
            document.getElementById('joinActivityTitle').innerText = title;
            const modal = new bootstrap.Modal(document.getElementById('joinConfirmModal'));
            modal.show();
        }

        function promptCancelModal(actionUrl, title) {
            document.getElementById('cancelForm').action = actionUrl;
            document.getElementById('cancelActivityTitle').innerText = title;
            const modal = new bootstrap.Modal(document.getElementById('cancelConfirmModal'));
            modal.show();
        }

        function submitQrToken(e) {
            e.preventDefault();
            const token = document.getElementById('qrTokenInput').value;

            fetch('{{ route('activities.process-qr') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ token: token })
            })
            .then(res => res.json())
            .then(data => {
                const iconContainer = document.getElementById('feedbackIconContainer');
                const icon = document.getElementById('feedbackIcon');
                const title = document.getElementById('feedbackTitle');
                const msg = document.getElementById('feedbackMessage');

                if (data.success) {
                    if (data.state === 'late') {
                        iconContainer.style.backgroundColor = 'rgba(255, 193, 7, 0.15)';
                        icon.className = 'fa-solid fa-clock text-warning';
                        title.className = 'fw-bold mb-2 text-warning';
                        title.innerText = 'Attendance Marked Late';
                    } else {
                        iconContainer.style.backgroundColor = 'rgba(25, 135, 84, 0.15)';
                        icon.className = 'fa-solid fa-circle-check text-success';
                        title.className = 'fw-bold mb-2 text-success';
                        title.innerText = 'Attendance Verified!';
                    }
                    msg.innerText = data.message;
                } else {
                    iconContainer.style.backgroundColor = 'rgba(220, 53, 69, 0.15)';
                    icon.className = 'fa-solid fa-circle-xmark text-danger';
                    title.className = 'fw-bold mb-2 text-danger';
                    title.innerText = 'Check-In Failed';
                    msg.innerText = data.message || 'Invalid or expired QR code.';
                }

                const feedbackModal = new bootstrap.Modal(document.getElementById('attendanceFeedbackModal'));
                feedbackModal.show();
            })
            .catch(() => {
                alert('An error occurred while verifying your attendance.');
            });
        }
    </script>
</body>
</html>
