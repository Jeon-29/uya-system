<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Proposals - UYA Connect</title>

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

        .text-brand {
            color: var(--uya-dark-teal) !important;
        }

        .container-fluid {
            width: 100% !important;
            padding-left: 2.5rem !important;
            padding-right: 2.5rem !important;
        }

        /* Horizontal Pill Tabs */
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

        /* Clean proposal card — no heavy inner borders */
        .proposal-card {
            background-color: #ffffff;
            border: 1px solid #e8eef0;
            border-radius: 16px;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.04);
            transition: all 0.2s ease;
        }

        .proposal-card:hover {
            box-shadow: 0 6px 18px rgba(34, 77, 91, 0.08);
            border-color: var(--uya-light-blue);
        }

        /* Custom outlined button */
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

        /* Workflow banner */
        .workflow-banner {
            background-color: #ffffff;
            border: 1px solid #e8eef0;
            border-radius: 14px;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.04);
        }

        .workflow-step {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.7rem;
            border-radius: 50rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .workflow-arrow {
            color: #adb5bd;
            font-size: 0.7rem;
        }

        /* Slim 6px dual-color progress bar */
        .vote-progress {
            height: 6px;
            border-radius: 50rem;
            overflow: hidden;
            display: flex;
            background-color: #f1f3f5;
        }

        .vote-progress .vote-progress-yes {
            background-color: var(--bs-success);
        }

        .vote-progress .vote-progress-no {
            background-color: var(--bs-danger);
        }

        /* Yes / No vote buttons */
        .vote-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            font-weight: 600;
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem;
            border-radius: 50rem;
            border: 1px solid transparent;
            transition: all 0.15s ease;
        }

        .vote-btn-yes {
            background-color: var(--bs-success);
            color: #fff;
        }

        .vote-btn-yes:hover {
            background-color: #157347;
            color: #fff;
        }

        .vote-btn-no {
            background-color: #fff;
            color: var(--bs-danger);
            border-color: var(--bs-danger);
        }

        .vote-btn-no:hover {
            background-color: var(--bs-danger);
            color: #fff;
        }
    </style>
</head>

