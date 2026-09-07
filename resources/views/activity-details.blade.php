<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Details - UYA Connect</title>

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

        /* Full space container extension */
        .container-fluid {
            width: 100% !important;
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }

        /* Main Wrapper Cards */
        .pastel-card-primary {
            background-color: #ffffff;
            border: 1px solid rgba(131, 182, 190, 0.25) !important;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.04);
        }

        /* Sub-cards inside Details */
        .detail-subcard {
            background-color: #ffffff;
            border: 1px solid #dce5e8 !important;
            border-radius: 12px;
            padding: 1rem;
        }

        /* Info stat cards — uniform size */
        .info-stat-card {
            background-color: #f8fbfc;
            border: 1px solid rgba(131, 182, 190, 0.25) !important;
            border-radius: 12px;
            padding: 0.75rem 0.85rem;
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
            height: 100%;
        }
        .info-stat-card__label {
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #9aa8ad;
        }
        .info-stat-card__value {
            font-size: 0.82rem;
            font-weight: 600;
            color: #224d5b;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            flex-wrap: wrap;
        }
        .info-stat-card__value i {
            color: #83b6be;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .metric-mini-box {
            background-color: #f3f7f9;
            border: 1px solid #dce5e8 !important;
            border-radius: 10px;
            padding: 0.85rem 1rem;
        }

        /* =============================================
           COMPACT MOBILE LAYOUT
           ============================================= */
        @media (max-width: 575.98px) {
            /* Top banner title & description */
            h3.fw-bold.mb-0.text-brand {
                font-size: 1.1rem;
            }
            .text-muted.small.mb-4 {
                font-size: 0.78rem;
                margin-bottom: 0.6rem !important;
            }
            .badge.rounded-pill.px-2\.5 {
                font-size: 0.62rem;
                padding: 0.2rem 0.5rem;
            }

            /* Info stat cards */
            .info-stat-card {
                padding: 0.55rem 0.65rem;
                border-radius: 10px;
                gap: 0.1rem;
            }
            .info-stat-card__label {
                font-size: 0.55rem;
            }
            .info-stat-card__value {
                font-size: 0.75rem;
                gap: 0.25rem;
            }
            .info-stat-card__value i {
                font-size: 0.72rem;
            }

            /* Top banner subcards */
            .detail-subcard {
                padding: 0.6rem 0.7rem;
                border-radius: 10px;
            }

            /* Register button panel */
            .detail-subcard.text-center {
                padding: 1rem 0.85rem;
            }
            .detail-subcard.text-center p {
                font-size: 0.75rem;
            }
            .detail-subcard.text-center .btn {
                font-size: 0.82rem;
            }

            /* Status summary box */
            .detail-subcard .text-muted.small {
                font-size: 0.7rem;
            }
            .detail-subcard .badge,
            .detail-subcard .fw-bold {
                font-size: 0.72rem;
            }

            /* Info mini-cards row */
            .detail-subcard.h-100 {
                height: auto !important;
            }

            /* Bottom section: Documentation & Feedback cards */
            .row.g-4 .card.pastel-card-primary {
                padding: 0.85rem;
            }
            .row.g-4 .card.pastel-card-primary > .mb-3 {
                margin-bottom: 0.6rem !important;
            }
            .row.g-4 .card.pastel-card-primary > .mb-3 h6 {
                font-size: 0.88rem;
            }
            .row.g-4 .card.pastel-card-primary > .mb-3 p {
                font-size: 0.72rem;
                margin-bottom: 0;
            }

            /* Feedback cards */
            .d-flex.flex-column.gap-2 .detail-subcard {
                padding: 0.6rem 0.75rem;
            }
            .d-flex.flex-column.gap-2 .detail-subcard .fw-semibold {
                font-size: 0.78rem;
            }
            .d-flex.flex-column.gap-2 .detail-subcard .text-muted.mb-1 {
                font-size: 0.72rem;
                line-height: 1.35;
            }
            .d-flex.flex-column.gap-2 .detail-subcard .badge {
                font-size: 0.58rem;
            }

            /* Give Feedback button */
            .btn.w-100.rounded-pill {
                font-size: 0.8rem;
                padding: 0.45rem 1rem;
            }

            /* Metric mini-box */
            .metric-mini-box {
                padding: 0.6rem 0.75rem;
            }

            /* Documentation placeholder */
            .metric-mini-box.border-dashed {
                padding: 1.5rem 1rem;
            }
        }
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <!-- Main Contents (Edge-to-Edge Container) -->
    <div class="container-fluid py-3">

        <!-- Back Button Header -->
        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('activities') }}" class="btn btn-light border rounded-pill px-3 py-1.5 text-brand fw-semibold shadow-sm text-decoration-none" style="font-size: 0.85rem;">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Activities
                </a>
            </div>
        </div>

        <!-- Top Main Banner Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm rounded-4 p-4 pastel-card-primary">
                    <div class="row align-items-start justify-content-between">

                        <!-- Left Info Section -->
                        <div class="col-lg-8 mb-4 mb-lg-0">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <h3 class="fw-bold mb-0 text-brand">{{ $activity->title }}</h3>
                                <span class="badge rounded-pill px-2.5 py-1 text-dark fw-semibold" style="background-color: var(--uya-gold); font-size: 0.7rem;">{{ ucfirst($activity->status) }}</span>
                            </div>
                            <p class="text-muted small mb-4">{{ $activity->description }}</p>

                            <!-- Information Mini-Cards Row -->
                            <div class="row g-3">
                                <div class="col-md-3 col-6">
                                    <div class="info-stat-card">
                                        <span class="info-stat-card__label">Date</span>
                                        <div class="info-stat-card__value">
                                            <i class="fa-regular fa-calendar"></i> <span>{{ $activity->date->format('M j, Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-6">
                                    <div class="info-stat-card">
                                        <span class="info-stat-card__label">Location</span>
                                        <div class="info-stat-card__value text-truncate">
                                            <i class="fa-solid fa-location-dot"></i> <span>{{ $activity->location }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-6">
                                    <div class="info-stat-card">
                                        <span class="info-stat-card__label">Organizer</span>
                                        <div class="info-stat-card__value">
                                            <i class="fa-solid fa-user"></i> <span>{{ $activity->organizer->name ?? 'TBA' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-6">
                                    <div class="info-stat-card">
                                        <span class="info-stat-card__label">Duration</span>
                                        <div class="info-stat-card__value">
                                            <i class="fa-regular fa-clock"></i> <span>{{ $activity->duration ?? 'Not set' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- (attendance tally removed) -->

                        </div>

                        <!-- Right: Register button (non-finished) / Status summary (finished) -->
                        <div class="col-lg-3">
                            @if ($activity->status === 'open')
                                <div class="detail-subcard text-center" style="padding: 1.25rem 1rem;">
                                    <p class="text-muted mb-3" style="font-size: 0.85rem;">Ready to join this activity?</p>
                                    <button class="btn w-100 rounded-pill py-2 fw-semibold shadow-sm" id="registerNowBtn" style="background-color: var(--uya-dark-teal); color: #fff; font-size: 0.9rem;" onclick="openRegisterModal()">
                                        <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Register Now
                                    </button>
                                </div>
                            @elseif ($activity->status === 'closed')
                                <div class="detail-subcard text-center" style="padding: 1.25rem 1rem;">
                                    <p class="text-muted mb-3" style="font-size: 0.85rem;">This activity is no longer accepting registrations.</p>
                                    <button class="btn w-100 rounded-pill py-2 fw-semibold" disabled style="background-color: #e9ecef; color: #6c757d; border: none; font-size: 0.9rem; cursor: not-allowed;">
                                        <i class="fa-solid fa-lock me-1"></i> Registration Closed
                                    </button>
                                </div>
                            @elseif (in_array($activity->status, ['registered', 'ongoing']))
                                <div class="detail-subcard text-center" style="padding: 1.25rem 1rem;">
                                    <p class="text-muted mb-3" style="font-size: 0.85rem;">You are registered for this activity.</p>
                                    <button class="btn w-100 rounded-pill py-2 fw-semibold" disabled style="background-color: rgba(25,135,84,0.12); color: #198754; border: none; font-size: 0.9rem; cursor: not-allowed;">
                                        <i class="fa-solid fa-check me-1"></i> Registered
                                    </button>
                                </div>
                            @else
                                <div class="detail-subcard bg-light bg-opacity-50">
                                    <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                        <span class="text-muted small" style="font-size: 0.8rem;">Registration</span>
                                        <span class="badge bg-secondary bg-opacity-15 text-dark px-2 py-1" style="font-size: 0.65rem;">{{ ucfirst($activity->status) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                        <span class="text-muted small" style="font-size: 0.8rem;">Feedback</span>
                                        <span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $activity->feedback_count ?? 0 }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted small" style="font-size: 0.8rem;">Photos</span>
                                        <span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $activity->photo_count ?? 0 }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Section: Documentation & Feedback (finished activities only) -->
        @if ($activity->status === 'finished')
        <div class="row g-4">

            <!-- Left Column: Documentation Photos -->
            <div class="col-lg-8">
                <div class="card shadow-sm rounded-4 p-4 h-100 pastel-card-primary">
                    <div class="mb-3">
                        <h6 class="fw-bold mb-1 text-brand"><i class="fa-regular fa-images me-2"></i> Documentation</h6>
                        <p class="text-muted small mb-3">Event photos uploaded by admin or coordinator are visible to members.</p>
                    </div>

                    <div class="metric-mini-box text-center py-5 border-dashed">
                        <p class="text-muted small mb-0">No documentation photos uploaded yet.</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Feedback -->
            <div class="col-lg-4">
                <div class="card shadow-sm rounded-4 p-4 h-100 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0 text-brand"><i class="fa-regular fa-comment-dots me-1"></i> Feedback</h6>
                        <span class="badge rounded-pill px-2 py-1" style="background-color: rgba(34,77,91,0.1); color: var(--uya-dark-teal); font-size: 0.7rem; font-weight: 600;">{{ $feedbacks->count() }}</span>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        @forelse ($feedbacks->take(3) as $feedback)
                            <div class="detail-subcard">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <span class="fw-semibold text-dark" style="font-size: 0.82rem;">{{ $feedback->author->name }}</span>
                                    <span class="badge rounded-pill" style="background-color: rgba(34,77,91,0.08); color: var(--uya-dark-teal); font-size: 0.6rem; font-weight: 600;">{{ $feedback->type }}</span>
                                </div>
                                <p class="text-muted mb-1" style="font-size: 0.75rem; line-height: 1.4;">{{ $feedback->comment }}</p>
                                <span class="text-muted" style="font-size: 0.65rem;">{{ $feedback->created_at->format('M j, Y') }}</span>
                            </div>
                        @empty
                            <p class="text-muted small text-center py-3">No feedback yet.</p>
                        @endforelse
                    </div>

                    <div class="mt-3">
                        <button class="btn w-100 rounded-pill py-2 fw-semibold shadow-sm" style="background-color: var(--uya-dark-teal); color: #fff; font-size: 0.85rem;" onclick="openFeedbackModal()">
                            <i class="fa-regular fa-comment-dots me-1"></i> Give Feedback
                        </button>
                    </div>
                </div>
            </div>

        </div>
        @endif

    </div>

    @if ($activity->status !== 'finished')
    <!-- Register Confirmation Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-lg border-0 p-4">
                <div class="text-center mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 56px; height: 56px; background-color: rgba(34,77,91,0.1); color: var(--uya-dark-teal); font-size: 1.5rem;">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    </div>
                    <h5 class="fw-bold text-brand mb-1" style="font-size: 1.1rem;">Confirm Registration</h5>
                    <p class="text-muted mb-0" style="font-size: 0.85rem;">Are you sure you want to register for this activity?</p>
                </div>

                <div class="detail-subcard mb-3" style="background-color: #f8fbfc;">
                    <span class="info-stat-card__label d-block mb-1">Activity</span>
                    <div class="fw-semibold text-dark" style="font-size: 0.9rem;">{{ $activity->title }}</div>
                    <div class="text-muted mt-1" style="font-size: 0.75rem;">
                        <i class="fa-regular fa-calendar me-1"></i> {{ $activity->date->format('D, M j, Y') }}
                        <span class="mx-1">·</span>
                        <i class="fa-solid fa-location-dot me-1"></i> {{ $activity->location }}
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light border rounded-pill py-2 w-50 fw-semibold text-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn rounded-pill py-2 w-50 fw-semibold text-white shadow-sm" style="background-color: var(--uya-dark-teal);" onclick="confirmRegistration()">
                        <i class="fa-solid fa-check me-1"></i> Yes
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($activity->status === 'finished')
    <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-lg border-0 p-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <div class="d-flex align-items-center gap-2 text-brand fw-bold" style="font-size: 1.1rem;">
                        <i class="fa-regular fa-comment-dots"></i>
                        <span>Give Feedback</span>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="mb-3">
                    <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">Activity</span>
                    <h6 class="fw-bold text-brand mb-0" style="font-size: 1rem;">{{ $activity->title }}</h6>
                </div>

                <div class="mb-3">
                    <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Feedback Type</label>
                    <select class="form-select rounded-4 py-2 shadow-none border" style="font-size: 0.9rem;" id="feedbackType">
                        <option selected disabled>Select feedback type</option>
                        <option value="general">General Experience</option>
                        <option value="suggestion">Suggestion for Improvement</option>
                        <option value="praise">Praise / Appreciation</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Your Feedback</label>
                    <textarea class="form-control rounded-4 p-3 shadow-none border" id="feedbackComment" rows="4" placeholder="Share your thoughts about this activity..." style="font-size: 0.9rem; resize: none;"></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light border rounded-pill py-2 w-50 fw-semibold text-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn rounded-pill py-2 w-50 fw-semibold text-white shadow-sm" style="background-color: var(--uya-dark-teal);" onclick="submitFeedback()">Submit Feedback</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @if ($activity->status !== 'finished')
    <script>
        function openRegisterModal() {
            const modal = new bootstrap.Modal(document.getElementById('registerModal'));
            modal.show();
        }

        function confirmRegistration() {
            // TODO: wire to backend register endpoint
            console.log('Confirm registration for activity {{ $activity->id }}');

            // Swap the Register Now button to Registered
            const registerBtn = document.getElementById('registerNowBtn');
            if (registerBtn) {
                registerBtn.className = 'btn w-100 rounded-pill py-2 fw-semibold shadow-sm';
                registerBtn.style.backgroundColor = '#e9ecef';
                registerBtn.style.color = '#6c757d';
                registerBtn.style.border = 'none';
                registerBtn.disabled = true;
                registerBtn.removeAttribute('onclick');
                registerBtn.innerHTML = '<i class="fa-solid fa-check me-1"></i> Registered';
            }

            const modalEl = document.getElementById('registerModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
        }
    </script>
    @endif
    @if ($activity->status === 'finished')
    <script>
        function openFeedbackModal() {
            const modal = new bootstrap.Modal(document.getElementById('feedbackModal'));
            modal.show();
        }

        function submitFeedback() {
            const type = document.getElementById('feedbackType').value;
            const comment = document.getElementById('feedbackComment').value.trim();
            if (!type || !comment) {
                alert('Please select a feedback type and enter your feedback.');
                return;
            }
            // TODO: wire to backend endpoint
            console.log('Submit feedback:', { type, comment });
            const modalEl = document.getElementById('feedbackModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
            document.getElementById('feedbackType').value = '';
            document.getElementById('feedbackComment').value = '';
        }
    </script>
    @endif
</body>
</html>
