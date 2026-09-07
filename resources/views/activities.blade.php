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

        .pastel-card-primary {
            background-color: #ffffff;
            border: 1px solid rgba(131, 182, 190, 0.25) !important;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.04);
        }

        /* =============================================
           HORIZONTAL PILL TABS
           ============================================= */
        .nav-pills .nav-link {
            color: var(--uya-dark-teal);
            background-color: #e2eaf0;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.5rem 1.25rem;
            border-radius: 50rem;
            border: 1px solid #cbd9df;
            transition: all 0.2s ease;
        }
        .nav-pills .nav-link.active {
            background-color: var(--uya-dark-teal);
            color: #ffffff;
            border-color: var(--uya-dark-teal);
        }
        .nav-pills .nav-link:hover:not(.active) {
            background-color: #d1dde3;
        }

        /* =============================================
           FIT-ALL-THREE TABS (mobile)
           ============================================= */
        @media (max-width: 575.98px) {
            .tabs-scroll {
                flex-wrap: nowrap;
            }
            .tabs-scroll .nav-item {
                flex: 1 1 0;
                min-width: 0;
            }
            .tabs-scroll .nav-link {
                width: 100%;
                font-size: 0.68rem;
                padding: 0.4rem 0.3rem;
                white-space: nowrap;
                gap: 0.2rem;
                justify-content: center;
            }
            .tabs-scroll .nav-link i {
                font-size: 0.72rem;
            }
            .tabs-scroll .nav-link .tab-label {
                display: inline;
            }
            .tabs-scroll .nav-link .badge {
                font-size: 0.58rem;
                margin-left: 0.15rem !important;
                padding: 0.1rem 0.35rem;
            }
        }

        /* =============================================
           ACTIVITY CARD
           ============================================= */
        .activity-card {
            position: relative;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
            border-radius: 1rem;
            padding: 0;
            height: 100%;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.04);
            border: 1px solid rgba(131, 182, 190, 0.25);
            overflow: hidden;
        }

        /* Header (icon + badge) */
        .activity-card__header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 1rem 1.25rem 0.5rem;
        }
        .activity-card__icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--card-gradient);
            color: var(--icon-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        /* Badge */
        .activity-card__badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.3rem 0.65rem;
            border-radius: 50rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .activity-card__badge--gold     { background-color: var(--uya-gold); color: #2a2a2a; }
        .activity-card__badge--primary  { background-color: rgba(13, 110, 253, 0.12); color: #0d6efd; }
        .activity-card__badge--success  { background-color: rgba(25, 135, 84, 0.12); color: #198754; }
        .activity-card__badge--muted    { background-color: rgba(108, 117, 125, 0.12); color: #6c757d; }
        .activity-card__badge--secondary{ background-color: rgba(108, 117, 125, 0.12); color: #6c757d; }

        /* Pulsing ongoing badge */
        .activity-card__badge--pulse {
            background-color: rgba(13, 110, 253, 0.12);
            color: #0d6efd;
        }
        .activity-card__pulse-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #0d6efd;
            box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.7);
            animation: activity-pulse 1.6s infinite;
        }
        @keyframes activity-pulse {
            0%   { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.6); }
            70%  { box-shadow: 0 0 0 7px rgba(13, 110, 253, 0); }
            100% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0); }
        }

        /* Body */
        .activity-card__body {
            padding: 0.25rem 1.25rem 0.75rem;
            flex-shrink: 0;
        }
        .activity-card__title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--uya-dark-teal);
            margin: 0 0 0.4rem 0;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .activity-card__chip {
            display: inline-block;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 0.15rem 0.55rem;
            border-radius: 50rem;
            background-color: rgba(34, 77, 91, 0.08);
            color: var(--uya-dark-teal);
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 0.5rem;
        }
        .activity-card__desc {
            font-size: 0.8rem;
            color: #6b7c83;
            line-height: 1.45;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Metadata grid (date, location, organizer) */
        .activity-card__meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.65rem 1rem;
            padding: 0.5rem 1.25rem;
            background-color: #f8fbfc;
            border-top: 1px solid rgba(131, 182, 190, 0.18);
        }
        .activity-card__meta-item {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-size: 0.75rem;
        }
        .activity-card__meta-item i {
            color: var(--uya-light-blue);
            margin-top: 0.15rem;
            width: 14px;
            text-align: center;
            flex-shrink: 0;
        }
        .activity-card__meta-item > div {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .activity-card__meta-label {
            font-size: 0.6rem;
            color: #9aa8ad;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            font-weight: 600;
        }
        .activity-card__meta-value {
            font-size: 0.78rem;
            color: #2c3e44;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Actions */
        .activity-card__actions {
            padding: 0.5rem 1.25rem 1.1rem;
            display: flex;
            gap: 0.5rem;
            margin-top: auto;
        }
        .activity-card__btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.55rem 0.75rem;
            border-radius: 50rem;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            white-space: nowrap;
        }
        .activity-card__btn--ghost {
            background-color: #ffffff;
            color: var(--uya-dark-teal);
            border-color: var(--uya-dark-teal);
        }
        .activity-card__btn--ghost:hover {
            background-color: var(--uya-dark-teal);
            color: #fff;
        }
        .activity-card__btn--primary {
            background-color: var(--uya-dark-teal);
            color: #ffffff;
            border-color: var(--uya-dark-teal);
        }
        .activity-card__btn--primary:hover {
            filter: brightness(0.92);
        }
        .activity-card__btn--blue {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .activity-card__btn--disabled {
            background-color: #e9ecef;
            color: #6c757d;
            cursor: not-allowed;
        }

        /* State-specific tints */
        .activity-card--registered {
            background-color: #fbfffd;
        }
        .activity-card--finished {
            opacity: 0.92;
        }

        /* =============================================
           COMPACT MOBILE LAYOUT
           ============================================= */
        @media (max-width: 575.98px) {
            .activity-card {
                border-radius: 0.85rem;
            }
            .activity-card__header {
                padding: 0.7rem 0.85rem 0.3rem;
            }
            .activity-card__icon {
                width: 38px;
                height: 38px;
                border-radius: 10px;
                font-size: 1rem;
            }
            .activity-card__badge {
                font-size: 0.6rem;
                padding: 0.22rem 0.5rem;
            }
            .activity-card__body {
                padding: 0.15rem 0.85rem 0.5rem;
            }
            .activity-card__title {
                font-size: 0.92rem;
                margin-bottom: 0.25rem;
                -webkit-line-clamp: 1;
            }
            .activity-card__chip {
                font-size: 0.58rem;
                padding: 0.1rem 0.45rem;
                margin-bottom: 0.3rem;
            }
            .activity-card__desc {
                font-size: 0.72rem;
                -webkit-line-clamp: 1;
            }
            .activity-card__meta {
                grid-template-columns: 1fr 1fr 1fr;
                gap: 0.25rem 0.5rem;
                padding: 0.4rem 0.85rem;
                overflow: hidden;
            }
            .activity-card__meta-item {
                font-size: 0.65rem;
                gap: 0.25rem;
                align-items: center;
            }
            .activity-card__meta-label {
                display: none;
            }
            .activity-card__meta-value {
                font-size: 0.65rem;
            }
            .activity-card__actions {
                padding: 0.4rem 0.85rem 0.8rem;
                gap: 0.35rem;
            }
            .activity-card__btn {
                font-size: 0.72rem;
                padding: 0.45rem 0.55rem;
            }
        }

        /* =============================================
           QR SCANNER MODAL
           ============================================= */
        .qr-viewfinder {
            position: relative;
            width: 100%;
            height: 280px;
            background: #111;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .qr-laser {
            position: absolute;
            width: 80%;
            height: 2px;
            background: #ff3b30;
            box-shadow: 0 0 8px #ff3b30;
            animation: scan 2s infinite ease-in-out;
        }
        @keyframes scan {
            0%   { top: 20%; }
            50%  { top: 80%; }
            100% { top: 20%; }
        }

        /* =============================================
           REGISTER-THEN-MOVE FADE
           ============================================= */
        .register-success-fade {
            transition: opacity 0.35s ease, transform 0.35s ease;
            opacity: 0;
            transform: translateY(-8px);
            pointer-events: none;
        }
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <div class="container-fluid py-3">

        <!-- Header & Search Section -->
        <div class="row mb-3 align-items-center">
            <div class="col-lg-6 mb-2 mb-lg-0">
                <h2 class="fw-bold mb-1 text-brand">Activities</h2>
                <p class="text-muted small mb-0">Browse and join community activities.</p>
            </div>
            <div class="col-lg-6">
                <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white border">
                    <span class="input-group-text bg-white border-0 ps-3 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" class="form-control border-0 shadow-none py-2" placeholder="Search activities..." style="font-size: 0.9rem;">
                </div>
            </div>
        </div>

        <!-- Horizontal Pill Tabs -->
        <div class="mb-4">
            <ul class="nav nav-pills gap-2 flex-nowrap tabs-scroll" id="activityTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active shadow-sm" id="active-tab" data-bs-toggle="pill" data-bs-target="#active-activities" type="button" role="tab">
                        <i class="fa-solid fa-bolt me-1"></i> <span class="tab-label">Active</span> <span class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">{{ $openActivities->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link shadow-sm" id="my-tab" data-bs-toggle="pill" data-bs-target="#my-activities" type="button" role="tab">
                        <i class="fa-regular fa-calendar-check me-1"></i> <span class="tab-label">My Activities</span> <span class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">{{ $myActivities->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link shadow-sm" id="finished-tab" data-bs-toggle="pill" data-bs-target="#finished-activities" type="button" role="tab">
                        <i class="fa-solid fa-check-circle me-1"></i> <span class="tab-label">Finished</span> <span class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">{{ $finishedActivities->count() }}</span>
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content Containers -->
        <div class="tab-content" id="activityTabsContent">

            <!-- TAB 1: Active Activities -->
            <div class="tab-pane fade show active" id="active-activities" role="tabpanel">
                <div class="row g-4">
                    @forelse ($openActivities as $activity)
                        <div class="col-xl-3 col-md-6">
                            @include('partials.activity-card', ['activity' => $activity])
                        </div>
                    @empty
                        <div class="col-12 empty-state text-center py-5">
                            <i class="fa-regular fa-calendar-xmark fa-2x text-muted mb-2"></i>
                            <p class="text-muted small mb-0">No active activities at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- TAB 2: My Activities -->
            <div class="tab-pane fade" id="my-activities" role="tabpanel">
                <div class="row g-4">
                    @forelse ($myActivities as $activity)
                        <div class="col-xl-3 col-md-6">
                            @include('partials.activity-card', ['activity' => $activity])
                        </div>
                    @empty
                        <div class="col-12 empty-state text-center py-5">
                            <i class="fa-regular fa-calendar-xmark fa-2x text-muted mb-2"></i>
                            <p class="text-muted small mb-0">You haven't joined any activities yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- TAB 3: Finished Activities -->
            <div class="tab-pane fade" id="finished-activities" role="tabpanel">
                <div class="row g-4">
                    @forelse ($finishedActivities as $activity)
                        <div class="col-xl-3 col-md-6">
                            @include('partials.activity-card', ['activity' => $activity])
                        </div>
                    @empty
                        <div class="col-12 empty-state text-center py-5">
                            <i class="fa-regular fa-calendar-xmark fa-2x text-muted mb-2"></i>
                            <p class="text-muted small mb-0">No completed activities yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

    <!-- QR Scanner Modal Popup -->
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

                <div class="qr-viewfinder mb-3 shadow-inner">
                    <div class="qr-laser"></div>
                    <div class="text-white-50 small text-center px-3 z-1">
                        <i class="fa-solid fa-qrcode fa-3x mb-2 text-white opacity-50"></i>
                        <p class="mb-0">Align QR code within the frame to scan</p>
                    </div>
                </div>

                <p class="text-muted small text-center mb-4">
                    Scan the QR code displayed by the coordinator to record your attendance.
                </p>

                <button type="button" class="btn btn-outline-dark rounded-pill py-2 w-100 fw-semibold" data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>
        </div>
    </div>

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
                    <span class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.6px;">Activity</span>
                    <div class="fw-semibold text-dark" id="registerActivityTitle" style="font-size: 0.9rem;"></div>
                    <div class="text-muted mt-1" id="registerActivityMeta" style="font-size: 0.75rem;"></div>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light border rounded-pill py-2 w-50 fw-semibold text-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn rounded-pill py-2 w-50 fw-semibold text-white shadow-sm" style="background-color: var(--uya-dark-teal);" id="confirmRegisterBtn">
                        <i class="fa-solid fa-check me-1"></i> Yes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openQRScanner() {
            const modal = new bootstrap.Modal(document.getElementById('qrScannerModal'));
            modal.show();
        }

        // Register button handler
        let pendingRegisterId = null;
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('[data-action="register"]');
            if (!btn) return;
            pendingRegisterId = btn.getAttribute('data-activity-id');
            document.getElementById('registerActivityTitle').textContent = btn.getAttribute('data-activity-title') || '';
            document.getElementById('registerActivityMeta').innerHTML =
                '<i class="fa-regular fa-calendar me-1"></i> ' + (btn.getAttribute('data-activity-date') || 'TBA') +
                ' <span class="mx-1">·</span> ' +
                '<i class="fa-solid fa-location-dot me-1"></i> ' + (btn.getAttribute('data-activity-location') || 'TBA');
            const modal = new bootstrap.Modal(document.getElementById('registerModal'));
            modal.show();
        });

        document.getElementById('confirmRegisterBtn').addEventListener('click', function() {
            if (!pendingRegisterId) return;
            // TODO: wire to backend register endpoint
            console.log('Confirm registration for activity', pendingRegisterId);

            const activeContainer = document.getElementById('active-activities').querySelector('.row');
            const myContainer = document.getElementById('my-activities').querySelector('.row');

            // Find the column wrapper for this activity in the Active tab
            const sourceBtn = document.querySelector('#active-activities [data-action="register"][data-activity-id="' + pendingRegisterId + '"]');
            const sourceCol = sourceBtn ? sourceBtn.closest('.col-xl-3') : null;

            // Build a registered-state clone for the My Activities tab.
            // We rebuild rather than mutate so the card visually matches the
            // status-driven shape (Registered badge, single View Details CTA).
            let registeredCol = null;
            if (sourceCol) {
                registeredCol = sourceCol.cloneNode(true);

                // Tweak the status class so the card reads as "registered"
                const card = registeredCol.querySelector('.activity-card');
                if (card) {
                    card.classList.remove('activity-card--open', 'activity-card--closed');
                    card.classList.add('activity-card--registered');
                }

                // Swap the status badge -> "Registered" (success color)
                const badge = registeredCol.querySelector('.activity-card__badge');
                if (badge) {
                    badge.className = 'activity-card__badge activity-card__badge--success';
                    badge.textContent = 'Registered';
                }

                // Replace the actions row entirely:
                //   - drop the ghost "View Details" (registered state has no secondary)
                //   - swap primary "Register Now" button for a "View Details" link
                const actions = registeredCol.querySelector('.activity-card__actions');
                if (actions) {
                    const ghostLink = actions.querySelector('a.activity-card__btn--ghost');
                    const detailsHref = ghostLink ? ghostLink.getAttribute('href') : '#';
                    actions.innerHTML =
                        '<a href="' + detailsHref + '"' +
                        ' class="activity-card__btn activity-card__btn--primary">' +
                        '<i class="fa-solid fa-arrow-right"></i> View Details' +
                        '</a>';
                }
            }

            // Animate the original out of Active tab, then drop it.
            if (sourceCol) {
                sourceCol.classList.add('register-success-fade');
                setTimeout(function() {
                    sourceCol.remove();
                    appendToMyTab(registeredCol, myContainer, activeContainer);
                    updateTabCounts();
                }, 350);
            } else {
                appendToMyTab(registeredCol, myContainer, activeContainer);
                updateTabCounts();
            }

            pendingRegisterId = null;
            const modal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
            modal.hide();
        });

        // Insert the registered card into the My Activities tab and
        // refresh the empty-state placeholders for both tabs.
        function appendToMyTab(cardCol, myContainer, activeContainer) {
            if (cardCol && myContainer) {
                // Replace an existing empty-state placeholder, if present.
                const placeholder = myContainer.querySelector('.empty-state');
                if (placeholder) placeholder.parentElement.remove();

                myContainer.appendChild(cardCol);

                // Fresh "registered" cards shouldn't carry the fade-out class.
                cardCol.classList.remove('register-success-fade');
                cardCol.style.opacity = '';
                cardCol.style.transform = '';
                cardCol.style.pointerEvents = '';
            }

            // If Active tab now has no cards, show its empty state.
            if (activeContainer && activeContainer.querySelectorAll('.activity-card').length === 0) {
                if (!activeContainer.querySelector('.empty-state')) {
                    const col = document.createElement('div');
                    col.className = 'col-12 empty-state text-center py-5';
                    col.innerHTML =
                        '<i class="fa-regular fa-calendar-xmark fa-2x text-muted mb-2"></i>' +
                        '<p class="text-muted small mb-0">No active activities at the moment.</p>';
                    activeContainer.appendChild(col);
                }
            }
        }

        function updateTabCounts() {
            const active = document.querySelectorAll('#active-activities .activity-card').length;
            const mine = document.querySelectorAll('#my-activities .activity-card').length;
            const finished = document.querySelectorAll('#finished-activities .activity-card').length;
            const tabs = document.querySelectorAll('.tabs-scroll .nav-link .badge');
            if (tabs[0]) tabs[0].textContent = active;
            if (tabs[1]) tabs[1].textContent = mine;
            if (tabs[2]) tabs[2].textContent = finished;
        }
    </script>
</body>
</html>