<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    @php
        // Map the proposal's status/outcome fields to the visual badge tuples
        // used by the card markup. Keeping this in the view so the controller
        // can stay as plain-data.
        $statusBadgeMap = [
            'submission' => ['label' => 'Submission', 'class' => 'bg-primary-subtle text-primary'],
            'revision'   => ['label' => 'Revision',   'class' => 'bg-warning-subtle text-warning'],
            'voting'     => ['label' => 'Voting',     'class' => 'bg-warning-subtle text-warning'],
            'closed'     => ['label' => 'Closed',     'class' => 'bg-secondary-subtle text-secondary'],
        ];
        $outcomeBadgeMap = [
            'approved' => ['label' => 'Approved', 'class' => 'bg-success-subtle text-success'],
            'rejected' => ['label' => 'Rejected', 'class' => 'bg-danger-subtle text-danger'],
        ];
    @endphp

    <div class="container-fluid py-4" id="proposalsMainView">

        @if (session('success'))
            <div class="alert alert-success rounded-4 d-flex align-items-center gap-2 mb-3" role="alert"
                 style="font-size: 0.85rem;">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Header & Action Section -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h2 class="fw-bold mb-1 text-brand">Activity Proposals</h2>
                <p class="text-muted small mb-0">Submit, review, revise, and vote on member activity proposals.</p>
            </div>
            <button onclick="toggleCreateView(true)"
                class="btn rounded-pill px-4 py-2 fw-semibold custom-btn-filled d-flex align-items-center gap-2 shadow-sm"
                style="font-size: 0.85rem;">
                <i class="fa-solid fa-plus"></i> Create Proposal
            </button>
        </div>

        <!-- Workflow Banner — compact, mobile collapses to a single status badge -->
        <div class="workflow-banner p-3 p-md-3 mb-4 d-flex align-items-center justify-content-between gap-3 flex-wrap">

            <!-- Mobile-only single status badge -->
            <div class="d-md-none d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-info text-brand"></i>
                <span class="badge rounded-pill bg-primary-subtle text-primary border-0 fw-semibold"
                    style="font-size: 0.75rem;">
                    <i class="fa-solid fa-flag me-1"></i> {{ $currentPhase ?? 'Submission' }}
                </span>
            </div>

            <!-- Desktop-only full step-by-step pipeline -->
            <div class="d-none d-md-flex align-items-center gap-2 flex-wrap">
                <span class="text-brand fw-semibold me-1" style="font-size: 0.85rem;">
                    <i class="fa-solid fa-circle-info me-1"></i> Proposal Workflow
                </span>
                <span class="workflow-step bg-primary-subtle text-primary">
                    <i class="fa-solid fa-pen-to-square"></i> Submission
                </span>
                <i class="fa-solid fa-chevron-right workflow-arrow"></i>
                <span class="text-muted small">Review</span>
                <i class="fa-solid fa-chevron-right workflow-arrow"></i>
                <span class="workflow-step bg-warning-subtle text-warning">
                    <i class="fa-solid fa-check-to-slot"></i> Voting
                </span>
                <i class="fa-solid fa-chevron-right workflow-arrow"></i>
                <span class="text-muted small">Member votes</span>
                <i class="fa-solid fa-chevron-right workflow-arrow"></i>
                <span class="workflow-step bg-secondary-subtle text-secondary">
                    <i class="fa-solid fa-flag-checkered"></i> Closed
                </span>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span class="text-muted" style="font-size: 0.75rem;">Current phase</span>
                <span class="fw-bold text-brand" style="font-size: 0.85rem;">{{ $currentPhase ?? 'Submission' }}</span>
            </div>
        </div>

        <!-- Horizontal Pill Navigation Tabs -->
        <div class="mb-4">
            <ul class="nav nav-pills gap-2" id="proposalTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active shadow-sm" id="other-proposals-tab" data-bs-toggle="pill"
                        data-bs-target="#tab-other-proposals" type="button" role="tab">
                        <i class="fa-solid fa-list-check me-1"></i> Proposals <span
                            class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">{{ $allProposals->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link shadow-sm" id="my-proposals-tab" data-bs-toggle="pill"
                        data-bs-target="#tab-my-proposals" type="button" role="tab">
                        <i class="fa-solid fa-user-pen me-1"></i> My Proposals <span
                            class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">{{ $myProposals->count() }}</span>
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="proposalTabsContent">

            <!-- TAB 1: Proposals -->
            <div class="tab-pane fade show active" id="tab-other-proposals" role="tabpanel">
                <div class="row g-3 g-md-4">

                    @foreach ($allProposals as $p)
                        @php
                            $status = $statusBadgeMap[$p->status] ?? ['label' => ucfirst($p->status), 'class' => 'bg-secondary-subtle text-secondary'];
                            $outcomeBadge = null;
                            if ($p->status === 'closed' && !empty($p->outcome) && isset($outcomeBadgeMap[$p->outcome])) {
                                $outcomeBadge = $outcomeBadgeMap[$p->outcome];
                            }
                            $yes = (int) ($p->yes_votes ?? 0);
                            $no  = (int) ($p->no_votes ?? 0);
                            $total = $yes + $no;
                            $yesPct = $total > 0 ? round(($yes / $total) * 100) : 0;
                            $noPct  = $total > 0 ? round(($no / $total) * 100) : 0;
                            $showVoteButtons = $p->status === 'voting' && $p->open;
                            $viewRoute = $p->status === 'voting' ? 'view-detail' : 'details';
                        @endphp

                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="proposal-card p-3 p-md-4 h-100 d-flex flex-column">

                                <!-- Header: title + status badges -->
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <h5 class="fw-bold mb-0 text-brand lh-sm" style="font-size: 1rem;">
                                        {{ $p->title }}
                                    </h5>
                                    <div class="d-flex flex-column align-items-end gap-1 flex-shrink-0">
                                        <span class="badge rounded-pill border-0 fw-semibold {{ $status['class'] }}"
                                              style="font-size: 0.7rem;">
                                            {{ $status['label'] }}
                                        </span>
                                        @if ($outcomeBadge)
                                            <span class="badge rounded-pill border-0 fw-semibold {{ $outcomeBadge['class'] }}"
                                                  style="font-size: 0.7rem;">
                                                {{ $outcomeBadge['label'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Description -->
                                <p class="text-muted mb-3" style="font-size: 0.85rem; line-height: 1.45;">
                                    {{ $p->description }}
                                </p>

                                <!-- Inline metadata row (icon + text) -->
                                <div class="d-flex flex-wrap align-items-center gap-3 mb-3 text-muted"
                                     style="font-size: 0.8rem;">
                                    <span class="d-inline-flex align-items-center gap-1">
                                        <i class="fa-solid fa-user text-secondary"></i>
                                        {{ $p->proposer->name }}
                                    </span>
                                    <span class="d-inline-flex align-items-center gap-1">
                                        <i class="fa-solid fa-location-dot text-secondary"></i>
                                        {{ $p->location }}
                                    </span>
                                    <span class="d-inline-flex align-items-center gap-1">
                                        <i class="fa-regular fa-clock text-secondary"></i>
                                        {{ $p->duration }}
                                    </span>
                                    <span class="d-inline-flex align-items-center gap-1">
                                        <i class="fa-solid fa-calendar-days text-secondary"></i>
                                        {{ $p->date->format('M d') }}
                                    </span>
                                </div>

                                <!-- Vote progress: slim dual-color bar -->
                                <div class="mb-2 d-flex justify-content-between align-items-center"
                                     style="font-size: 0.75rem;">
                                    <span class="text-muted fw-semibold">Voting Summary</span>
                                    <span class="text-muted">{{ $total }} {{ Str::plural('vote', $total) }}</span>
                                </div>
                                <div class="vote-progress mb-2" role="progressbar"
                                     aria-valuenow="{{ $yesPct }}" aria-valuemin="0" aria-valuemax="100">
                                    <div class="vote-progress-yes" style="width: {{ $yesPct }}%;"></div>
                                    <div class="vote-progress-no" style="width: {{ $noPct }}%;"></div>
                                </div>
                                <div class="d-flex justify-content-between mb-3"
                                     style="font-size: 0.75rem;">
                                    <span class="text-success fw-semibold">
                                        <i class="fa-solid fa-thumbs-up me-1"></i>{{ $yes }} Yes
                                    </span>
                                    <span class="text-muted">{{ $yesPct }}% approval</span>
                                    <span class="text-danger fw-semibold">
                                        {{ $no }} No <i class="fa-solid fa-thumbs-down ms-1"></i>
                                    </span>
                                </div>

                                <!-- Actions: prominent Yes/No when voting is open, subtle View Details link always -->
                                <div class="mt-auto">
                                    @if ($showVoteButtons)
                                        <div class="d-flex gap-2 mb-2">
                                            <button type="button"
                                                onclick="openFeedbackModal('YES', {{ $p->id }}, '{{ addslashes($p->title) }}')"
                                                class="vote-btn vote-btn-yes flex-fill">
                                                <i class="fa-solid fa-thumbs-up"></i> Yes
                                            </button>
                                            <button type="button"
                                                onclick="openFeedbackModal('NO', {{ $p->id }}, '{{ addslashes($p->title) }}')"
                                                class="vote-btn vote-btn-no flex-fill">
                                                <i class="fa-solid fa-thumbs-down"></i> No
                                            </button>
                                        </div>
                                    @endif

                                    <a href="{{ route($viewRoute) }}"
                                       class="d-inline-flex align-items-center gap-1 text-decoration-none fw-semibold text-brand"
                                       style="font-size: 0.8rem;">
                                        View Details <i class="fa-solid fa-arrow-right" style="font-size: 0.7rem;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            <!-- TAB 2: My Proposals -->
            <div class="tab-pane fade" id="tab-my-proposals" role="tabpanel">
                <div class="row g-3 g-md-4">

                    @foreach ($myProposals as $p)
                        @php
                            $status = $statusBadgeMap[$p->status] ?? ['label' => ucfirst($p->status), 'class' => 'bg-secondary-subtle text-secondary'];
                            $outcomeBadge = null;
                            if ($p->status === 'closed' && !empty($p->outcome) && isset($outcomeBadgeMap[$p->outcome])) {
                                $outcomeBadge = $outcomeBadgeMap[$p->outcome];
                            }
                            $yes = (int) ($p->yes_votes ?? 0);
                            $no  = (int) ($p->no_votes ?? 0);
                            $total = $yes + $no;
                            $yesPct = $total > 0 ? round(($yes / $total) * 100) : 0;
                            $noPct  = $total > 0 ? 100 - $yesPct : 0;
                            $showVoteButtons = $p->status === 'voting' && $p->open;
                            $isEditable = $p->status === 'submission' || $p->status === 'revision';
                        @endphp

                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="proposal-card p-3 p-md-4 h-100 d-flex flex-column">

                                <!-- Header: title + status badges -->
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <h5 class="fw-bold mb-0 text-brand lh-sm" style="font-size: 1rem;">
                                        {{ $p->title }}
                                    </h5>
                                    <div class="d-flex flex-column align-items-end gap-1 flex-shrink-0">
                                        <span class="badge rounded-pill border-0 fw-semibold {{ $status['class'] }}"
                                              style="font-size: 0.7rem;">
                                            {{ $status['label'] }}
                                        </span>
                                        @if ($outcomeBadge)
                                            <span class="badge rounded-pill border-0 fw-semibold {{ $outcomeBadge['class'] }}"
                                                  style="font-size: 0.7rem;">
                                                {{ $outcomeBadge['label'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Description -->
                                <p class="text-muted mb-3" style="font-size: 0.85rem; line-height: 1.45;">
                                    {{ $p->description }}
                                </p>

                                <!-- Inline metadata row -->
                                <div class="d-flex flex-wrap align-items-center gap-3 mb-3 text-muted"
                                     style="font-size: 0.8rem;">
                                    <span class="d-inline-flex align-items-center gap-1">
                                        <i class="fa-solid fa-user text-secondary"></i>
                                        {{ $p->proposer->name }}
                                    </span>
                                    <span class="d-inline-flex align-items-center gap-1">
                                        <i class="fa-solid fa-location-dot text-secondary"></i>
                                        {{ $p->location }}
                                    </span>
                                    <span class="d-inline-flex align-items-center gap-1">
                                        <i class="fa-regular fa-clock text-secondary"></i>
                                        {{ $p->duration }}
                                    </span>
                                    <span class="d-inline-flex align-items-center gap-1">
                                        <i class="fa-solid fa-calendar-days text-secondary"></i>
                                        {{ $p->date->format('M d') }}
                                    </span>
                                </div>

                                <!-- Vote progress -->
                                <div class="mb-2 d-flex justify-content-between align-items-center"
                                     style="font-size: 0.75rem;">
                                    <span class="text-muted fw-semibold">Voting Summary</span>
                                    <span class="text-muted">{{ $total }} {{ Str::plural('vote', $total) }}</span>
                                </div>
                                <div class="vote-progress mb-2" role="progressbar"
                                     aria-valuenow="{{ $yesPct }}" aria-valuemin="0" aria-valuemax="100">
                                    <div class="vote-progress-yes" style="width: {{ $yesPct }}%;"></div>
                                    <div class="vote-progress-no" style="width: {{ $noPct }}%;"></div>
                                </div>
                                <div class="d-flex justify-content-between mb-3"
                                     style="font-size: 0.75rem;">
                                    <span class="text-success fw-semibold">
                                        <i class="fa-solid fa-thumbs-up me-1"></i>{{ $yes }} Yes
                                    </span>
                                    <span class="text-muted">{{ $yesPct }}% approval</span>
                                    <span class="text-danger fw-semibold">
                                        {{ $no }} No <i class="fa-solid fa-thumbs-down ms-1"></i>
                                    </span>
                                </div>

                                <!-- Actions -->
                                <div class="mt-auto d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <a href="{{ route('details') }}"
                                       class="d-inline-flex align-items-center gap-1 text-decoration-none fw-semibold text-brand"
                                       style="font-size: 0.8rem;">
                                        View Details <i class="fa-solid fa-arrow-right" style="font-size: 0.7rem;"></i>
                                    </a>
                                    @if ($isEditable)
                                        <button type="button" onclick="openEditProposalModal()"
                                            class="btn btn-sm rounded-pill px-3 fw-semibold custom-btn-filled d-inline-flex align-items-center gap-1"
                                            style="font-size: 0.75rem;">
                                            <i class="fa-regular fa-pen-to-square"></i> Edit
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>

    </div>

    <!-- CREATE PROPOSAL VIEW CONTAINER -->
    <div class="container-fluid py-4 d-none" style="max-width: 900px;" id="createProposalView">

        <!-- Back Button -->
        <div class="mb-4">
            <button onclick="toggleCreateView(false)"
                class="btn btn-light border rounded-pill px-3 py-2 fw-semibold text-brand shadow-sm d-inline-flex align-items-center gap-2"
                style="font-size: 0.85rem;">
                <i class="fa-solid fa-arrow-left"></i> Back to Proposals
            </button>
        </div>

        <!-- Create Proposal Form Card -->
        <div class="card p-4 pastel-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold text-brand mb-0" style="font-size: 1.15rem;">Create New Proposal</h4>
                <button type="button" class="btn-close shadow-none" onclick="toggleCreateView(false)"></button>
            </div>
            <hr class="text-muted opacity-25 mb-4">

            <form method="POST" action="{{ route('proposals.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Proposal Title
                        *</label>
                    <input type="text" name="title" class="form-control rounded-pill py-2 px-3 shadow-none border"
                        placeholder="e.g., Beach Cleanup Activity" value="{{ old('title') }}" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Location *</label>
                        <input type="text" name="location" class="form-control rounded-pill py-2 px-3 shadow-none border"
                            placeholder="e.g., Silang, Cavite" value="{{ old('location') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Duration *</label>
                        <input type="text" name="duration" class="form-control rounded-pill py-2 px-3 shadow-none border"
                            placeholder="e.g., 3 hours, Half day, Full day" value="{{ old('duration') }}" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Proposed Date
                            *</label>
                        <div class="input-group">
                            <input type="date" name="proposed_date"
                                class="form-control rounded-pill-start py-2 px-3 shadow-none border"
                                value="{{ old('proposed_date') }}" required>
                            <span class="input-group-text bg-white border rounded-pill-end px-3 text-muted"><i
                                    class="fa-regular fa-calendar"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Voting Deadline
                            *</label>
                        <input type="text" name="voting_deadline"
                            class="form-control rounded-pill py-2 px-3 shadow-none border bg-light"
                            value="08/20/2026" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Estimated
                        Budget</label>
                    <input type="text" name="budget" class="form-control rounded-pill py-2 px-3 shadow-none border"
                        placeholder="e.g., ₱1,500" value="{{ old('budget') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Description *</label>
                    <textarea name="description" class="form-control rounded-4 p-3 shadow-none border" rows="4"
                        placeholder="Describe your proposal in detail..." style="resize: none;" required>{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Attachments <span
                            class="text-muted fw-normal">(optional — PDF, DOC, DOCX)</span></label>
                    <div class="border border-dashed rounded-4 p-4 text-center bg-light"
                        style="border-style: dashed !important; border-color: #cbd9df !important;">
                        <div class="text-secondary mb-2" style="font-size: 1.25rem;"><i
                                class="fa-solid fa-paperclip"></i></div>
                        <div class="fw-semibold text-dark mb-1" style="font-size: 0.85rem;">Click to browse or drag
                            &amp; drop files here</div>
                        <div class="text-muted" style="font-size: 0.75rem;">PDF, DOC, DOCX · max 10 MB each</div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <button type="button" onclick="toggleCreateView(false)"
                        class="btn btn-light border rounded-pill px-4 py-2 fw-semibold text-secondary">Cancel</button>
                    <button type="button"
                        class="btn border rounded-pill px-4 py-2 fw-semibold text-dark bg-white shadow-sm"
                        style="border-color: #D8B257 !important;" onclick="saveAsDraft()">
                        <i class="fa-regular fa-file-lines me-1 text-warning"></i> Save as Draft
                    </button>
                    <button type="submit" class="btn rounded-pill px-4 py-2 fw-semibold text-dark shadow-sm"
                        style="background-color: var(--uya-gold);">Submit Proposal</button>
                </div>
            </form>
        </div>

    </div>

    <!-- Vote & Feedback Modal Popup -->
    <form id="voteFeedbackForm" method="POST" action="">
        @csrf
        <input type="hidden" name="vote" id="voteChoice" value="yes">
        <div class="modal fade" id="voteFeedbackModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
                <div class="modal-content rounded-4 shadow-lg border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                        <h5 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">Share your thoughts on this
                            proposal</h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="p-3 rounded-3 mb-3 border bg-light" id="voteSelectionNotice"
                        style="font-size: 0.85rem; line-height: 1.4;">
                        You selected <strong>YES</strong>. Add short feedback so the proposer and officers can understand
                        your vote.
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Thoughts on this
                            proposal</label>
                        <textarea name="feedback" class="form-control rounded-4 p-3 shadow-none border" rows="4"
                            placeholder="Example: This activity is helpful because..." style="font-size: 0.9rem; resize: none;"></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button"
                            class="btn btn-light border rounded-pill py-2 w-50 fw-semibold text-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit"
                            class="btn rounded-pill py-2 w-50 fw-semibold text-white shadow-sm d-flex align-items-center justify-content-center gap-2"
                            style="background-color: var(--uya-dark-teal);">
                            <i class="fa-regular fa-comment-dots"></i> Submit Vote &amp; Feedback
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Edit Proposal Modal Popup -->
    <form id="editProposalForm" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal fade" id="editProposalModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 900px;">
                <div class="modal-content rounded-4 shadow-lg border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                        <h5 class="fw-bold text-brand mb-0" style="font-size: 1.15rem;">Edit Proposal</h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Proposal Title
                            *</label>
                        <input type="text" name="title" id="editTitle"
                            class="form-control rounded-pill py-2 px-3 shadow-none border" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Location
                                *</label>
                            <input type="text" name="location" id="editLocation"
                                class="form-control rounded-pill py-2 px-3 shadow-none border" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Duration
                                *</label>
                            <input type="text" name="duration" id="editDuration"
                                class="form-control rounded-pill py-2 px-3 shadow-none border" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Proposed Date
                                *</label>
                            <div class="input-group">
                                <input type="date" name="proposed_date" id="editDate"
                                    class="form-control rounded-pill-start py-2 px-3 shadow-none border" required>
                                <span class="input-group-text bg-white border rounded-pill-end px-3 text-muted"><i
                                        class="fa-regular fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Voting
                                Deadline *</label>
                            <input type="text" id="editDeadline"
                                class="form-control rounded-pill py-2 px-3 shadow-none border bg-light"
                                value="08/20/2026" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Estimated
                            Budget</label>
                        <input type="text" name="budget" id="editBudget"
                            class="form-control rounded-pill py-2 px-3 shadow-none border">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Description
                            *</label>
                        <textarea name="description" id="editDescription"
                            class="form-control rounded-4 p-3 shadow-none border" rows="4"
                            style="resize: none;" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Attachments <span
                                class="text-muted fw-normal">(optional — PDF, DOC, DOCX)</span></label>
                        <div class="border border-dashed rounded-4 p-4 text-center bg-light"
                            style="border-style: dashed !important; border-color: #cbd9df !important;">
                            <div class="text-secondary mb-2" style="font-size: 1.25rem;"><i
                                    class="fa-solid fa-paperclip"></i></div>
                            <div class="fw-semibold text-dark mb-1" style="font-size: 0.85rem;">Click to browse or
                                drag &amp; drop files here</div>
                            <div class="text-muted" style="font-size: 0.75rem;">PDF, DOC, DOCX · max 10 MB each</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <button type="button"
                            class="btn btn-light border rounded-pill px-4 py-2 fw-semibold text-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill px-4 py-2 fw-semibold text-dark shadow-sm"
                            style="background-color: var(--uya-gold);">Update Proposal</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleCreateView(showCreate) {
            const mainView = document.getElementById('proposalsMainView');
            const createView = document.getElementById('createProposalView');

            if (showCreate) {
                mainView.classList.add('d-none');
                createView.classList.remove('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                createView.classList.add('d-none');
                mainView.classList.remove('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        function openFeedbackModal(voteType, proposalId, proposalTitle) {
            const noticeBox = document.getElementById('voteSelectionNotice');
            const choice = (voteType === 'YES') ? 'yes' : 'no';
            const label = voteType;
            noticeBox.innerHTML =
                `You selected <strong>${label}</strong> on “${proposalTitle}”. Add short feedback so the proposer and officers can understand your vote.`;
            document.getElementById('voteChoice').value = choice;
            document.getElementById('voteFeedbackForm').action = `/proposals/${proposalId}/vote`;
            const modal = new bootstrap.Modal(document.getElementById('voteFeedbackModal'));
            modal.show();
        }

        function saveAsDraft() {
            const form = document.querySelector('#createProposalView form');
            if (form) {
                form.action = "{{ route('proposals.draft') }}";
                form.submit();
            }
        }

        function openEditProposalModal(proposalId, title, location, duration, date, budget, description) {
            document.getElementById('editProposalForm').action = `/proposals/${proposalId}`;
            document.getElementById('editTitle').value = title;
            document.getElementById('editLocation').value = location;
            document.getElementById('editDuration').value = duration;
            document.getElementById('editDate').value = date;
            document.getElementById('editBudget').value = budget || '';
            document.getElementById('editDescription').value = description;
            const modal = new bootstrap.Modal(document.getElementById('editProposalModal'));
            modal.show();
        }
    </script>
</body>

</html>
