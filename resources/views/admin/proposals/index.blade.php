@extends('layouts.admin')

@section('title', 'Manage Proposals - Admin Dashboard')

@section('content')
    <div class="container-fluid p-0">

        @php
            $effectivePhase = $activeCampaign->effective_phase ?? 'submission';
        @endphp

        <!-- Compact Unified Campaign Phase & Workflow Header Bar -->
        <div class="card p-3 border-0 mb-3" style="background-color: var(--admin-card-bg); border-radius: 12px;">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pb-2 mb-2.5 border-bottom border-white border-opacity-10">
                <!-- Left: Title & Workflow Steps -->
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-regular fa-clock text-primary"></i>
                        <h6 class="fw-bold text-white mb-0" style="font-size: 0.92rem;">Campaign Workflow Phase:</h6>
                    </div>

                    <!-- Highlighted Workflow Guide Steps -->
                    <div class="d-flex align-items-center gap-1.5 flex-wrap">
                        <span class="badge rounded-pill {{ $effectivePhase === 'submission' ? 'bg-primary text-white shadow-sm fw-bold' : 'bg-dark text-muted border border-secondary opacity-50' }} px-2.5 py-1" style="font-size: 0.7rem;">
                            1. Submission
                        </span>
                        <span class="text-muted" style="font-size: 0.65rem;">→</span>
                        <span class="badge rounded-pill {{ $effectivePhase === 'review' ? 'bg-primary text-white shadow-sm fw-bold' : 'bg-dark text-muted border border-secondary opacity-50' }} px-2.5 py-1" style="font-size: 0.7rem;">
                            2. Review & Revisions
                        </span>
                        <span class="text-muted" style="font-size: 0.65rem;">→</span>
                        <span class="badge rounded-pill {{ $effectivePhase === 'voting' ? 'bg-warning text-dark shadow-sm fw-bold' : 'bg-dark text-muted border border-secondary opacity-50' }} px-2.5 py-1" style="font-size: 0.7rem;">
                            3. Member Voting
                        </span>
                        <span class="text-muted" style="font-size: 0.65rem;">→</span>
                        <span class="badge rounded-pill {{ $effectivePhase === 'closed' ? 'bg-danger text-white shadow-sm fw-bold' : 'bg-dark text-muted border border-secondary opacity-50' }} px-2.5 py-1" style="font-size: 0.7rem;">
                            4. Closed & Concluded
                        </span>
                    </div>
                </div>

                <!-- Right: Action Button -->
                <button type="button" data-bs-toggle="modal" data-bs-target="#scheduleModal"
                    class="btn btn-xs btn-outline-light rounded-pill px-3 py-1" style="font-size: 0.78rem;">
                    <i class="fa-solid fa-gear me-1"></i> Edit Schedule & Overrides
                </button>
            </div>

            <!-- Compact Metrics Grid -->
            <div class="row g-2">
                <div class="col-md-3 col-6">
                    <div class="p-2 px-3 rounded-3 d-flex justify-content-between align-items-center" style="background-color: #0f172a; border: 1px solid var(--admin-border);">
                        <span class="text-muted small">Active Phase:</span>
                        <span class="badge {{ $effectivePhase === 'voting' ? 'bg-warning text-dark' : 'bg-primary' }} rounded-pill px-2.5 py-1" style="font-size: 0.72rem;">
                            {{ ucfirst($effectivePhase) }}
                            @if($activeCampaign?->is_submission_override === true)
                                <span class="fw-normal opacity-75">(Force Open)</span>
                            @elseif($activeCampaign?->is_submission_override === false)
                                <span class="fw-normal opacity-75">(Force Closed)</span>
                            @endif
                        </span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-2 px-3 rounded-3 d-flex justify-content-between align-items-center" style="background-color: #0f172a; border: 1px solid var(--admin-border);">
                        <span class="text-muted small">Submissions Cutoff:</span>
                        <span class="fw-bold text-white small">{{ $activeCampaign?->submission_deadline ? $activeCampaign->submission_deadline->format('M j, Y') : 'N/A' }}</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-2 px-3 rounded-3 d-flex justify-content-between align-items-center" style="background-color: #0f172a; border: 1px solid var(--admin-border);">
                        <span class="text-muted small">Voting Deadline:</span>
                        <span class="fw-bold text-white small">{{ $activeCampaign?->voting_deadline ? $activeCampaign->voting_deadline->format('M j, Y') : 'Not set' }}</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-2 px-3 rounded-3 d-flex justify-content-between align-items-center" style="background-color: #0f172a; border: 1px solid var(--admin-border);">
                        <span class="text-muted small">Voting Target:</span>
                        <span class="fw-bold text-white small">{{ $activeCampaign->required_yes_votes ?? 0 }}/{{ $activeCampaign->total_voters_target ?? 0 }} Yes ({{ number_format($activeCampaign->required_approval_rate ?? 60, 0) }}%)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Filter Tabs -->
        <div class="mb-3">
            <ul class="nav nav-pills gap-2">
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 py-1.5 {{ $tab === 'pending' ? 'active bg-primary' : 'text-subtle' }}"
                        href="{{ route('admin.proposals.index', ['tab' => 'pending']) }}">
                        Pending Review <span class="badge bg-dark text-white ms-1 rounded-circle">{{ $pendingCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 py-1.5 {{ $tab === 'needs-revision' ? 'active bg-primary' : 'text-subtle' }}"
                        href="{{ route('admin.proposals.index', ['tab' => 'needs-revision']) }}">
                        Revision Requested <span class="badge bg-dark text-white ms-1 rounded-circle">{{ $revisionCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 py-1.5 {{ $tab === 'approved' ? 'active bg-primary' : 'text-subtle' }}"
                        href="{{ route('admin.proposals.index', ['tab' => 'approved']) }}">
                        Approved for Voting / Executed <span class="badge bg-dark text-white ms-1 rounded-circle">{{ $approvedCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 py-1.5 {{ $tab === 'rejected' ? 'active bg-primary' : 'text-subtle' }}"
                        href="{{ route('admin.proposals.index', ['tab' => 'rejected']) }}">
                        Rejected <span class="badge bg-dark text-white ms-1 rounded-circle">{{ $rejectedCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 py-1.5 {{ $tab === 'archived' ? 'active bg-secondary' : 'text-subtle' }}"
                        href="{{ route('admin.proposals.index', ['tab' => 'archived']) }}">
                        Archived <span class="badge bg-dark text-white ms-1 rounded-circle">{{ $archivedCount }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Proposals List -->
        <div class="row g-3 mb-4">
            @forelse ($proposals as $proposal)
                <div class="col-12">
                    <div class="card p-3 border-0" style="background-color: var(--admin-card-bg); border-radius: 12px;">
                        <div class="row g-3 align-items-center">
                            <div class="col-lg-8">
                                <div class="d-flex align-items-center gap-2 mb-1.5">
                                    <h5 class="fw-bold text-white mb-0" style="font-size: 1.02rem;">{{ $proposal->title }}</h5>
                                    <span class="badge {{ $proposal->status === 'archived' ? 'bg-secondary' : 'bg-primary' }} rounded-pill">{{ ucfirst(str_replace('_', ' ', $proposal->status)) }}</span>
                                    @if ($proposal->is_document_validated)
                                        <span class="badge bg-success rounded-pill"><i class="fa-solid fa-check-circle me-1"></i> Document Validated</span>
                                    @endif
                                </div>
                                <p class="text-subtle small mb-2 text-truncate" style="max-width: 90%;">{{ $proposal->description }}</p>

                                <div class="d-flex flex-wrap gap-3 text-muted small" style="font-size: 0.78rem;">
                                    <span><i class="fa-regular fa-user me-1"></i> {{ $proposal->user->name ?? 'Unknown' }}</span>
                                    <span><i class="fa-solid fa-location-dot me-1"></i> {{ $proposal->location }}</span>
                                    <span><i class="fa-regular fa-clock me-1"></i> {{ $proposal->duration }}</span>
                                    <span><i class="fa-regular fa-calendar me-1"></i> {{ $proposal->proposed_date ? $proposal->proposed_date->format('M j, Y') : 'TBD' }}</span>
                                    <span><i class="fa-solid fa-coins me-1"></i> ₱{{ number_format($proposal->estimated_budget, 2) }}</span>
                                </div>
                            </div>

                            <!-- Actions Area -->
                            <div class="col-lg-4 border-start border-white border-opacity-10 ps-lg-4 d-flex align-items-center justify-content-end gap-2">
                                <a href="{{ route('admin.proposals.show', $proposal->id) }}"
                                    class="btn btn-sm btn-outline-light rounded-3 px-3 py-1.5" style="font-size: 0.82rem;">
                                    <i class="fa-regular fa-eye me-1"></i> View Details
                                </a>

                                @if (in_array($proposal->status, ['pending', 'needs_revision']))
                                    <button type="button" class="btn btn-sm btn-primary rounded-3 px-3 py-1.5 fw-semibold" style="font-size: 0.82rem;"
                                        onclick="openAdminApproveModal({{ $proposal->id }}, '{{ addslashes($proposal->title) }}')">
                                        <i class="fa-solid fa-check me-1"></i> Approve
                                    </button>
                                @elseif($proposal->status === 'active' || $proposal->status === 'approved_for_execution')
                                    <button type="button" class="btn btn-sm btn-success rounded-3 px-3 py-1.5 fw-bold" style="font-size: 0.82rem;"
                                        onclick="openAdminConvertModal({{ $proposal->id }}, '{{ addslashes($proposal->title) }}')">
                                        <i class="fa-solid fa-rocket me-1"></i> Convert to Activity
                                    </button>
                                @endif

                                <!-- Secondary Actions Dropdown -->
                                <div class="dropdown d-inline">
                                    <button class="btn btn-sm btn-outline-secondary text-white border-0 rounded-3 px-2 py-1.5"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false" title="More Actions">
                                        <i class="fa-solid fa-ellipsis-vertical fs-6"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg"
                                        style="background-color: #1e293b; border: 1px solid var(--admin-border);">
                                        @if (in_array($proposal->status, ['pending', 'needs_revision']))
                                            <li>
                                                <button class="dropdown-menu-item dropdown-item text-warning py-2 small"
                                                    onclick="openRevisionModal({{ $proposal->id }})">
                                                    <i class="fa-regular fa-comment-dots me-2"></i> Request Revision
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button"
                                                    class="dropdown-menu-item dropdown-item text-danger py-2 small"
                                                    onclick="openAdminRejectModal({{ $proposal->id }}, '{{ addslashes($proposal->title) }}')">
                                                    <i class="fa-solid fa-xmark me-2"></i> Reject Proposal
                                                </button>
                                            </li>
                                            <li><hr class="dropdown-divider border-secondary opacity-25"></li>
                                        @endif

                                        @if ($proposal->status !== 'archived')
                                            <li>
                                                <button class="dropdown-menu-item dropdown-item text-light py-2 small"
                                                    onclick="openAdminArchiveModal({{ $proposal->id }}, '{{ addslashes($proposal->title) }}')">
                                                    <i class="fa-solid fa-box-archive me-2 text-muted"></i> Archive Proposal
                                                </button>
                                            </li>
                                        @else
                                            <li>
                                                <form method="POST" action="{{ route('admin.proposals.restore', $proposal->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="dropdown-menu-item dropdown-item text-success py-2 small fw-bold">
                                                        <i class="fa-solid fa-rotate-left me-2"></i> Restore Proposal
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                        @if (in_array($proposal->status, ['rejected', 'archived']))
                                            <li>
                                                <button type="button"
                                                    class="dropdown-menu-item dropdown-item text-danger py-2 small fw-bold"
                                                    onclick="openAdminDeleteModal({{ $proposal->id }}, '{{ addslashes($proposal->title) }}')">
                                                    <i class="fa-regular fa-trash-can me-2"></i> Delete Proposal
                                                </button>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    <i class="fa-regular fa-folder-open fs-1 mb-2 d-block opacity-50"></i>
                    <p class="mb-0">No proposals found in this tab queue.</p>
                </div>
            @endforelse
        </div>

        {{ $proposals->links() }}
    </div>

    <!-- EDIT SCHEDULE MODAL -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-white p-3" style="background-color: var(--admin-card-bg); border-radius: 14px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-sliders text-primary me-2"></i>Campaign Phase & Schedule Settings</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.proposals.updateSchedule') }}">
                    @csrf
                    <div class="modal-body py-3">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Active Phase *</label>
                            <select name="current_phase" class="form-select bg-dark text-white border-secondary rounded-pill py-2 px-3">
                                <option value="submission" {{ ($activeCampaign->current_phase ?? '') === 'submission' ? 'selected' : '' }}>1. Submission Phase</option>
                                <option value="review" {{ ($activeCampaign->current_phase ?? '') === 'review' ? 'selected' : '' }}>2. Review Phase</option>
                                <option value="voting" {{ ($activeCampaign->current_phase ?? '') === 'voting' ? 'selected' : '' }}>3. Voting Phase (Manual Trigger)</option>
                                <option value="closed" {{ ($activeCampaign->current_phase ?? '') === 'closed' ? 'selected' : '' }}>4. Closed Phase</option>
                            </select>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted small fw-bold">Submission Deadline *</label>
                                <input type="date" name="submission_deadline" class="form-control bg-dark text-white border-secondary rounded-pill py-2 px-3"
                                    value="{{ $activeCampaign?->submission_deadline ? $activeCampaign->submission_deadline->format('Y-m-d') : '' }}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted small fw-bold">Voting Deadline <span class="fw-normal text-muted">(Optional)</span></label>
                                <input type="date" name="voting_deadline" class="form-control bg-dark text-white border-secondary rounded-pill py-2 px-3"
                                    value="{{ $activeCampaign?->voting_deadline ? $activeCampaign->voting_deadline->format('Y-m-d') : '' }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Required Approval Rate Threshold (%) *</label>
                            <select name="required_approval_rate" class="form-select bg-dark text-white border-secondary rounded-pill py-2 px-3">
                                <option value="50.00" {{ ((float)($activeCampaign->required_approval_rate ?? 60.00)) == 50.00 ? 'selected' : '' }}>50% (Simple Majority)</option>
                                <option value="60.00" {{ ((float)($activeCampaign->required_approval_rate ?? 60.00)) == 60.00 ? 'selected' : '' }}>60% (Standard Quorum Target)</option>
                                <option value="66.67" {{ ((float)($activeCampaign->required_approval_rate ?? 60.00)) == 66.67 ? 'selected' : '' }}>66.67% (2/3 Supermajority)</option>
                                <option value="75.00" {{ ((float)($activeCampaign->required_approval_rate ?? 60.00)) == 75.00 ? 'selected' : '' }}>75% (High Approval Threshold)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Manual Submission Override Switch</label>
                            <select name="is_submission_override" class="form-select bg-dark text-white border-secondary rounded-pill py-2 px-3">
                                <option value="auto" {{ is_null($activeCampaign?->is_submission_override) ? 'selected' : '' }}>Auto (Strictly follow submission deadline)</option>
                                <option value="force_open" {{ $activeCampaign?->is_submission_override === true ? 'selected' : '' }}>Force Open Submissions (Override deadline)</option>
                                <option value="force_close" {{ $activeCampaign?->is_submission_override === false ? 'selected' : '' }}>Force Close Submissions (Lock immediately)</option>
                            </select>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted small fw-bold">Execution Start *</label>
                                <input type="date" name="proposed_date_start" class="form-control bg-dark text-white border-secondary rounded-pill py-2 px-3"
                                    value="{{ $activeCampaign?->proposed_date_start ? $activeCampaign->proposed_date_start->format('Y-m-d') : '' }}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted small fw-bold">Execution End *</label>
                                <input type="date" name="proposed_date_end" class="form-control bg-dark text-white border-secondary rounded-pill py-2 px-3"
                                    value="{{ $activeCampaign?->proposed_date_end ? $activeCampaign->proposed_date_end->format('Y-m-d') : '' }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4 fw-bold">Save Schedule Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- APPROVE PROPOSAL MODAL -->
    <div class="modal fade" id="adminApproveModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content text-white p-3" style="background-color: var(--admin-card-bg); border-radius: 14px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-primary"><i class="fa-solid fa-circle-check me-2"></i>Approve Proposal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="text-subtle small mb-0" id="adminApproveText">
                        Are you sure you want to approve this proposal? It will be released for member voting.
                    </p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <form id="adminApproveForm" method="POST" action="">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4 fw-semibold">Confirm Approval</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- REQUEST REVISION MODAL -->
    <div class="modal fade" id="adminRevisionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-white p-3" style="background-color: var(--admin-card-bg); border-radius: 14px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-warning"><i class="fa-regular fa-comment-dots me-2"></i>Request Revision</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="adminRevisionForm" method="POST" action="">
                    @csrf
                    <div class="modal-body py-3">
                        <div class="p-2.5 rounded mb-3 bg-dark border border-secondary text-warning small">
                            Provide clear feedback. The proposal status will change to "Needs Revision" and the member can adjust it.
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Revision Feedback *</label>
                            <textarea name="feedback" class="form-control bg-dark text-white border-secondary rounded-3 p-2" rows="3" placeholder="Example: Please revise the venue, date, or duration." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-warning rounded-pill px-4 fw-bold text-dark"><i class="fa-regular fa-paper-plane me-1"></i> Send Revision Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- REJECT PROPOSAL MODAL -->
    <div class="modal fade" id="adminRejectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 460px;">
            <div class="modal-content text-white p-3" style="background-color: var(--admin-card-bg); border-radius: 14px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i>Reject Proposal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="adminRejectForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body py-3">
                        <p class="text-subtle small mb-3" id="adminRejectText">
                            Are you sure you want to reject this proposal?
                        </p>
                        <div class="mb-0">
                            <label class="form-label text-muted small fw-bold">Rejection Reason <span class="fw-normal">(Optional)</span></label>
                            <textarea name="reason" class="form-control bg-dark text-white border-secondary rounded-3 p-2" rows="3" placeholder="Provide a reason for rejecting this proposal..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-danger rounded-pill px-4 fw-semibold">Confirm Rejection</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CONVERT TO ACTIVITY MODAL -->
    <div class="modal fade" id="adminConvertModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content text-white p-3" style="background-color: var(--admin-card-bg); border-radius: 14px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-success"><i class="fa-solid fa-rocket me-2"></i>Convert to Official Activity</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="text-subtle small mb-0" id="adminConvertText">
                        Are you sure you want to convert this proposal into an official activity?
                    </p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <form id="adminConvertForm" method="POST" action="">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-semibold">Confirm Conversion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ARCHIVE PROPOSAL MODAL -->
    <div class="modal fade" id="adminArchiveModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content text-white p-3" style="background-color: var(--admin-card-bg); border-radius: 14px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-light"><i class="fa-solid fa-box-archive me-2 text-muted"></i>Archive Proposal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="text-subtle small mb-0" id="adminArchiveText">
                        Are you sure you want to archive this proposal?
                    </p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <form id="adminArchiveForm" method="POST" action="">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-secondary rounded-pill px-4 fw-semibold">Archive Proposal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- DELETE PROPOSAL MODAL -->
    <div class="modal fade" id="adminDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content text-white p-3" style="background-color: var(--admin-card-bg); border-radius: 14px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger"><i class="fa-regular fa-trash-can me-2"></i>Delete Proposal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="text-subtle small mb-0" id="adminDeleteText">
                        Are you sure you want to permanently delete this proposal? This action cannot be undone.
                    </p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <form id="adminDeleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger rounded-pill px-4 fw-semibold">Delete Permanently</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openAdminApproveModal(id, title) {
            document.getElementById('adminApproveText').innerHTML = `Are you sure you want to approve "<strong>${title}</strong>"? This will release the proposal for member voting.`;
            document.getElementById('adminApproveForm').action = "{{ url('/admin/proposals') }}/" + id + "/approve";
            new bootstrap.Modal(document.getElementById('adminApproveModal')).show();
        }

        function openRevisionModal(id) {
            document.getElementById('adminRevisionForm').action = "{{ url('/admin/proposals') }}/" + id + "/revision";
            new bootstrap.Modal(document.getElementById('adminRevisionModal')).show();
        }

        function openAdminRejectModal(id, title) {
            document.getElementById('adminRejectText').innerHTML = `Are you sure you want to reject "<strong>${title}</strong>"?`;
            document.getElementById('adminRejectForm').action = "{{ url('/admin/proposals') }}/" + id + "/reject";
            new bootstrap.Modal(document.getElementById('adminRejectModal')).show();
        }

        function openAdminConvertModal(id, title) {
            document.getElementById('adminConvertText').innerHTML = `Are you sure you want to convert "<strong>${title}</strong>" into an official activity?`;
            document.getElementById('adminConvertForm').action = "{{ url('/admin/proposals') }}/" + id + "/convert";
            new bootstrap.Modal(document.getElementById('adminConvertModal')).show();
        }

        function openAdminArchiveModal(id, title) {
            document.getElementById('adminArchiveText').innerHTML = `Are you sure you want to archive "<strong>${title}</strong>"?`;
            document.getElementById('adminArchiveForm').action = "{{ url('/admin/proposals') }}/" + id + "/archive";
            new bootstrap.Modal(document.getElementById('adminArchiveModal')).show();
        }

        function openAdminDeleteModal(id, title) {
            document.getElementById('adminDeleteText').innerHTML = `Are you sure you want to permanently delete "<strong>${title}</strong>"? This action cannot be undone.`;
            document.getElementById('adminDeleteForm').action = "{{ url('/admin/proposals') }}/" + id;
            new bootstrap.Modal(document.getElementById('adminDeleteModal')).show();
        }
    </script>
@endsection
