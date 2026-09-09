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
        }

        .pastel-card {
            background-color: #ffffff;
            border: 1px solid #dce5e8 !important;
            border-radius: 16px;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.03);
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

        .proposal-item {
            background-color: #ffffff;
            border: 1px solid #dce5e8 !important;
            border-radius: 16px;
            transition: all 0.2s ease;
        }

        .proposal-item:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            border-color: var(--uya-light-blue) !important;
        }

        .info-pill {
            background-color: #f3f7f9;
            border: 1px solid #dce5e8;
            border-radius: 50rem;
            padding: 0.35rem 0.75rem;
            font-size: 0.75rem;
            color: #555;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            white-space: nowrap;
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
    </style>
</head>

<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <!-- Main Container with full width utilization on desktop -->
    <div class="container-fluid py-4 px-3 px-md-4 px-lg-5" id="proposalsMainView">

        @if (session('error'))
            <div class="alert alert-danger rounded-4 mb-4">{{ session('error') }}</div>
        @endif

        <!-- Header & Action Section -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h2 class="fw-bold mb-1 text-brand">Activity Proposals</h2>
                <p class="text-muted small mb-0">Submit, review, revise, and vote on member activity proposals[cite: 15].</p>
            </div>
            <!-- Triggers Modal directly via data-bs-target -->
            <button type="button" data-bs-toggle="modal" data-bs-target="#createProposalModal"
                class="btn rounded-pill px-4 py-2 fw-semibold custom-btn-filled d-flex align-items-center gap-2 shadow-sm"
                style="font-size: 0.85rem;">
                <i class="fa-solid fa-plus"></i> Create Proposal
            </button>
        </div>

        <!-- Proposal Workflow Status Banner Card -->
        <div
            class="card p-3.5 px-4 pastel-card mb-4 d-flex flex-row justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="text-brand fs-5"><i class="fa-solid fa-circle-info"></i></div>
                <div>
                    <h6 class="fw-bold text-brand mb-1" style="font-size: 0.95rem;">Proposal Workflow</h6>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="badge rounded-pill bg-primary px-2.5 py-1"
                            style="font-size: 0.65rem;">Submission</span>
                        <span class="text-muted small">→</span>
                        <span class="text-muted small fw-semibold">Review and revisions</span>
                        <span class="text-muted small">→</span>
                        <span class="badge rounded-pill bg-warning text-dark px-2.5 py-1"
                            style="font-size: 0.65rem;">Voting</span>
                        <span class="text-muted small">→</span>
                        <span class="text-muted small">Member votes</span>
                        <span class="text-muted small">→</span>
                        <span class="badge rounded-pill bg-dark text-white px-2.5 py-1"
                            style="font-size: 0.65rem;">Closed</span>
                        <span class="text-muted small">→</span>
                        <span class="text-muted small fw-semibold">Final result</span>
                    </div>
                </div>
            </div>
            <div class="bg-light border px-3 py-2 rounded-3">
                <span class="text-muted d-block" style="font-size: 0.7rem;">Current module phase</span>
                <span class="fw-bold text-brand" style="font-size: 0.85rem;">Submission</span>
            </div>
        </div>

        <!-- Horizontal Pill Navigation Tabs -->
        <div class="mb-4">
            <ul class="nav nav-pills gap-2" id="proposalTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link shadow-sm {{ $tab === 'my' ? '' : 'active' }}" id="other-proposals-tab" data-bs-toggle="pill"
                        data-bs-target="#tab-other-proposals" type="button" role="tab">
                        <i class="fa-solid fa-list-check me-1"></i> Proposals <span
                            class="bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">{{ $allCount }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link shadow-sm {{ $tab === 'my' ? 'active' : '' }}" id="my-proposals-tab" data-bs-toggle="pill"
                        data-bs-target="#tab-my-proposals" type="button" role="tab">
                        <i class="fa-solid fa-user-pen me-1"></i> My Proposals <span
                            class="bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">{{ $myCount }}</span>
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="proposalTabsContent">

            <!-- TAB 1: Other Proposals -->
            <div class="tab-pane fade {{ $tab === 'my' ? '' : 'show active' }}" id="tab-other-proposals" role="tabpanel">
                <div class="row g-4">
                    @if($otherProposals->isEmpty())
                        <div class="col-12">
                            <p class="text-center text-muted py-5">No proposals found.</p>
                        </div>
                    @else
                        @foreach($otherProposals as $proposal)
                            <div class="col-xl-4 col-md-6">
                                <div class="card p-4 proposal-item shadow-sm h-100 d-flex flex-column justify-content-between">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2.5 gap-2">
                                            <h5 class="fw-bold mb-0 text-brand" style="font-size: 1rem;">{{ $proposal->title }}</h5>
                                            <div class="d-flex gap-1 flex-shrink-0">
                                                @php
                                                    $statusLabels = [
                                                        'submitted' => 'Submitted',
                                                        'under_review' => 'Under Review',
                                                        'revision_requested' => 'Revision Requested',
                                                        'voting' => 'Voting',
                                                        'closed' => 'Closed',
                                                        'approved' => 'Approved',
                                                        'rejected' => 'Rejected',
                                                    ];
                                                    $statusClasses = [
                                                        'submitted' => 'bg-primary',
                                                        'under_review' => 'bg-info',
                                                        'revision_requested' => 'bg-warning text-dark',
                                                        'voting' => 'bg-warning text-dark',
                                                        'closed' => 'bg-dark text-white',
                                                        'approved' => 'bg-success text-white',
                                                        'rejected' => 'bg-danger text-white',
                                                    ];
                                                @endphp
                                                <span class="badge rounded-pill px-3 py-1.5 fw-semibold {{ $statusClasses[$proposal->status] ?? 'bg-secondary' }}"
                                                    style="font-size: 0.7rem;">
                                                    {{ $statusLabels[$proposal->status] ?? ucfirst(str_replace('_', ' ', $proposal->status)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <p class="text-muted small mb-3" style="font-size: 0.85rem; line-height: 1.4;">
                                            {{ $proposal->description }}
                                        </p>

                                        <div class="d-flex flex-wrap gap-1.5 mb-3">
                                            <div class="info-pill"><i class="fa-regular fa-user text-secondary"></i> {{ $proposal->proposer->name ?? 'Unknown' }}</div>
                                            <div class="info-pill"><i class="fa-solid fa-location-dot text-secondary"></i> {{ $proposal->location }}</div>
                                            <div class="info-pill"><i class="fa-regular fa-clock text-secondary"></i> {{ $proposal->duration }}</div>
                                            <div class="info-pill"><i class="fa-regular fa-calendar text-secondary"></i> {{ $proposal->proposed_date ? $proposal->proposed_date->format('F j') : 'TBD' }}</div>
                                        </div>

                                        <div class="bg-light border rounded-3 p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 0.8rem;">
                                                <span class="text-muted fw-semibold">Voting Summary</span>
                                                <span class="text-muted">{{ $proposal->total_votes }} total votes</span>
                                            </div>
                                            <div class="row g-2 mb-2">
                                                <div class="col-6">
                                                    <div class="p-2 rounded-2 border border-success border-opacity-25 d-flex justify-content-between align-items-center"
                                                        style="background-color: #e8f8f0;">
                                                        <span class="text-success fw-semibold" style="font-size: 0.75rem;"><i
                                                                class="fa-regular fa-thumbs-up me-1"></i> Yes</span>
                                                        <span class="fw-bold text-success" style="font-size: 0.8rem;">
                                                            {{ $proposal->yes_count }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="p-2 rounded-2 bg-white border border-danger border-opacity-25 d-flex justify-content-between align-items-center">
                                                        <span class="text-danger fw-semibold" style="font-size: 0.75rem;"><i
                                                                class="fa-regular fa-thumbs-down me-1"></i> No</span>
                                                        <span class="fw-bold text-danger" style="font-size: 0.8rem;">
                                                            {{ $proposal->no_count }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="progress mb-1.5" style="height: 6px;">
                                                <div class="progress-bar bg-{{ $proposal->approval_percentage >= 70 ? 'success' : ($proposal->approval_percentage >= 40 ? 'warning' : 'danger') }}"
                                                    role="progressbar" style="width: {{ $proposal->approval_percentage }}%;">
                                                </div>
                                            </div>
                                            <div class="text-end text-muted" style="font-size: 0.7rem;">
                                                {{ $proposal->approval_percentage }}% approval
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        $hasVoted = $proposal->votes->contains('user_id', auth()->id());
                                    @endphp
                                    <div class="d-flex flex-column gap-2 pt-2">
                                        <a href="{{ route('proposals.show', $proposal->id) }}"
                                            class="btn btn-sm rounded-pill py-2 fw-semibold custom-btn-outline"
                                            style="font-size: 0.8rem;">View Details</a>
                                        @if ($proposal->status === 'voting' && !$hasVoted)
                                            <div class="bg-light border rounded-3 p-2 text-center">
                                                <span class="text-muted d-block mb-1.5" style="font-size: 0.7rem;">Cast your vote</span>
                                                <div class="d-flex gap-2">
                                                    <button type="button" onclick="openFeedbackModal('yes', {{ $proposal->id }}, '{{ addslashes($proposal->title) }}')"
                                                        class="btn btn-sm rounded-pill w-50 py-1.5 fw-semibold text-white custom-btn-filled"
                                                        style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-up me-1"></i>
                                                        Yes</button>
                                                    <button type="button" onclick="openFeedbackModal('no', {{ $proposal->id }}, '{{ addslashes($proposal->title) }}')"
                                                        class="btn btn-sm rounded-pill w-50 py-1.5 fw-semibold border border-danger text-danger bg-white"
                                                        style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-down me-1"></i>
                                                        No</button>
                                                </div>
                                            </div>
                                        @elseif ($hasVoted)
                                            <div class="bg-light border rounded-3 p-2 text-center text-muted" style="font-size: 0.75rem;">
                                                <i class="fa-solid fa-check-circle me-1 text-success"></i> You already voted on this proposal
                                            </div>
                                        @else
                                            <div class="bg-light border rounded-3 p-2 text-center text-muted" style="font-size: 0.75rem;">
                                                Voting is not open for this proposal yet
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- TAB 2: My Proposals -->
            <div class="tab-pane fade {{ $tab === 'my' ? 'show active' : '' }}" id="tab-my-proposals" role="tabpanel">
                <div class="row g-4">
                    @if($myProposals->isEmpty())
                        <div class="col-12">
                            <p class="text-center text-muted py-5">No proposals found.</p>
                        </div>
                    @else
                        @foreach($myProposals as $proposal)
                            <div class="col-xl-4 col-md-6">
                                <div class="card p-4 proposal-item shadow-sm h-100 d-flex flex-column justify-content-between">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2.5 gap-2">
                                            <h5 class="fw-bold mb-0 text-brand" style="font-size: 1rem;">{{ $proposal->title }}</h5>
                                            <div class="d-flex gap-1 flex-shrink-0">
                                                @php
                                                    $statusLabels = [
                                                        'submitted' => 'Submitted',
                                                        'under_review' => 'Under Review',
                                                        'revision_requested' => 'Revision Requested',
                                                        'voting' => 'Voting',
                                                        'closed' => 'Closed',
                                                        'approved' => 'Approved',
                                                        'rejected' => 'Rejected',
                                                    ];
                                                    $statusClasses = [
                                                        'submitted' => 'bg-primary',
                                                        'under_review' => 'bg-info',
                                                        'revision_requested' => 'bg-warning text-dark',
                                                        'voting' => 'bg-warning text-dark',
                                                        'closed' => 'bg-dark text-white',
                                                        'approved' => 'bg-success text-white',
                                                        'rejected' => 'bg-danger text-white',
                                                    ];
                                                @endphp
                                                <span class="badge rounded-pill px-3 py-1.5 fw-semibold {{ $statusClasses[$proposal->status] ?? 'bg-secondary' }}"
                                                    style="font-size: 0.7rem;">
                                                    {{ $statusLabels[$proposal->status] ?? ucfirst(str_replace('_', ' ', $proposal->status)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <p class="text-muted small mb-3" style="font-size: 0.85rem; line-height: 1.4;">
                                            {{ $proposal->description }}
                                        </p>

                                        <div class="d-flex flex-wrap gap-1.5 mb-3">
                                            <div class="info-pill"><i class="fa-regular fa-user text-secondary"></i> {{ $proposal->proposer->name ?? 'Unknown' }}</div>
                                            <div class="info-pill"><i class="fa-solid fa-location-dot text-secondary"></i> {{ $proposal->location }}</div>
                                            <div class="info-pill"><i class="fa-regular fa-clock text-secondary"></i> {{ $proposal->duration }}</div>
                                            <div class="info-pill"><i class="fa-regular fa-calendar text-secondary"></i> {{ $proposal->proposed_date ? $proposal->proposed_date->format('F j') : 'TBD' }}</div>
                                        </div>

                                        <div class="bg-light border rounded-3 p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 0.8rem;">
                                                <span class="text-muted fw-semibold">Voting Summary</span>
                                                <span class="text-muted">{{ $proposal->total_votes }} total votes</span>
                                            </div>
                                            <div class="row g-2 mb-2">
                                                <div class="col-6">
                                                    <div class="p-2 rounded-2 border border-success border-opacity-25 d-flex justify-content-between align-items-center"
                                                        style="background-color: #e8f8f0;">
                                                        <span class="text-success fw-semibold" style="font-size: 0.75rem;"><i
                                                                class="fa-regular fa-thumbs-up me-1"></i> Yes</span>
                                                        <span class="fw-bold text-success" style="font-size: 0.8rem;">
                                                            {{ $proposal->yes_count }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="p-2 rounded-2 bg-white border border-danger border-opacity-25 d-flex justify-content-between align-items-center">
                                                        <span class="text-danger fw-semibold" style="font-size: 0.75rem;"><i
                                                                class="fa-regular fa-thumbs-down me-1"></i> No</span>
                                                        <span class="fw-bold text-danger" style="font-size: 0.8rem;">
                                                            {{ $proposal->no_count }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="progress mb-1.5" style="height: 6px;">
                                                <div class="progress-bar bg-{{ $proposal->approval_percentage >= 70 ? 'success' : ($proposal->approval_percentage >= 40 ? 'warning' : 'danger') }}"
                                                    role="progressbar" style="width: {{ $proposal->approval_percentage }}%;">
                                                </div>
                                            </div>
                                            <div class="text-end text-muted" style="font-size: 0.7rem;">
                                                {{ $proposal->approval_percentage }}% approval
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2 pt-2">
                                        <a href="{{ route('proposals.show', $proposal->id) }}"
                                            class="btn btn-sm rounded-pill py-2 w-50 fw-semibold custom-btn-outline"
                                            style="font-size: 0.8rem;">View Details</a>
                                        @if (in_array($proposal->status, ['submitted', 'revision_requested']))
                                            <button type="button" onclick="openEditProposalModal({{ $proposal->id }})"
                                                class="btn btn-sm rounded-pill py-2 w-50 fw-semibold custom-btn-filled"
                                                style="font-size: 0.8rem;"><i class="fa-regular fa-pen-to-square me-1"></i>
                                                Edit</button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden data used to populate the Edit Proposal modal via JS -->
                            <div id="proposalData-{{ $proposal->id }}" style="display: none;">
                                {!! json_encode([
                                    'id' => $proposal->id,
                                    'title' => $proposal->title,
                                    'description' => $proposal->description,
                                    'location' => $proposal->location,
                                    'duration' => $proposal->duration,
                                    'estimated_budget' => $proposal->estimated_budget,
                                    'proposed_date' => $proposal->proposed_date ? $proposal->proposed_date->format('Y-m-d') : '',
                                    'voting_deadline' => $proposal->voting_deadline ? $proposal->voting_deadline->format('Y-m-d') : '',
                                    'update_url' => route('proposals.update', $proposal->id),
                                ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>


    <!-- ============================================== -->
    <!-- MODALS SECTION                                 -->
    <!-- ============================================== -->

    <!-- CREATE PROPOSAL MODAL -->
    <div class="modal fade" id="createProposalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 620px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <h5 class="fw-bold text-brand mb-0" style="font-size: 1.05rem;">Create New Proposal</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                @if ($errors->any() && old('title'))
                    <div class="alert alert-danger rounded-3 py-2 px-3 mb-2" style="font-size: 0.8rem;">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('proposals.store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="mb-2">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Proposal Title *</label>
                        <input type="text" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;"
                            name="title" value="{{ old('title') }}" placeholder="e.g., Beach Cleanup Activity" required>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Location *</label>
                            <input type="text" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;"
                                name="location" value="{{ old('location') }}" placeholder="e.g., Silang, Cavite" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Duration *</label>
                            <input type="text" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;"
                                name="duration" value="{{ old('duration') }}" placeholder="e.g., 3 hours" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Proposed Date *</label>
                            <input type="date" id="createProposedDate" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;"
                                name="proposed_date" value="{{ old('proposed_date') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Voting Deadline *</label>

                            @php
                                $isOfficer = in_array(auth()->user()->role ?? 'member', ['admin', 'officer']);
                            @endphp

                            @if($isOfficer)
                                <input type="date" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;"
                                    name="voting_deadline" value="{{ old('voting_deadline') }}" required>
                            @else
                                <!-- Standard members see the auto-calculated voting deadline date -->
                                <input type="date" id="createVotingDeadline" class="form-control rounded-pill py-1.5 px-3 shadow-none border bg-light text-muted" style="font-size: 0.85rem;"
                                    name="voting_deadline" value="{{ old('voting_deadline') }}" readonly required>
                                <div class="form-text mt-0.5 text-muted" style="font-size: 0.7rem;">Automatically set to 7 days before proposed date.</div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Estimated Budget</label>
                        <input type="text" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;"
                            name="estimated_budget" value="{{ old('estimated_budget') }}" placeholder="e.g., ₱1,500">
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Description *</label>
                        <textarea class="form-control rounded-4 p-2.5 shadow-none border" rows="3" style="font-size: 0.85rem;"
                            name="description" placeholder="Describe your proposal in detail..." style="resize: none;" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Attachments <span class="text-muted fw-normal">(optional)</span></label>
                        <div class="border border-dashed rounded-4 p-2.5 text-center bg-light"
                            style="border-style: dashed !important; border-color: #cbd9df !important; cursor: pointer;"
                            onclick="document.getElementById('attachmentInput').click()">
                            <div class="text-secondary mb-1" style="font-size: 1rem;"><i class="fa-solid fa-paperclip"></i></div>
                            <div class="fw-semibold text-dark mb-0.5" style="font-size: 0.78rem;">Click to browse files</div>
                            <div class="text-muted" style="font-size: 0.68rem;">PDF, DOC, DOCX · max 10 MB</div>
                            <input type="file" name="attachments[]" multiple class="d-none" id="attachmentInput">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <button type="button" class="btn btn-light border rounded-pill px-3 py-1.5 fw-semibold text-secondary" style="font-size: 0.8rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill px-3 py-1.5 fw-semibold text-dark shadow-sm" style="font-size: 0.8rem; background-color: var(--uya-gold);">Submit Proposal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT PROPOSAL MODAL -->
    <div class="modal fade" id="editProposalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 620px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <h5 class="fw-bold text-brand mb-0" style="font-size: 1.05rem;">Edit Proposal</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="editProposalForm" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-2">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Proposal Title *</label>
                        <input type="text" id="editTitle" name="title" style="font-size: 0.85rem;"
                            class="form-control rounded-pill py-1.5 px-3 shadow-none border" value="" required>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Location *</label>
                            <input type="text" id="editLocation" name="location" style="font-size: 0.85rem;"
                                class="form-control rounded-pill py-1.5 px-3 shadow-none border" value="" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Duration *</label>
                            <input type="text" id="editDuration" name="duration" style="font-size: 0.85rem;"
                                class="form-control rounded-pill py-1.5 px-3 shadow-none border" value="" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Proposed Date *</label>
                            <input type="date" id="editDate" name="proposed_date" style="font-size: 0.85rem;"
                                class="form-control rounded-pill py-1.5 px-3 shadow-none border" value="" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Voting Deadline *</label>
                            @php
                                $isOfficer = in_array(auth()->user()->role ?? 'member', ['admin', 'officer']);
                            @endphp

                            @if($isOfficer)
                                <input type="date" id="editDeadline" name="voting_deadline" style="font-size: 0.85rem;"
                                    class="form-control rounded-pill py-1.5 px-3 shadow-none border" required>
                            @else
                                <input type="date" id="editDeadline" style="font-size: 0.85rem;"
                                    class="form-control rounded-pill py-1.5 px-3 shadow-none border bg-light text-muted" readonly>
                                <div class="form-text mt-0.5 text-muted" style="font-size: 0.7rem;">Automatically calculated deadline.</div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Estimated Budget</label>
                        <input type="text" id="editBudget" name="estimated_budget" style="font-size: 0.85rem;"
                            class="form-control rounded-pill py-1.5 px-3 shadow-none border" value="">
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Description *</label>
                        <textarea id="editDescription" name="description" class="form-control rounded-4 p-2.5 shadow-none border" rows="3" style="font-size: 0.85rem; resize: none;" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Attachments <span class="text-muted fw-normal">(optional)</span></label>
                        <div class="border border-dashed rounded-4 p-2.5 text-center bg-light"
                            style="border-style: dashed !important; border-color: #cbd9df !important; cursor: pointer;"
                            onclick="document.getElementById('editAttachmentInput').click()">
                            <div class="text-secondary mb-1" style="font-size: 1rem;"><i class="fa-solid fa-paperclip"></i></div>
                            <div class="fw-semibold text-dark mb-0.5" style="font-size: 0.78rem;">Click to browse files</div>
                            <div class="text-muted" style="font-size: 0.68rem;">PDF, DOC, DOCX · max 10 MB</div>
                            <input type="file" name="attachments[]" multiple class="d-none" id="editAttachmentInput">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <button type="button" class="btn btn-light border rounded-pill px-3 py-1.5 fw-semibold text-secondary" style="font-size: 0.8rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill px-3 py-1.5 fw-semibold text-dark shadow-sm" style="font-size: 0.8rem; background-color: var(--uya-gold);">Update Proposal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- VOTE FEEDBACK MODAL -->
    <div class="modal fade" id="voteFeedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.05rem;">Share your thoughts on this proposal</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="voteFeedbackForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="vote" id="voteValue" value="">

                    <div class="p-2.5 rounded-3 mb-2 border bg-light" id="voteSelectionNotice" style="font-size: 0.8rem; line-height: 1.3;">
                        Add short feedback so the proposer and officers can understand your vote.
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Thoughts on this proposal</label>
                        <textarea name="feedback" class="form-control rounded-4 p-2.5 shadow-none border" rows="3"
                            placeholder="Example: This activity is helpful because..." style="font-size: 0.85rem; resize: none;"></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light border rounded-pill py-1.5 w-50 fw-semibold text-secondary" style="font-size: 0.8rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill py-1.5 w-50 fw-semibold text-white shadow-sm d-flex align-items-center justify-content-center gap-1.5" style="font-size: 0.8rem; background-color: var(--uya-dark-teal);">
                            <i class="fa-regular fa-comment-dots"></i> Submit Vote
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content rounded-4 p-3">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title text-success fs-6">Success!</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-2">
                    <div class="icon-success mb-2">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                            style="width: 45px; height: 45px; font-size: 1.25rem;">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>
                    <p class="text-success fw-semibold mb-0" style="font-size: 0.9rem;">Action completed successfully!</p>
                </div>
                <div class="modal-footer border-0 justify-content-center pt-0">
                    <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-4" data-bs-dismiss="modal" style="font-size: 0.80rem;">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Automatically calculate and display voting deadline (7 days prior) for non-officers
        document.getElementById('createProposedDate')?.addEventListener('change', function() {
            const proposedVal = this.value;
            const deadlineInput = document.getElementById('createVotingDeadline');
            if (proposedVal && deadlineInput) {
                let d = new Date(proposedVal);
                d.setDate(d.getDate() - 7);
                let yyyy = d.getFullYear();
                let mm = String(d.getMonth() + 1).padStart(2, '0');
                let dd = String(d.getDate()).padStart(2, '0');
                deadlineInput.value = `${yyyy}-${mm}-${dd}`;
            }
        });

        function openFeedbackModal(voteType, proposalId, proposalTitle) {
            const noticeBox = document.getElementById('voteSelectionNotice');
            const label = voteType === 'yes' ? 'YES' : 'NO';
            noticeBox.innerHTML =
                `You selected <strong>${label}</strong> on "${proposalTitle}". Add short feedback so the proposer and officers can understand your vote.`;

            document.getElementById('voteValue').value = voteType;
            document.getElementById('voteFeedbackForm').action =
                "{{ url('/proposals') }}/" + proposalId + "/vote";

            const modal = new bootstrap.Modal(document.getElementById('voteFeedbackModal'));
            modal.show();
        }

        function openEditProposalModal(proposalId) {
            const dataEl = document.getElementById('proposalData-' + proposalId);
            if (!dataEl) {
                return;
            }
            const data = JSON.parse(dataEl.textContent);

            document.getElementById('editTitle').value = data.title || '';
            document.getElementById('editLocation').value = data.location || '';
            document.getElementById('editDuration').value = data.duration || '';
            document.getElementById('editDate').value = data.proposed_date || '';
            if(document.getElementById('editDeadline')) {
                document.getElementById('editDeadline').value = data.voting_deadline || '';
            }
            document.getElementById('editBudget').value = data.estimated_budget || '';
            document.getElementById('editDescription').value = data.description || '';
            document.getElementById('editProposalForm').action = data.update_url;

            const modal = new bootstrap.Modal(document.getElementById('editProposalModal'));
            modal.show();
        }
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            });
        </script>
    @endif

    @if ($errors->any() && old('title'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const createModal = new bootstrap.Modal(document.getElementById('createProposalModal'));
                createModal.show();
            });
        </script>
    @endif
</body>
</html>
