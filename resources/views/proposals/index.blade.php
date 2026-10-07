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

        /* Primary Outer Liquid Glass Panels */
        .pastel-card,
        .proposal-item {
            background: rgba(255, 255, 255, 0.22) !important;
            border-radius: 18px !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08) !important;
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            border: 1px solid rgba(255, 255, 255, 0.45) !important;
            transition: all 0.25 ease;
        }

        .proposal-item:hover {
            border-color: rgba(255, 255, 255, 0.8) !important;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.12) !important;
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

        /* Liquid Glass Subcards inside primary cards */
        .glass-subcard {
            background: rgba(255, 255, 255, 0.45) !important;
            backdrop-filter: blur(6px) !important;
            -webkit-backdrop-filter: blur(6px) !important;
            border: 1px solid rgba(255, 255, 255, 0.7) !important;
            border-radius: 12px;
            padding: 0.6rem 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }

        .subcard-label {
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #475569;
            display: block;
            margin-bottom: 2px;
        }

        .subcard-value {
            font-size: 0.82rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0;
            line-height: 1.25;
        }

        /* Refined Buttons */
        .custom-btn-outline {
            border: 2px solid var(--uya-dark-teal);
            color: var(--uya-dark-teal);
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            text-align: center;
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
            box-shadow: 0 4px 12px rgba(34, 77, 91, 0.2);
            transition: background-color 0.2s ease;
        }

        .custom-btn-filled:hover {
            background-color: #193a44;
            color: #fff;
        }

        .card-teal {
            background-color: rgba(240, 247, 249, 0.8);
            border: 1px solid #cce3e8;
            color: #193a44;
        }
        .card-amber {
            background-color: rgba(254, 252, 232, 0.8);
            border: 1px solid #fef08a;
            color: #854d0e;
        }

        .modal-sidebar-container {
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 12px;
        }

        .btn-action-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            font-size: 0.72rem;
            border: 1px solid rgba(255, 255, 255, 0.8);
            background: rgba(255, 255, 255, 0.6);
        }

        .btn-action-icon:hover {
            background-color: #ffffff;
            border-color: #cbd5e1;
        }

        /* Voting Glass Container */
        .voting-compact-box {
            background: rgba(255, 255, 255, 0.45) !important;
            backdrop-filter: blur(6px) !important;
            -webkit-backdrop-filter: blur(6px) !important;
            border: 1px solid rgba(255, 255, 255, 0.7) !important;
            border-radius: 14px;
            padding: 0.75rem 0.85rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .vote-btn-option {
            border: 1px solid transparent;
            border-radius: 10px;
            padding: 0.4rem 0.6rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .vote-btn-yes {
            background-color: rgba(232, 248, 240, 0.85);
            border-color: rgba(25, 135, 84, 0.25);
            color: #15803d;
        }

        .vote-btn-yes:hover {
            background-color: #15803d;
            color: #ffffff;
            border-color: #15803d;
        }

        .vote-btn-no {
            background-color: rgba(255, 255, 255, 0.7);
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

        /* Glass Modal Popups */
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

    <!-- Navbar -->
    @include('layouts.navbar')

    <div class="app-container py-2 py-md-4" id="proposalsMainView">

        @php
            $isSubmissionAllowed = $activeCampaign ? $activeCampaign->isSubmissionAllowed() : true;
            $isVotingPhase = $activeCampaign ? $activeCampaign->isVotingPhase() : false;
            $isClosed = $activeCampaign ? $activeCampaign->isClosed() : false;
            $isOwnerModificationAllowed = $activeCampaign ? $activeCampaign->isOwnerModificationAllowed() : true;
            $effectivePhase = $activeCampaign->effective_phase ?? 'submission';
        @endphp

        <!-- Header: Top Title & Right Action Button -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-nowrap gap-2">
            <div>
                <h3 class="fw-bold mb-0 text-brand fs-4 fs-md-3">Activity Proposals</h3>
            </div>

            <!-- Create Proposal Button -->
            <div class="flex-shrink-0">
                @if($isSubmissionAllowed)
                    <button type="button" data-bs-toggle="modal" data-bs-target="#createProposalModal"
                        class="btn rounded-pill px-3 py-1.5 py-md-2 px-md-3.5 fw-bold custom-btn-filled d-flex align-items-center gap-1.5 shadow-sm"
                        style="font-size: 0.82rem;">
                        <i class="fa-solid fa-plus"></i> <span class="d-inline">Create Proposal</span>
                    </button>
                @else
                    <button type="button" disabled
                        class="btn rounded-pill px-3 py-1.5 py-md-2 px-md-3.5 fw-bold btn-secondary d-flex align-items-center gap-1.5 shadow-sm opacity-75"
                        style="font-size: 0.82rem;" title="Submissions are currently closed.">
                        <i class="fa-solid fa-lock"></i> <span>Closed</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- Campaign Concluded Alert Banner -->
        @if($isClosed)
            <div class="alert alert-dark rounded-4 p-3 mb-3 d-flex align-items-center gap-3 border border-secondary shadow-sm">
                <i class="fa-solid fa-flag-checkered text-warning fs-4"></i>
                <div>
                    <h6 class="fw-bold mb-0 text-white" style="font-size: 0.9rem;">Campaign Concluded</h6>
                    <p class="mb-0 text-white-50 small" style="font-size: 0.78rem;">This proposal campaign has been officially concluded. Voting and new submissions are closed.</p>
                </div>
            </div>
        @endif

        <!-- Proposal Workflow Banner -->
        <div class="card p-3 pastel-card mb-3">
            <div class="row align-items-center g-2">
                <div class="col-12 col-md-8">
                    <div class="d-flex align-items-center gap-2 mb-1.5">
                        <i class="fa-solid fa-circle-info text-brand"></i>
                        <h6 class="fw-bold text-brand mb-0" style="font-size: 0.9rem;">Proposal Workflow</h6>
                    </div>
                    <div class="d-flex align-items-center gap-1.5 flex-wrap overflow-x-auto pb-1">
                        <span class="badge rounded-pill {{ $effectivePhase === 'submission' ? 'bg-primary text-white fw-bold shadow-sm' : 'glass-subcard text-dark border-0 py-1' }} px-2.5 py-1" style="font-size: 0.68rem;">Submission</span>
                        <span class="text-dark small fw-bold">→</span>
                        <span class="badge rounded-pill {{ $effectivePhase === 'review' ? 'bg-primary text-white fw-bold shadow-sm' : 'glass-subcard text-dark border-0 py-1' }} px-2.5 py-1" style="font-size: 0.68rem;">Review</span>
                        <span class="text-dark small fw-bold">→</span>
                        <span class="badge rounded-pill {{ $effectivePhase === 'voting' ? 'bg-warning text-dark fw-bold shadow-sm' : 'glass-subcard text-dark border-0 py-1' }} px-2.5 py-1" style="font-size: 0.68rem;">Voting</span>
                        <span class="text-dark small fw-bold">→</span>
                        <span class="badge rounded-pill {{ $effectivePhase === 'closed' ? 'bg-dark text-white fw-bold shadow-sm' : 'glass-subcard text-dark border-0 py-1' }} px-2.5 py-1" style="font-size: 0.68rem;">Closed</span>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="glass-subcard px-2.5 py-1.5 text-md-end">
                        @if($effectivePhase === 'submission')
                            <span class="text-secondary fw-semibold d-block" style="font-size: 0.68rem;"><i class="fa-regular fa-clock me-1 text-primary"></i> Submission Deadline</span>
                            <span class="fw-bold text-brand" style="font-size: 0.82rem;">
                                {{ $activeCampaign?->submission_deadline ? $activeCampaign->submission_deadline->format('F j, Y') : 'N/A' }}
                            </span>
                        @elseif($effectivePhase === 'review')
                            <span class="text-secondary fw-semibold d-block" style="font-size: 0.68rem;"><i class="fa-solid fa-magnifying-glass me-1 text-info"></i> Review Phase</span>
                            <span class="fw-bold text-brand" style="font-size: 0.82rem;">Officer Reviewing Proposals</span>
                        @elseif($effectivePhase === 'voting')
                            <span class="text-secondary fw-semibold d-block" style="font-size: 0.68rem;"><i class="fa-regular fa-calendar-check me-1 text-warning"></i> Voting Deadline</span>
                            <span class="fw-bold text-brand" style="font-size: 0.82rem;">
                                {{ $activeCampaign?->voting_deadline ? $activeCampaign->voting_deadline->format('F j, Y') : 'Active' }}
                            </span>
                        @else
                            <span class="text-secondary fw-semibold d-block" style="font-size: 0.68rem;"><i class="fa-solid fa-flag-checkered me-1 text-secondary"></i> Status</span>
                            <span class="fw-bold text-dark" style="font-size: 0.82rem;">Concluded</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs Bar -->
        <div class="mb-4">
            <!-- Mobile Segmented Toggle (< 768px) -->
            <div class="mobile-segmented-toggle">
                <a href="{{ route('proposals', ['tab' => 'proposals']) }}" class="segmented-btn {{ $tab === 'my-proposals' ? '' : 'active' }}">
                    <i class="fa-solid fa-list-check"></i> Proposals ({{ $proposalsCount }})
                </a>
                <a href="{{ route('proposals', ['tab' => 'my-proposals']) }}" class="segmented-btn {{ $tab === 'my-proposals' ? 'active' : '' }}">
                    <i class="fa-solid fa-user-pen"></i> My Proposals ({{ $myProposalsCount }})
                </a>
            </div>

            <!-- Desktop Pill Tabs (>= 768px) -->
            <div class="desktop-nav-pills nav nav-pills gap-2 w-100">
                <a href="{{ route('proposals', ['tab' => 'proposals']) }}" class="nav-link {{ $tab === 'my-proposals' ? '' : 'active' }}">
                    <i class="fa-solid fa-list-check me-1"></i> Proposals <span class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">{{ $proposalsCount }}</span>
                </a>
                <a href="{{ route('proposals', ['tab' => 'my-proposals']) }}" class="nav-link {{ $tab === 'my-proposals' ? 'active' : '' }}">
                    <i class="fa-solid fa-user-pen me-1"></i> My Proposals <span class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">{{ $myProposalsCount }}</span>
                </a>
            </div>
        </div>

        <!-- Proposals List Grid -->
        <div class="row g-3 mb-4">
            @if($proposals->isEmpty())
                <div class="col-12">
                    <div class="card p-4 text-center pastel-card">
                        <i class="fa-regular fa-folder-open text-brand opacity-75 fs-2 mb-2"></i>
                        <p class="text-dark fw-semibold small mb-0">No proposals found in this section.</p>
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

                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card p-3 p-md-3.5 proposal-item shadow-sm h-100 d-flex flex-column justify-content-between">
                            <div>

                                <!-- Card Header: Pinned Status & Action Bar -->
                                <div class="d-flex justify-content-between align-items-center mb-2 gap-2">
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
                                    <span class="badge rounded-pill px-2.5 py-1.5 fw-bold {{ $statusClasses[$proposal->status] ?? 'bg-secondary' }}" style="font-size: 0.68rem;">
                                        {{ ucfirst(str_replace('_', ' ', $proposal->status)) }}
                                    </span>

                                    @if($isOwner && $isOwnerModificationAllowed)
                                        <div class="dropdown d-inline">
                                            <button class="btn btn-action-icon text-dark p-0 shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-3 border">
                                                @if ($proposal->status === 'needs_revision')
                                                    <li>
                                                        <button class="dropdown-item py-1.5 small text-warning fw-bold" onclick="openEditProposalModal({{ $proposal->id }})">
                                                            <i class="fa-regular fa-pen-to-square me-2"></i> Edit Proposal
                                                        </button>
                                                    </li>
                                                @endif

                                                @if ($proposal->status !== 'archived')
                                                    <li>
                                                        <button class="dropdown-item py-1.5 small text-dark fw-semibold" onclick="openArchiveProposalModal({{ $proposal->id }}, '{{ addslashes($proposal->title) }}')">
                                                            <i class="fa-solid fa-box-archive me-2 text-secondary"></i> Archive
                                                        </button>
                                                    </li>
                                                @else
                                                    <li>
                                                        <form method="POST" action="{{ url('/proposals/' . $proposal->id . '/restore') }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="dropdown-item py-1.5 small text-success fw-bold">
                                                                <i class="fa-solid fa-rotate-left me-2"></i> Restore
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif

                                                @if (in_array($proposal->status, ['pending', 'needs_revision', 'rejected', 'archived']))
                                                    <li><hr class="dropdown-divider my-1"></li>
                                                    <li>
                                                        <button class="dropdown-item py-1.5 small text-danger fw-bold" onclick="openDeleteProposalModal({{ $proposal->id }}, '{{ addslashes($proposal->title) }}')">
                                                            <i class="fa-regular fa-trash-can me-2"></i> Delete
                                                        </button>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                <!-- Full Width Title -->
                                <h5 class="fw-bold mb-2 text-brand text-wrap" style="font-size: 1rem; line-height: 1.35;">{{ $proposal->title }}</h5>

                                <p class="text-dark small mb-3 fw-medium" style="font-size: 0.8rem; line-height: 1.45;">
                                    {{ Str::limit($proposal->description, 130) }}
                                </p>

                                <!-- Clean Liquid Glass 2x2 Sub-Cards Grid -->
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div class="glass-subcard h-100">
                                            <span class="subcard-label">PROPOSER</span>
                                            <div class="subcard-value d-flex align-items-center gap-1.5 overflow-hidden">
                                                <i class="fa-regular fa-user text-brand flex-shrink-0"></i>
                                                <span class="text-truncate">{{ $proposal->user->name ?? 'Unknown' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="glass-subcard h-100">
                                            <span class="subcard-label">DATE</span>
                                            <div class="subcard-value d-flex align-items-center gap-1.5">
                                                <i class="fa-regular fa-calendar text-brand flex-shrink-0"></i>
                                                <span>{{ $proposal->proposed_date ? $proposal->proposed_date->format('M j') : 'TBD' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="glass-subcard h-100">
                                            <span class="subcard-label">LOCATION</span>
                                            <div class="subcard-value d-flex align-items-center gap-1.5 overflow-hidden">
                                                <i class="fa-solid fa-location-dot text-brand flex-shrink-0"></i>
                                                <span class="text-truncate" title="{{ $proposal->location }}">{{ $proposal->location }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="glass-subcard h-100">
                                            <span class="subcard-label">DURATION</span>
                                            <div class="subcard-value d-flex align-items-center gap-1.5 overflow-hidden">
                                                <i class="fa-regular fa-clock text-brand flex-shrink-0"></i>
                                                <span class="text-truncate">{{ $proposal->duration }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Integrated Liquid Glass Voting Card -->
                                <div class="voting-compact-box mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 0.72rem;">
                                        <span class="text-brand fw-bold">Voting Summary</span>
                                        <span class="text-dark fw-semibold">{{ $proposal->totalVotesCount() }} total votes</span>
                                    </div>

                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            @if($canVote)
                                                <button type="button" onclick="openFeedbackModal('yes', {{ $proposal->id }}, '{{ addslashes($proposal->title) }}')" class="vote-btn-option vote-btn-yes fw-bold">
                                                    <span style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-up me-1"></i> Yes</span>
                                                    <span style="font-size: 0.82rem;">{{ $proposal->yesVotesCount() }}</span>
                                                </button>
                                            @else
                                                <div class="vote-btn-option vote-btn-yes vote-btn-disabled fw-bold">
                                                    <span style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-up me-1"></i> Yes</span>
                                                    <span style="font-size: 0.82rem;">{{ $proposal->yesVotesCount() }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            @if($canVote)
                                                <button type="button" onclick="openFeedbackModal('no', {{ $proposal->id }}, '{{ addslashes($proposal->title) }}')" class="vote-btn-option vote-btn-no fw-bold">
                                                    <span style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-down me-1"></i> No</span>
                                                    <span style="font-size: 0.82rem;">{{ $proposal->noVotesCount() }}</span>
                                                </button>
                                            @else
                                                <div class="vote-btn-option vote-btn-no vote-btn-disabled fw-bold">
                                                    <span style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-down me-1"></i> No</span>
                                                    <span style="font-size: 0.82rem;">{{ $proposal->noVotesCount() }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 mb-1.5">
                                        <div class="progress flex-grow-1" style="height: 5px;">
                                            <div class="progress-bar bg-{{ $proposal->approvalRatePercentage() >= 60 ? 'success' : 'danger' }}" role="progressbar" style="width: {{ $proposal->approvalRatePercentage() }}%;"></div>
                                        </div>
                                        <span class="text-dark fw-bold" style="font-size: 0.68rem;">{{ $proposal->approvalRatePercentage() }}%</span>
                                    </div>

                                    <div class="text-center mt-1" style="font-size: 0.68rem;">
                                        @if($canVote)
                                            <span class="text-primary fw-bold"><i class="fa-solid fa-hand-pointer me-1"></i> Click Yes or No above to vote</span>
                                        @elseif($isOwner)
                                            <span class="text-dark fw-semibold"><i class="fa-solid fa-lock me-1"></i> Self-voting locked</span>
                                        @elseif($hasVoted)
                                            <span class="text-success fw-bold"><i class="fa-solid fa-circle-check me-1"></i> You voted {{ strtoupper($userVote->vote_type) }}</span>
                                        @else
                                            <span class="text-dark fw-semibold">Voting closed</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Single Action Button -->
                            <div>
                                <a href="{{ route('proposals.show', $proposal->id) }}" class="btn btn-sm rounded-pill py-2 w-100 custom-btn-outline" style="font-size: 0.82rem;">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>

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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3 p-md-4 glass-modal-content">

                <div class="d-flex justify-content-between align-items-start border-bottom pb-2.5 mb-3 border-secondary border-opacity-10">
                    <div>
                        <h5 class="fw-bold text-brand mb-0.5" style="font-size: 1.1rem;">Create New Proposal</h5>
                        <p class="text-dark fw-semibold mb-0" style="font-size: 0.78rem;">Submit a proposal for a new activity or program.</p>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('proposals.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-2.5">
                        <div class="col-12 col-lg-7">
                            <div class="mb-2">
                                <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.78rem;">Proposal Title *</label>
                                <input type="text" class="form-control rounded-3 py-1.5 px-2.5 shadow-none border bg-light" style="font-size: 0.82rem;" name="title" value="{{ old('title') }}" placeholder="e.g., Beach Cleanup Activity" required>
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.78rem;">Location *</label>
                                    <input type="text" class="form-control rounded-3 py-1.5 px-2.5 shadow-none border bg-light" style="font-size: 0.82rem;" name="location" value="{{ old('location') }}" placeholder="e.g., Silang, Cavite" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.78rem;">Duration *</label>
                                    <input type="text" class="form-control rounded-3 py-1.5 px-2.5 shadow-none border bg-light" style="font-size: 0.82rem;" name="duration" value="{{ old('duration') }}" placeholder="e.g., 3 hours" required>
                                </div>
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.78rem;">Budget *</label>
                                    <input type="number" step="0.01" class="form-control rounded-3 py-1.5 px-2.5 shadow-none border bg-light" style="font-size: 0.82rem;" name="estimated_budget" value="{{ old('estimated_budget') }}" placeholder="e.g., 15000" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.78rem;">Proposed Date *</label>
                                    <input type="date" id="createProposedDate" class="form-control rounded-3 py-1.5 px-2.5 shadow-none border bg-light" style="font-size: 0.82rem;" name="proposed_date" value="{{ old('proposed_date') }}"
                                        min="{{ $activeCampaign?->proposed_date_start ? $activeCampaign->proposed_date_start->format('Y-m-d') : '' }}"
                                        max="{{ $activeCampaign?->proposed_date_end ? $activeCampaign->proposed_date_end->format('Y-m-d') : '' }}"
                                        required>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.78rem;">Description *</label>
                                <textarea class="form-control rounded-3 p-2.5 shadow-none border bg-light" rows="3" style="font-size: 0.82rem; resize: none;" name="description" placeholder="Describe your proposal in detail..." required>{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-2">
                                <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.78rem;">Supporting Document *</label>
                                <input type="file" name="supporting_document" class="form-control rounded-3 py-1.5 px-2.5 shadow-none border bg-light" style="font-size: 0.82rem;" required>
                            </div>
                        </div>

                        <div class="col-12 col-lg-5">
                            <div class="p-3 modal-sidebar-container d-flex flex-column gap-2 h-100">
                                <div class="p-2.5 rounded-3 card-teal">
                                    <span class="fw-bold d-block text-uppercase" style="font-size: 0.65rem;"><i class="fa-regular fa-clock me-1"></i> SUBMISSION DEADLINE</span>
                                    <span class="fw-bold d-block mt-0.5" style="font-size: 0.82rem;">{{ $activeCampaign?->submission_deadline ? $activeCampaign->submission_deadline->format('F j, Y') : 'N/A' }}</span>
                                </div>
                                <div class="p-2.5 rounded-3 card-amber">
                                    <span class="fw-bold d-block text-uppercase" style="font-size: 0.65rem;"><i class="fa-regular fa-calendar-check me-1"></i> VOTING DEADLINE</span>
                                    <span class="fw-bold d-block mt-0.5" style="font-size: 0.82rem;">
                                        {{ $activeCampaign?->voting_deadline ? $activeCampaign->voting_deadline->format('F j, Y') : 'Set during Voting Phase' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2.5 mt-2 border-top border-secondary border-opacity-10">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.8rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill px-4 py-1.5 fw-bold text-white shadow-sm custom-btn-filled" style="font-size: 0.8rem;">Submit Proposal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT PROPOSAL MODAL -->
    <div class="modal fade" id="editProposalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 620px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3 glass-modal-content">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2 border-secondary border-opacity-10">
                    <h5 class="fw-bold text-brand mb-0" style="font-size: 1.05rem;">Edit Proposal</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="editProposalForm" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-2">
                        <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Proposal Title *</label>
                        <input type="text" id="editTitle" name="title" class="form-control rounded-pill py-1.5 px-3 shadow-none border bg-light" style="font-size: 0.85rem;" required>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Location *</label>
                            <input type="text" id="editLocation" name="location" class="form-control rounded-pill py-1.5 px-3 shadow-none border bg-light" style="font-size: 0.85rem;" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Duration *</label>
                            <input type="text" id="editDuration" name="duration" class="form-control rounded-pill py-1.5 px-3 shadow-none border bg-light" style="font-size: 0.85rem;" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Proposed Date *</label>
                            <input type="date" id="editDate" name="proposed_date" class="form-control rounded-pill py-1.5 px-3 shadow-none border bg-light" style="font-size: 0.85rem;" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Estimated Budget</label>
                            <input type="text" id="editBudget" name="estimated_budget" class="form-control rounded-pill py-1.5 px-3 shadow-none border bg-light" style="font-size: 0.85rem;">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Description *</label>
                        <textarea id="editDescription" name="description" class="form-control rounded-4 p-2.5 shadow-none border bg-light" rows="3" style="font-size: 0.85rem; resize: none;" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Supporting Document <span class="text-secondary fw-semibold">(optional)</span></label>
                        <input type="file" name="supporting_document" class="form-control rounded-pill py-1.5 px-3 shadow-none border bg-light" style="font-size: 0.85rem;">
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2 border-top border-secondary border-opacity-10">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.8rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill px-3 py-1.5 fw-bold text-dark shadow-sm" style="font-size: 0.8rem; background-color: var(--uya-gold);">Update Proposal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ARCHIVE PROPOSAL MODAL -->
    <div class="modal fade" id="archiveProposalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3 glass-modal-content">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2 border-secondary border-opacity-10">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.05rem;"><i class="fa-solid fa-box-archive me-1 text-secondary"></i> Archive Proposal</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="py-2 text-dark fw-medium" style="font-size: 0.85rem;" id="archiveModalText">
                    Are you sure you want to archive this proposal? It will be hidden from the public feed.
                </div>
                <form id="archiveProposalForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top border-secondary border-opacity-10">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.8rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary rounded-pill px-3 py-1.5 fw-bold shadow-sm" style="font-size: 0.8rem;">Archive Proposal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE PROPOSAL MODAL -->
    <div class="modal fade" id="deleteProposalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3 glass-modal-content">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2 border-secondary border-opacity-10">
                    <h5 class="fw-bold text-danger mb-0" style="font-size: 1.05rem;"><i class="fa-solid fa-triangle-exclamation me-1"></i> Delete Proposal</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="py-2 text-dark fw-medium" style="font-size: 0.85rem;" id="deleteModalText">
                    Are you sure you want to delete this proposal?
                </div>
                <form id="deleteProposalForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top border-secondary border-opacity-10">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.8rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-3 py-1.5 fw-bold shadow-sm" style="font-size: 0.8rem;">Delete Proposal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- VOTE FEEDBACK MODAL -->
    <div class="modal fade" id="voteFeedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3 glass-modal-content">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2 border-secondary border-opacity-10">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.05rem;">Share your thoughts</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="voteFeedbackForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="vote_type" id="voteValue" value="">

                    <div class="p-2.5 rounded-3 mb-2 border bg-light text-dark fw-semibold" id="voteSelectionNotice" style="font-size: 0.8rem; line-height: 1.3;">
                        Add short feedback so the proposer can understand your vote.
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Thoughts on this proposal (Optional - Proposer only)</label>
                        <textarea name="feedback" class="form-control rounded-4 p-2.5 shadow-none border bg-light" rows="3" placeholder="Example: Great idea for local youth!" style="font-size: 0.85rem; resize: none;"></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary rounded-pill py-1.5 w-50 fw-bold" style="font-size: 0.8rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill py-1.5 w-50 fw-bold text-white shadow-sm d-flex align-items-center justify-content-center gap-1.5" style="font-size: 0.8rem; background-color: var(--uya-dark-teal);">
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
