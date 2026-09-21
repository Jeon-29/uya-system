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

        .pastel-card-primary {
            background-color: #ffffff;
            border: 1px solid rgba(131, 182, 190, 0.25) !important;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.04);
            border-radius: 16px;
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

        .activity-item {
            background-color: #ffffff;
            border: 1px solid #dce5e8 !important;
            transition: all 0.2s ease;
            border-radius: 16px;
        }
        .activity-item:hover {
            border-color: var(--uya-light-blue) !important;
            box-shadow: 0 6px 16px rgba(34, 77, 91, 0.08);
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

        #reader {
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            background-color: #000;
        }

        @media (max-width: 576px) {
            .nav-pills {
                width: 100%;
                overflow-x: auto;
                flex-wrap: nowrap !important;
                padding-bottom: 4px;
            }
            .app-container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
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
                <p class="text-muted small mb-0">Browse and join community activities.</p>
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

        <!-- Horizontal Pill Tabs -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="nav nav-pills gap-2 w-100">
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
            <!-- Revamped Finished Activities View -->
            <div class="row g-3 g-md-4 mb-4">
                @forelse($activities as $activity)
                    @php
                        $userFeedback = $activity->feedback->where('user_id', auth()->id())->first();
                    @endphp
                    <div class="col-12">
                        <div class="card p-3 p-md-4 activity-item shadow-sm">
                            <div class="row align-items-center g-3">
                                <!-- Details Column -->
                                <div class="col-12 col-lg-7 col-xl-8">
                                    <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                        <h5 class="fw-bold mb-0 text-brand fs-5">{{ $activity->title }}</h5>
                                        <span class="badge rounded-pill bg-success bg-opacity-15 text-success border border-success border-opacity-25 px-3 py-1 fw-semibold" style="font-size: 0.72rem;">
                                            Completed
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-3">{{ $activity->description }}</p>

                                    <div class="d-flex flex-wrap gap-3 text-secondary small" style="font-size: 0.8rem;">
                                        <div><i class="fa-regular fa-calendar me-1.5 text-brand opacity-75"></i> {{ $activity->date->format('M j, Y') }}</div>
                                        <div><i class="fa-regular fa-clock me-1.5 text-brand opacity-75"></i> {{ $activity->date->format('g:i A') }}</div>
                                        <div><i class="fa-solid fa-location-dot me-1.5 text-brand opacity-75"></i> {{ $activity->location ?? 'TBD' }}</div>
                                        <div><i class="fa-regular fa-user me-1.5 text-brand opacity-75"></i> {{ $activity->organizer_name ?? 'Admin' }}</div>
                                    </div>
                                </div>

                                <!-- Action Buttons Bar (50/50 Split) -->
                                <div class="col-12 col-lg-5 col-xl-4 ms-auto">
                                    <div class="d-flex gap-2 w-100">
                                        <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm rounded-pill py-2.5 fw-semibold custom-btn-outline w-50 d-flex align-items-center justify-content-center gap-1.5" style="font-size: 0.82rem;">
                                            <i class="fa-regular fa-eye"></i> View Details
                                        </a>

                                        @if($userFeedback)
                                            <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm btn-light border rounded-pill py-2.5 fw-semibold text-success w-50 d-flex align-items-center justify-content-center gap-1.5" style="font-size: 0.82rem;">
                                                <i class="fa-solid fa-check-double"></i> Feedback Added
                                            </a>
                                        @else
                                            <button type="button" onclick="openIndexFeedbackModal({{ $activity->id }}, '{{ addslashes($activity->title) }}')" class="btn btn-sm rounded-pill py-2.5 fw-semibold custom-btn-filled w-50 d-flex align-items-center justify-content-center gap-1.5" style="font-size: 0.82rem;">
                                                <i class="fa-regular fa-comment-dots"></i> Add Feedback
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card p-5 text-center text-muted pastel-card-primary">
                            <i class="fa-solid fa-box-archive fa-2x mb-2 opacity-50 d-block"></i>
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
                                <div class="d-flex justify-content-between align-items-start mb-2 gap-2">
                                    <h6 class="fw-bold mb-0 text-brand fs-6">{{ $activity->title }}</h6>
                                    <span class="badge rounded-pill px-2.5 py-1 text-dark fw-semibold" style="background-color: var(--uya-gold); font-size: 0.65rem;">
                                        {{ ucfirst($activity->status) }}
                                    </span>
                                </div>

                                <div class="text-muted small d-flex flex-column gap-1 mb-2" style="font-size: 0.8rem;">
                                    <div><i class="fa-regular fa-calendar me-2 text-secondary"></i> {{ $activity->date->format('D, M j, Y') }}</div>
                                    <div><i class="fa-regular fa-clock me-2 text-secondary"></i> {{ $activity->date->format('g:i A') }}</div>
                                    <div><i class="fa-solid fa-location-dot me-2 text-secondary"></i> {{ $activity->location ?? 'TBD' }}</div>
                                    <div><i class="fa-solid fa-user me-2 text-secondary"></i> Organized by {{ $activity->organizer_name ?? 'Admin' }}</div>
                                </div>

                                <div class="mb-3" style="font-size: 0.75rem;">
                                    @if($activity->registration_deadline)
                                        <span class="{{ $isDeadlinePassed ? 'text-danger fw-semibold' : 'text-muted' }}">
                                            <i class="fa-solid fa-hourglass-start me-1"></i>
                                            {{ $isDeadlinePassed ? 'Deadline Passed (' . $activity->registration_deadline->format('M j, g:i A') . ')' : 'Closes: ' . $activity->registration_deadline->format('M j, g:i A') }}
                                        </span>
                                    @endif
                                </div>

                                <p class="text-muted small mb-3 line-clamp-2" style="font-size: 0.83rem;">{{ $activity->description }}</p>
                            </div>

                            <div class="d-flex flex-column gap-2 mt-auto">
                                <hr class="text-muted opacity-25 my-1">
                                <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm rounded-pill w-100 py-2 fw-semibold custom-btn-outline">View Details</a>

                                @if($isAttended)
                                    <button class="btn btn-sm rounded-pill w-100 py-2 fw-semibold border-0 text-white {{ $userParticipant->status === 'late' ? 'bg-warning text-dark' : 'bg-success' }}" style="font-size: 0.8rem;" disabled>
                                        <i class="fa-solid {{ $userParticipant->status === 'late' ? 'fa-clock' : 'fa-check' }} me-1"></i>
                                        Attendance Verified ({{ ucfirst($userParticipant->status) }})
                                    </button>
                                @elseif($isRegistered)
                                    @if($activity->is_attendance_open)
                                        <button onclick="openQRScanner()" class="btn btn-sm rounded-pill w-100 py-2 fw-semibold custom-btn-filled d-flex align-items-center justify-content-center gap-2">
                                            <i class="fa-solid fa-camera"></i> Scan QR
                                        </button>
                                    @else
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="btn btn-sm rounded-pill flex-grow-1 py-2 fw-semibold border-0 text-white d-flex align-items-center justify-content-center gap-1.5" style="background-color: #198754; font-size: 0.8rem; cursor: default;">
                                                <i class="fa-solid fa-user-check"></i> Registered
                                            </div>
                                            <button type="button"
                                                    onclick="promptCancelModal('{{ route('activities.cancel', $activity->id) }}', '{{ addslashes($activity->title) }}')"
                                                    class="btn btn-sm btn-outline-danger rounded-circle d-flex align-items-center justify-content-center p-0 flex-shrink-0"
                                                    style="width: 34px; height: 34px;"
                                                    title="Cancel Registration">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    @endif
                                @else
                                    @if($canRegister)
                                        <button type="button" onclick="promptJoinModal('{{ route('activities.join', $activity->id) }}', '{{ addslashes($activity->title) }}')" class="btn btn-sm rounded-pill w-100 py-2 fw-semibold custom-btn-filled">
                                            Join Activity
                                        </button>
                                    @else
                                        <button class="btn btn-sm rounded-pill w-100 py-2 fw-semibold bg-secondary bg-opacity-25 text-muted border-0 cursor-not-allowed" disabled style="font-size: 0.8rem;">
                                            {{ $isDeadlinePassed ? 'Deadline Passed' : 'Registration Closed' }}
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        <i class="fa-regular fa-calendar-xmark fa-2x mb-2 opacity-50 d-block"></i>
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
            <div class="modal-content rounded-4 shadow-lg border-0 p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.1rem;">Add Activity Feedback</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="indexFeedbackForm" method="POST" action="">
                    @csrf
                    <div class="mb-3">
                        <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">Activity</span>
                        <h6 id="indexFeedbackActivityTitle" class="fw-bold text-brand mb-0" style="font-size: 0.95rem;"></h6>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Your Feedback</label>
                        <textarea name="comments" class="form-control rounded-4 p-3 shadow-none border" rows="3" placeholder="Share your thoughts about this activity..." required style="font-size: 0.88rem; resize: none;"></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light border rounded-pill py-2 w-50 fw-semibold text-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-btn-filled rounded-pill py-2 w-50 fw-semibold shadow-sm">Submit Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JOIN CONFIRMATION MODAL -->
    <div class="modal fade" id="joinConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content rounded-4 border-0 p-3 text-center">
                <div class="modal-body p-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 56px; height: 56px; background-color: rgba(34, 77, 91, 0.15);">
                        <i class="fa-solid fa-calendar-plus text-brand fa-lg"></i>
                    </div>
                    <h5 class="fw-bold text-brand mb-2">Confirm Registration</h5>
                    <p class="text-muted small mb-4">Are you sure you want to register for <strong id="joinActivityTitle" class="text-dark"></strong>?</p>

                    <form id="joinForm" method="POST" action="">
                        @csrf
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn custom-btn-filled rounded-pill px-4 fw-semibold">Yes, Join</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- CANCEL REGISTRATION CONFIRMATION MODAL -->
    <div class="modal fade" id="cancelConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content rounded-4 border-0 p-3 text-center">
                <div class="modal-body p-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 56px; height: 56px; background-color: rgba(220, 53, 69, 0.15);">
                        <i class="fa-solid fa-user-xmark text-danger fa-lg"></i>
                    </div>
                    <h5 class="fw-bold text-danger mb-2">Cancel Registration?</h5>
                    <p class="text-muted small mb-4">Are you sure you want to cancel your registration for <strong id="cancelActivityTitle" class="text-dark"></strong>? Your spot will be released.</p>

                    <form id="cancelForm" method="POST" action="">
                        @csrf
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Keep Slot</button>
                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-semibold">Yes, Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- LIVE CAMERA QR SCANNER MODAL -->
    <div class="modal fade" id="qrScannerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-lg border-0 p-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <div class="d-flex align-items-center gap-2 text-brand fw-bold">
                        <i class="fa-solid fa-camera fa-lg"></i>
                        <span style="font-size: 1.1rem;">Scan Attendance QR Code</span>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div id="reader" class="mb-3"></div>

                <form id="qrScanForm" onsubmit="submitQrToken(event)">
                    <input type="text" id="qrTokenInput" class="form-control rounded-pill text-center mb-3 d-none" placeholder="Paste or scan QR token code..." required style="font-size: 0.85rem;">
                    <button type="submit" id="btnSubmitScan" class="btn custom-btn-filled rounded-pill py-2 w-100 fw-semibold mb-2">
                        Verify Attendance
                    </button>
                </form>

                <button type="button" class="btn btn-outline-dark rounded-pill py-2 w-100 fw-semibold" data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- SMART ATTENDANCE VERIFICATION FEEDBACK MODAL -->
    <div class="modal fade" id="attendanceFeedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
            <div class="modal-content rounded-4 border-0 p-4 text-center">
                <div id="feedbackIconContainer" class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 64px; height: 64px;">
                    <i id="feedbackIcon" class="fa-solid fa-3x"></i>
                </div>
                <h5 id="feedbackTitle" class="fw-bold mb-2"></h5>
                <p id="feedbackMessage" class="text-muted small mb-4"></p>
                <button type="button" onclick="window.location.reload()" class="btn custom-btn-filled rounded-pill w-100 py-2 fw-semibold">
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
