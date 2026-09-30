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

        .text-brand { color: var(--uya-dark-teal) !important; }
        .container-fluid { width: 100% !important; }

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
            gap: 0.4rem;
            max-width: 100%;
        }

        .info-pill span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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

        /* Custom Indicator Card Colors */
        .card-teal {
            background-color: #f0f7f9;
            border: 1px solid #cce3e8;
            color: #193a44;
        }
        .card-amber {
            background-color: #fefce8;
            border: 1px solid #fef08a;
            color: #854d0e;
        }

        .modal-sidebar-container {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
        }

        /* Top Right Quick Action Icon Buttons */
        .btn-action-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            font-size: 0.75rem;
            border: 1px solid transparent;
        }

        .btn-action-icon:hover {
            background-color: #f1f5f9;
            border-color: #cbd5e1;
        }

        /* Interactive Voting Card */
        .voting-compact-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 0.9rem;
        }

        .vote-btn-option {
            border: 1px solid transparent;
            border-radius: 8px;
            padding: 0.4rem 0.65rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #ffffff;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .vote-btn-yes {
            background-color: #e8f8f0;
            border-color: rgba(25, 135, 84, 0.25);
            color: #198754;
        }

        .vote-btn-yes:hover {
            background-color: #198754;
            color: #ffffff;
            border-color: #198754;
        }

        .vote-btn-no {
            background-color: #ffffff;
            border-color: rgba(220, 53, 69, 0.25);
            color: #dc3545;
        }

        .vote-btn-no:hover {
            background-color: #dc3545;
            color: #ffffff;
            border-color: #dc3545;
        }

        .vote-btn-disabled {
            cursor: default !important;
            opacity: 0.85;
        }

        .vote-btn-disabled:hover {
            background-color: initial !important;
            color: initial !important;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    @include('layouts.navbar')

    <div class="container-fluid py-4 px-3 px-md-4 px-lg-5" id="proposalsMainView">

        @php
            $isSubmissionAllowed = $activeCampaign ? $activeCampaign->isSubmissionAllowed() : true;
            $isVotingPhase = $activeCampaign ? $activeCampaign->isVotingPhase() : false;
            $isClosed = $activeCampaign ? $activeCampaign->isClosed() : false;
            $isOwnerModificationAllowed = $activeCampaign ? $activeCampaign->isOwnerModificationAllowed() : true;
            $effectivePhase = $activeCampaign->effective_phase ?? 'submission';
        @endphp

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h2 class="fw-bold mb-1 text-brand">Activity Proposals</h2>
            </div>

            <!-- Create Proposal Button with Phase Check -->
            @if($isSubmissionAllowed)
                <button type="button" data-bs-toggle="modal" data-bs-target="#createProposalModal"
                    class="btn rounded-pill px-4 py-2 fw-semibold custom-btn-filled d-flex align-items-center gap-2 shadow-sm"
                    style="font-size: 0.85rem;">
                    <i class="fa-solid fa-plus"></i> Create Proposal
                </button>
            @else
                <button type="button" disabled
                    class="btn rounded-pill px-4 py-2 fw-semibold btn-secondary d-flex align-items-center gap-2 shadow-sm opacity-75"
                    style="font-size: 0.85rem;" title="Submissions are currently closed for this campaign.">
                    <i class="fa-solid fa-lock"></i> Submissions Closed
                </button>
            @endif
        </div>

        <!-- Campaign Concluded Alert Banner when Closed -->
        @if($isClosed)
            <div class="alert alert-dark rounded-4 p-3 mb-4 d-flex align-items-center gap-3 border border-secondary shadow-sm">
                <i class="fa-solid fa-flag-checkered text-warning fs-4"></i>
                <div>
                    <h6 class="fw-bold mb-0 text-white" style="font-size: 0.95rem;">Campaign Concluded</h6>
                    <p class="mb-0 text-muted small">This proposal campaign has been officially concluded. Voting and new submissions are currently closed.</p>
                </div>
            </div>
        @endif

        <!-- Dynamic Workflow Banner with Phase-Based Deadlines -->
        <div class="card p-3 px-4 pastel-card mb-4 d-flex flex-row justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="text-brand fs-5"><i class="fa-solid fa-circle-info"></i></div>
                <div>
                    <h6 class="fw-bold text-brand mb-1.5" style="font-size: 0.95rem;">Proposal Workflow</h6>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="badge rounded-pill {{ $effectivePhase === 'submission' ? 'bg-primary text-white fw-bold shadow-sm' : 'bg-light text-dark border' }} px-3 py-1.5" style="font-size: 0.72rem;">Submission</span>
                        <span class="text-muted small">→</span>
                        <span class="badge rounded-pill {{ $effectivePhase === 'review' ? 'bg-primary text-white fw-bold shadow-sm' : 'bg-light text-dark border' }} px-3 py-1.5" style="font-size: 0.72rem;">Review & Revisions</span>
                        <span class="text-muted small">→</span>
                        <span class="badge rounded-pill {{ $effectivePhase === 'voting' ? 'bg-warning text-dark fw-bold shadow-sm' : 'bg-light text-dark border' }} px-3 py-1.5" style="font-size: 0.72rem;">Voting</span>
                        <span class="text-muted small">→</span>
                        <span class="badge rounded-pill {{ $effectivePhase === 'closed' ? 'bg-dark text-white fw-bold shadow-sm' : 'bg-light text-dark border' }} px-3 py-1.5" style="font-size: 0.72rem;">Closed</span>
                    </div>
                </div>
            </div>

            <!-- Dynamic Deadline Right Box -->
            <div class="bg-light border px-3.5 py-2 rounded-3 text-end ms-auto">
                @if($effectivePhase === 'submission')
                    <span class="text-muted d-block" style="font-size: 0.72rem;"><i class="fa-regular fa-clock me-1 text-primary"></i> Submission Deadline</span>
                    <span class="fw-bold text-brand" style="font-size: 0.88rem;">
                        {{ $activeCampaign?->submission_deadline ? $activeCampaign->submission_deadline->format('F j, Y') : 'N/A' }}
                    </span>
                @elseif($effectivePhase === 'review')
                    <span class="text-muted d-block" style="font-size: 0.72rem;"><i class="fa-solid fa-magnifying-glass me-1 text-info"></i> Review Phase</span>
                    <span class="fw-bold text-brand" style="font-size: 0.88rem;">Officer Reviewing Proposals</span>
                @elseif($effectivePhase === 'voting')
                    <span class="text-muted d-block" style="font-size: 0.72rem;"><i class="fa-regular fa-calendar-check me-1 text-warning"></i> Voting Deadline</span>
                    <span class="fw-bold text-brand" style="font-size: 0.88rem;">
                        {{ $activeCampaign?->voting_deadline ? $activeCampaign->voting_deadline->format('F j, Y') : 'Active' }}
                    </span>
                @else
                    <span class="text-muted d-block" style="font-size: 0.72rem;"><i class="fa-solid fa-flag-checkered me-1 text-secondary"></i> Status</span>
                    <span class="fw-bold text-dark" style="font-size: 0.88rem;">Concluded</span>
                @endif
            </div>
        </div>

        <!-- Horizontal Tabs -->
        <div class="mb-4">
            <ul class="nav nav-pills gap-2" id="proposalTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link shadow-sm {{ $tab === 'my-proposals' ? '' : 'active' }}" href="{{ route('proposals', ['tab' => 'proposals']) }}">
                        <i class="fa-solid fa-list-check me-1"></i> Proposals <span class="bg-white text-dark ms-1 rounded-pill px-2 py-0.5" style="font-size: 0.65rem;">{{ $proposalsCount }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link shadow-sm {{ $tab === 'my-proposals' ? 'active' : '' }}" href="{{ route('proposals', ['tab' => 'my-proposals']) }}">
                        <i class="fa-solid fa-user-pen me-1"></i> My Proposals <span class="bg-white text-dark ms-1 rounded-pill px-2 py-0.5" style="font-size: 0.65rem;">{{ $myProposalsCount }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Proposals List Grid -->
        <div class="row g-4 mb-4">
            @if($proposals->isEmpty())
                <div class="col-12">
                    <div class="card p-5 text-center pastel-card">
                        <i class="fa-regular fa-folder-open text-muted fs-1 mb-2"></i>
                        <p class="text-muted mb-0">No proposals found in this section.</p>
                    </div>
                </div>
            @else
                @foreach($proposals as $proposal)
                    @php
                        $userVote = $proposal->votes->where('user_id', auth()->id())->first();
                        $hasVoted = !is_null($userVote);
                        $isOwner = (int)$proposal->user_id === (int)auth()->id();
                        $canVote = $isVotingPhase && $proposal->status === 'active' && !$isOwner && !$hasVoted;
                    @endphp

                    <div class="col-xl-4 col-md-6">
                        <div class="card p-4 proposal-item shadow-sm h-100 d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <!-- Title & Clean Header Badge/Actions -->
                                <div class="d-flex justify-content-between align-items-center mb-2.5 gap-2">
                                    <h5 class="fw-bold mb-0 text-brand text-truncate" style="font-size: 1rem;">{{ $proposal->title }}</h5>

                                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-primary',
                                                'needs_revision' => 'bg-warning text-dark',
                                                'active' => 'bg-warning text-dark',
                                                'approved_for_execution' => 'bg-success text-white',
                                                'rejected' => 'bg-danger text-white',
                                                'completed' => 'bg-dark text-white',
                                                'archived' => 'bg-secondary text-white',
                                            ];
                                        @endphp
                                        <span class="badge rounded-pill px-2.5 py-1.5 fw-semibold {{ $statusClasses[$proposal->status] ?? 'bg-secondary' }}" style="font-size: 0.7rem;">
                                            {{ ucfirst(str_replace('_', ' ', $proposal->status)) }}
                                        </span>

                                        <!-- Member Action Dropdown -->
                                        @if($isOwner && $isOwnerModificationAllowed)
                                            <div class="dropdown d-inline">
                                                <button class="btn btn-action-icon text-secondary border-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical fs-6"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-3 border">
                                                    {{-- EDIT PROPOSAL IS ONLY ACCESSIBLE WHEN REVISION IS REQUESTED BY OFFICERS --}}
                                                    @if ($proposal->status === 'needs_revision')
                                                        <li>
                                                            <button class="dropdown-item py-1.5 small text-warning fw-semibold" onclick="openEditProposalModal({{ $proposal->id }})">
                                                                <i class="fa-regular fa-pen-to-square me-2"></i> Edit Proposal
                                                            </button>
                                                        </li>
                                                    @endif

                                                    @if ($proposal->status !== 'archived')
                                                        <li>
                                                            <button class="dropdown-item py-1.5 small" onclick="openArchiveProposalModal({{ $proposal->id }}, '{{ addslashes($proposal->title) }}')">
                                                                <i class="fa-solid fa-box-archive me-2 text-secondary"></i> Archive Proposal
                                                            </button>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <form method="POST" action="{{ url('/proposals/' . $proposal->id . '/restore') }}">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="dropdown-item py-1.5 small text-success fw-semibold">
                                                                    <i class="fa-solid fa-rotate-left me-2"></i> Restore Proposal
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif

                                                    @if (in_array($proposal->status, ['pending', 'needs_revision', 'rejected', 'archived']))
                                                        <li><hr class="dropdown-divider my-1"></li>
                                                        <li>
                                                            <button class="dropdown-item py-1.5 small text-danger fw-semibold" onclick="openDeleteProposalModal({{ $proposal->id }}, '{{ addslashes($proposal->title) }}')">
                                                                <i class="fa-regular fa-trash-can me-2"></i> Delete Proposal
                                                            </button>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Extended Description Area -->
                                <p class="text-muted small mb-3" style="font-size: 0.85rem; line-height: 1.5; min-height: 2.8em;">
                                    {{ Str::limit($proposal->description, 180) }}
                                </p>

                                <!-- Clean Structured Meta Info Grid -->
                                <div class="d-flex flex-column gap-2 mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="info-pill flex-grow-1" style="min-width: 0;">
                                            <i class="fa-regular fa-user text-secondary flex-shrink-0"></i>
                                            <span class="text-truncate">{{ $proposal->user->name ?? 'Unknown' }}</span>
                                        </div>
                                        <div class="info-pill flex-shrink-0">
                                            <i class="fa-regular fa-calendar text-secondary flex-shrink-0"></i>
                                            <span>{{ $proposal->proposed_date ? $proposal->proposed_date->format('M j') : 'TBD' }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="info-pill flex-grow-1" style="min-width: 0;">
                                            <i class="fa-solid fa-location-dot text-secondary flex-shrink-0"></i>
                                            <span class="text-truncate">{{ $proposal->location }}</span>
                                        </div>
                                        <div class="info-pill flex-shrink-0">
                                            <i class="fa-regular fa-clock text-secondary flex-shrink-0"></i>
                                            <span>{{ $proposal->duration }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Integrated Interactive Voting Summary -->
                                <div class="voting-compact-box">
                                    <div class="d-flex justify-content-between align-items-center mb-1.5" style="font-size: 0.75rem;">
                                        <span class="text-brand fw-bold">Voting Summary</span>
                                        <span class="text-muted" style="font-size: 0.7rem;">{{ $proposal->totalVotesCount() }} total votes</span>
                                    </div>

                                    <!-- Interactive Yes / No Vote Options -->
                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            @if($canVote)
                                                <button type="button" onclick="openFeedbackModal('yes', {{ $proposal->id }}, '{{ addslashes($proposal->title) }}')" class="vote-btn-option vote-btn-yes">
                                                    <span class="fw-semibold" style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-up me-1"></i> Yes</span>
                                                    <span class="fw-bold" style="font-size: 0.8rem;">{{ $proposal->yesVotesCount() }}</span>
                                                </button>
                                            @else
                                                <div class="vote-btn-option vote-btn-yes vote-btn-disabled">
                                                    <span class="fw-semibold" style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-up me-1"></i> Yes</span>
                                                    <span class="fw-bold" style="font-size: 0.8rem;">{{ $proposal->yesVotesCount() }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            @if($canVote)
                                                <button type="button" onclick="openFeedbackModal('no', {{ $proposal->id }}, '{{ addslashes($proposal->title) }}')" class="vote-btn-option vote-btn-no">
                                                    <span class="fw-semibold" style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-down me-1"></i> No</span>
                                                    <span class="fw-bold" style="font-size: 0.8rem;">{{ $proposal->noVotesCount() }}</span>
                                                </button>
                                            @else
                                                <div class="vote-btn-option vote-btn-no vote-btn-disabled">
                                                    <span class="fw-semibold" style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-down me-1"></i> No</span>
                                                    <span class="fw-bold" style="font-size: 0.8rem;">{{ $proposal->noVotesCount() }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <div class="progress flex-grow-1" style="height: 5px;">
                                            <div class="progress-bar bg-{{ $proposal->approvalRatePercentage() >= 60 ? 'success' : 'danger' }}" role="progressbar" style="width: {{ $proposal->approvalRatePercentage() }}%;"></div>
                                        </div>
                                        <span class="text-muted fw-bold" style="font-size: 0.68rem;">{{ $proposal->approvalRatePercentage() }}%</span>
                                    </div>

                                    <!-- Voting Prompt Helper Text -->
                                    <div class="text-center mt-1" style="font-size: 0.7rem;">
                                        @if($canVote)
                                            <span class="text-primary fw-semibold"><i class="fa-solid fa-hand-pointer me-1"></i> Click Yes or No above to cast your vote</span>
                                        @elseif($isOwner)
                                            <span class="text-muted"><i class="fa-solid fa-lock me-1"></i> Self-voting locked on your own proposal</span>
                                        @elseif($hasVoted)
                                            <span class="text-success fw-semibold"><i class="fa-solid fa-circle-check me-1"></i> You voted {{ strtoupper($userVote->vote_type) }}</span>
                                        @elseif(!$isVotingPhase)
                                            <span class="text-muted"><i class="fa-solid fa-clock-rotate-left me-1"></i> Voting is currently closed</span>
                                        @else
                                            <span class="text-muted">Voting is closed for this proposal</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Single Action Button -->
                            <div class="pt-2">
                                <a href="{{ route('proposals.show', $proposal->id) }}" class="btn btn-sm rounded-pill py-2 w-100 fw-semibold custom-btn-outline" style="font-size: 0.8rem;">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden JSON data for Edit Modal -->
                    <div id="proposalData-{{ $proposal->id }}" style="display: none;">
                        {!! json_encode([
                            'id' => $proposal->id,
                            'title' => $proposal->title,
                            'description' => $proposal->description,
                            'location' => $proposal->location,
                            'duration' => $proposal->duration,
                            'estimated_budget' => $proposal->estimated_budget,
                            'proposed_date' => $proposal->proposed_date ? $proposal->proposed_date->format('Y-m-d') : '',
                            'update_url' => route('proposals.update', $proposal->id),
                            'archive_url' => url('/proposals/' . $proposal->id . '/archive'),
                            'delete_url' => route('proposals.destroy', $proposal->id),
                        ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
                    </div>
                @endforeach
            @endif
        </div>

        {{ $proposals->links() }}
    </div>

    <!-- CREATE PROPOSAL MODAL -->
    <div class="modal fade" id="createProposalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 860px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3 p-md-3.5" style="background-color: #ffffff;">

                <div class="d-flex justify-content-between align-items-start border-bottom pb-2.5 mb-3">
                    <div>
                        <h5 class="fw-bold text-brand mb-0.5" style="font-size: 1.15rem;">Create New Proposal</h5>
                        <p class="text-muted mb-0" style="font-size: 0.78rem;">Submit a proposal for a new activity or program. Officers will review it first before it can move to voting.</p>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('proposals.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-lg-7">
                            <div class="mb-2.5">
                                <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.78rem;">Proposal Title *</label>
                                <input type="text" class="form-control rounded-3 py-1.5 px-2.5 shadow-none border" style="font-size: 0.82rem;" name="title" value="{{ old('title') }}" placeholder="e.g., Beach Cleanup Activity" required>
                            </div>

                            <div class="row g-2 mb-2.5">
                                <div class="col-md-6">
                                    <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.78rem;">Location *</label>
                                    <input type="text" class="form-control rounded-3 py-1.5 px-2.5 shadow-none border" style="font-size: 0.82rem;" name="location" value="{{ old('location') }}" placeholder="e.g., Silang, Cavite" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.78rem;">Duration *</label>
                                    <input type="text" class="form-control rounded-3 py-1.5 px-2.5 shadow-none border" style="font-size: 0.82rem;" name="duration" value="{{ old('duration') }}" placeholder="e.g., 3 hours, Half day, Full day" required>
                                </div>
                            </div>

                            <div class="row g-2 mb-2.5">
                                <div class="col-md-6">
                                    <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.78rem;">Budget *</label>
                                    <input type="number" step="0.01" class="form-control rounded-3 py-1.5 px-2.5 shadow-none border" style="font-size: 0.82rem;" name="estimated_budget" value="{{ old('estimated_budget') }}" placeholder="e.g., 15000" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.78rem;">Proposed Date *</label>
                                    <input type="date" id="createProposedDate" class="form-control rounded-3 py-1.5 px-2.5 shadow-none border" style="font-size: 0.82rem;" name="proposed_date" value="{{ old('proposed_date') }}"
                                        min="{{ $activeCampaign?->proposed_date_start ? $activeCampaign->proposed_date_start->format('Y-m-d') : '' }}"
                                        max="{{ $activeCampaign?->proposed_date_end ? $activeCampaign->proposed_date_end->format('Y-m-d') : '' }}"
                                        required>
                                </div>
                            </div>

                            <div class="mb-2.5">
                                <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.78rem;">Description *</label>
                                <textarea class="form-control rounded-3 p-2.5 shadow-none border" rows="4" style="font-size: 0.82rem; resize: none;" name="description" placeholder="Describe your proposal in detail..." required>{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-1">
                                <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.78rem;">Supporting Document *</label>
                                <input type="file" name="supporting_document" class="form-control rounded-3 py-1.5 px-2.5 shadow-none border" style="font-size: 0.82rem;" required>
                            </div>
                        </div>

                        <div class="col-lg-5 ps-lg-2">
                            <div class="p-3 modal-sidebar-container d-flex flex-column justify-content-between h-100">
                                <div class="d-flex flex-column gap-3">
                                    <div class="p-3 rounded-3 card-teal">
                                        <span class="fw-semibold d-block text-uppercase" style="font-size: 0.68rem;"><i class="fa-regular fa-clock me-1"></i> Submission Deadline</span>
                                        <span class="fw-bold d-block mt-1" style="font-size: 0.88rem;">{{ $activeCampaign?->submission_deadline ? $activeCampaign->submission_deadline->format('F j, Y') : 'N/A' }}</span>
                                    </div>
                                    <div class="p-3 rounded-3 card-amber">
                                        <span class="fw-semibold d-block text-uppercase" style="font-size: 0.68rem;"><i class="fa-regular fa-calendar-check me-1"></i> Voting Deadline</span>
                                        <span class="fw-bold d-block mt-1" style="font-size: 0.88rem;">
                                            {{ $activeCampaign?->voting_deadline ? $activeCampaign->voting_deadline->format('F j, Y') : 'To be set by Officers during Voting Phase' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2.5 mt-3 border-top">
                        <button type="button" class="btn btn-light border rounded-pill px-3.5 py-1.5 fw-semibold text-secondary" style="font-size: 0.8rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill px-4 py-1.5 fw-semibold text-white shadow-sm custom-btn-filled" style="font-size: 0.8rem;">Submit Proposal</button>
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
                        <input type="text" id="editTitle" name="title" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;" required>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Location *</label>
                            <input type="text" id="editLocation" name="location" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Duration *</label>
                            <input type="text" id="editDuration" name="duration" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Proposed Date *</label>
                            <input type="date" id="editDate" name="proposed_date" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Estimated Budget</label>
                            <input type="text" id="editBudget" name="estimated_budget" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Description *</label>
                        <textarea id="editDescription" name="description" class="form-control rounded-4 p-2.5 shadow-none border" rows="3" style="font-size: 0.85rem; resize: none;" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Supporting Document <span class="text-muted fw-normal">(optional)</span></label>
                        <input type="file" name="supporting_document" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;">
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <button type="button" class="btn btn-light border rounded-pill px-3 py-1.5 fw-semibold text-secondary" style="font-size: 0.8rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill px-3 py-1.5 fw-semibold text-dark shadow-sm" style="font-size: 0.8rem; background-color: var(--uya-gold);">Update Proposal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ARCHIVE PROPOSAL MODAL -->
    <div class="modal fade" id="archiveProposalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.05rem;"><i class="fa-solid fa-box-archive me-1 text-secondary"></i> Archive Proposal</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="py-2 text-secondary" style="font-size: 0.85rem;" id="archiveModalText">
                    Are you sure you want to archive this proposal? It will be hidden from the public feed.
                </div>
                <form id="archiveProposalForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <button type="button" class="btn btn-light border rounded-pill px-3 py-1.5 fw-semibold text-secondary" style="font-size: 0.8rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary rounded-pill px-3 py-1.5 fw-semibold shadow-sm" style="font-size: 0.8rem;">Archive Proposal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE PROPOSAL MODAL -->
    <div class="modal fade" id="deleteProposalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <h5 class="fw-bold text-danger mb-0" style="font-size: 1.05rem;"><i class="fa-solid fa-triangle-exclamation me-1"></i> Delete Proposal</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="py-2 text-secondary" style="font-size: 0.85rem;" id="deleteModalText">
                    Are you sure you want to delete this proposal?
                </div>
                <form id="deleteProposalForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <button type="button" class="btn btn-light border rounded-pill px-3 py-1.5 fw-semibold text-secondary" style="font-size: 0.8rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-3 py-1.5 fw-semibold shadow-sm" style="font-size: 0.8rem;">Delete Proposal</button>
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
                    <input type="hidden" name="vote_type" id="voteValue" value="">

                    <div class="p-2.5 rounded-3 mb-2 border bg-light" id="voteSelectionNotice" style="font-size: 0.8rem; line-height: 1.3;">
                        Add short feedback so the proposer can understand your vote.
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Thoughts on this proposal (Optional - Proposer only)</label>
                        <textarea name="feedback" class="form-control rounded-4 p-2.5 shadow-none border" rows="3" placeholder="Example: Great idea for local youth!" style="font-size: 0.85rem; resize: none;"></textarea>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openFeedbackModal(voteType, proposalId, proposalTitle) {
            const noticeBox = document.getElementById('voteSelectionNotice');
            const label = voteType === 'yes' ? 'YES' : 'NO';
            noticeBox.innerHTML = `You selected <strong>${label}</strong> on "${proposalTitle}". Add optional feedback for the proposer.`;

            document.getElementById('voteValue').value = voteType;
            document.getElementById('voteFeedbackForm').action = "{{ url('/proposals') }}/" + proposalId + "/vote";

            const modal = new bootstrap.Modal(document.getElementById('voteFeedbackModal'));
            modal.show();
        }

        function openEditProposalModal(proposalId) {
            const dataEl = document.getElementById('proposalData-' + proposalId);
            if (!dataEl) return;

            const data = JSON.parse(dataEl.textContent);

            document.getElementById('editTitle').value = data.title || '';
            document.getElementById('editLocation').value = data.location || '';
            document.getElementById('editDuration').value = data.duration || '';
            document.getElementById('editDate').value = data.proposed_date || '';
            document.getElementById('editBudget').value = data.estimated_budget || '';
            document.getElementById('editDescription').value = data.description || '';
            document.getElementById('editProposalForm').action = data.update_url;

            const modal = new bootstrap.Modal(document.getElementById('editProposalModal'));
            modal.show();
        }

        function openArchiveProposalModal(proposalId, proposalTitle) {
            const dataEl = document.getElementById('proposalData-' + proposalId);
            if (!dataEl) return;

            const data = JSON.parse(dataEl.textContent);

            document.getElementById('archiveModalText').innerHTML = `Are you sure you want to archive proposal "<strong>${proposalTitle}</strong>"? It will be hidden from the public feed.`;
            document.getElementById('archiveProposalForm').action = data.archive_url;

            const modal = new bootstrap.Modal(document.getElementById('archiveProposalModal'));
            modal.show();
        }

        function openDeleteProposalModal(proposalId, proposalTitle) {
            const dataEl = document.getElementById('proposalData-' + proposalId);
            if (!dataEl) return;

            const data = JSON.parse(dataEl.textContent);

            document.getElementById('deleteModalText').innerHTML = `Are you sure you want to permanently delete proposal "<strong>${proposalTitle}</strong>"? This action cannot be undone.`;
            document.getElementById('deleteProposalForm').action = data.delete_url;

            const modal = new bootstrap.Modal(document.getElementById('deleteProposalModal'));
            modal.show();
        }
    </script>
</body>
</html>
