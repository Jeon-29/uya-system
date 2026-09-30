@extends('layouts.admin')

@section('title', $proposal->title . ' - Admin Proposal Review')

@section('content')
<div class="container-fluid p-0">

    <!-- Top Back Button -->
    <div class="mb-4">
        <a href="{{ route('admin.proposals.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1.5">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Proposal Queue
        </a>
    </div>

    <div class="row g-4">
        <!-- Main Proposal Details -->
        <div class="col-lg-8">
            <div class="card p-4 border-0 mb-4" style="background-color: var(--admin-card-bg); border-radius: 14px;">
                <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                    <div>
                        <h3 class="fw-bold text-white mb-1">{{ $proposal->title }}</h3>
                        <span class="text-muted small">
                            <i class="fa-regular fa-user me-1"></i> Author: <strong>{{ $proposal->user->name ?? 'Unknown Member' }}</strong> ({{ $proposal->user->email ?? 'N/A' }})
                        </span>
                    </div>
                    <div>
                        @php
                            $statusClasses = [
                                'pending' => 'bg-primary',
                                'needs_revision' => 'bg-warning text-dark',
                                'active' => 'bg-warning text-dark',
                                'approved_for_execution' => 'bg-success text-white',
                                'rejected' => 'bg-danger text-white',
                                'completed' => 'bg-dark text-white',
                            ];
                        @endphp
                        <span class="badge rounded-pill px-3 py-2 fw-semibold {{ $statusClasses[$proposal->status] ?? 'bg-secondary' }}">
                            {{ ucfirst(str_replace('_', ' ', $proposal->status)) }}
                        </span>
                    </div>
                </div>

                <hr class="border-secondary opacity-25 my-3">

                <!-- Details Grid -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background-color: #0f172a; border: 1px solid var(--admin-border);">
                            <span class="text-muted small d-block mb-1"><i class="fa-solid fa-location-dot me-1 text-primary"></i> Location</span>
                            <span class="fw-bold text-white">{{ $proposal->location }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background-color: #0f172a; border: 1px solid var(--admin-border);">
                            <span class="text-muted small d-block mb-1"><i class="fa-regular fa-clock me-1 text-primary"></i> Duration</span>
                            <span class="fw-bold text-white">{{ $proposal->duration }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background-color: #0f172a; border: 1px solid var(--admin-border);">
                            <span class="text-muted small d-block mb-1"><i class="fa-regular fa-calendar me-1 text-primary"></i> Proposed Event Date</span>
                            <span class="fw-bold text-white">{{ $proposal->proposed_date ? $proposal->proposed_date->format('F j, Y') : 'TBD' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background-color: #0f172a; border: 1px solid var(--admin-border);">
                            <span class="text-muted small d-block mb-1"><i class="fa-solid fa-coins me-1 text-primary"></i> Estimated Budget</span>
                            <span class="fw-bold text-white">₱{{ number_format($proposal->estimated_budget, 2) }}</span>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold text-white mb-2">Proposal Description</h6>
                <p class="text-subtle small mb-4" style="line-height: 1.6; white-space: pre-line;">{{ $proposal->description }}</p>

                <!-- Document Validation Block -->
                <div class="p-3 rounded-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="background-color: #0f172a; border: 1px solid var(--admin-border);">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fa-regular fa-file-pdf text-danger fs-3"></i>
                        <div>
                            <span class="fw-bold text-white d-block small">Supporting Document File</span>
                            <span class="text-muted small">
                                Status:
                                @if($proposal->is_document_validated)
                                    <span class="text-success fw-bold"><i class="fa-solid fa-check-circle me-1"></i> Validated</span>
                                @else
                                    <span class="text-warning fw-bold"><i class="fa-solid fa-clock me-1"></i> Pending Validation</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        @if($proposal->supporting_document_path)
                            <a href="{{ asset('storage/' . $proposal->supporting_document_path) }}" target="_blank" class="btn btn-sm btn-outline-light rounded-pill px-3">
                                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Document
                            </a>
                        @endif
                        <form method="POST" action="{{ route('admin.proposals.toggleDocument', $proposal->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $proposal->is_document_validated ? 'btn-outline-warning' : 'btn-success' }} rounded-pill px-3">
                                {{ $proposal->is_document_validated ? 'Mark Unvalidated' : 'Validate Document' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Revision History -->
            @if($proposal->revisions && $proposal->revisions->count() > 0)
                <div class="card p-4 border-0 mb-4" style="background-color: var(--admin-card-bg); border-radius: 14px;">
                    <h6 class="fw-bold text-white mb-3"><i class="fa-solid fa-comments text-warning me-2"></i>Officer Revision Request History</h6>
                    <div class="d-flex flex-column gap-3">
                        @foreach($proposal->revisions as $revision)
                            <div class="p-3 rounded-3" style="background-color: #0f172a; border: 1px solid var(--admin-border);">
                                <div class="d-flex justify-content-between text-muted small mb-1">
                                    <span class="fw-bold text-white">Requested by: {{ $revision->officer->name ?? 'Admin/Officer' }}</span>
                                    <span>{{ $revision->created_at->format('M j, Y g:i A') }}</span>
                                </div>
                                <p class="mb-0 text-subtle small">{{ $revision->feedback }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Actions & Vote Analytics -->
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-4">
                <!-- Review Actions Card -->
                <div class="card p-4 border-0" style="background-color: var(--admin-card-bg); border-radius: 14px;">
                    <h6 class="fw-bold text-white mb-3"><i class="fa-solid fa-sliders me-2 text-primary"></i>Admin Decision Actions</h6>
                    <div class="d-grid gap-2">
                        @if(in_array($proposal->status, ['pending', 'needs_revision']))
                            <button type="button" data-bs-toggle="modal" data-bs-target="#requestRevisionModal" class="btn btn-outline-warning rounded-pill py-2 fw-semibold">
                                <i class="fa-regular fa-comment-dots me-1"></i> Request Revision
                            </button>

                            <button type="button" data-bs-toggle="modal" data-bs-target="#approveProposalModal" class="btn btn-primary rounded-pill py-2 fw-semibold w-100">
                                <i class="fa-solid fa-check me-1"></i> Approve for Voting
                            </button>

                            <button type="button" data-bs-toggle="modal" data-bs-target="#rejectProposalModal" class="btn btn-outline-danger rounded-pill py-2 fw-semibold w-100">
                                <i class="fa-solid fa-xmark me-1"></i> Reject Proposal
                            </button>
                        @elseif(in_array($proposal->status, ['active', 'approved_for_execution']))
                            <form method="POST" action="{{ route('admin.proposals.convert', $proposal->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-success rounded-pill py-2 fw-semibold w-100">
                                    <i class="fa-solid fa-rocket me-1"></i> Convert to Official Activity
                                </button>
                            </form>
                        @elseif($proposal->status === 'rejected')
                            <form method="POST" action="{{ route('admin.proposals.destroy', $proposal->id) }}" onsubmit="return confirm('Are you sure you want to permanently delete this rejected proposal?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger rounded-pill py-2 fw-semibold w-100">
                                    <i class="fa-regular fa-trash-can me-1"></i> Delete Rejected Proposal
                                </button>
                            </form>
                        @else
                            <div class="p-3 text-center text-muted rounded-3" style="background-color: #0f172a; border: 1px solid var(--admin-border);">
                                No further actions required for this status.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Vote Summary Card -->
                <div class="card p-4 border-0" style="background-color: var(--admin-card-bg); border-radius: 14px;">
                    <h6 class="fw-bold text-white mb-3"><i class="fa-solid fa-square-poll-vertical me-2 text-primary"></i>Member Voting Results</h6>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="p-3 rounded-3 text-center border border-success border-opacity-25" style="background-color: rgba(34, 197, 94, 0.1);">
                                <span class="text-success d-block small fw-bold"><i class="fa-regular fa-thumbs-up me-1"></i> YES</span>
                                <span class="fs-4 fw-bold text-success">{{ $proposal->yesVotesCount() }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3 text-center border border-danger border-opacity-25" style="background-color: rgba(239, 68, 68, 0.1);">
                                <span class="text-danger d-block small fw-bold"><i class="fa-regular fa-thumbs-down me-1"></i> NO</span>
                                <span class="fs-4 fw-bold text-danger">{{ $proposal->noVotesCount() }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-{{ $proposal->approvalRatePercentage() >= 60 ? 'success' : 'danger' }}" role="progressbar" style="width: {{ $proposal->approvalRatePercentage() }}%;"></div>
                    </div>
                    <div class="d-flex justify-content-between text-muted small">
                        <span>Approval Rate</span>
                        <span class="fw-bold text-white">{{ $proposal->approvalRatePercentage() }}%</span>
                    </div>
                </div>

                <!-- MEMBER VOTER FEEDBACK WITH EXPLICIT HIGH-CONTRAST PILLS -->
                @php
                    $allMemberFeedback = $yesFeedback->concat($noFeedback)->sortByDesc('updated_at');
                @endphp

                <div class="card p-4 border-0" style="background-color: var(--admin-card-bg); border-radius: 14px;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-white mb-0" style="font-size: 0.95rem;">
                            <i class="fa-regular fa-comments me-2 text-primary"></i>Member Feedback
                        </h6>
                        <span class="badge bg-dark text-muted border border-secondary px-2.5 py-1" style="font-size: 0.72rem;">{{ $allMemberFeedback->count() }} total</span>
                    </div>

                    @if($allMemberFeedback->count() > 0)
                        <div class="d-flex flex-column gap-3">
                            @foreach($allMemberFeedback as $vote)
                                <div class="p-3 rounded-3" style="background-color: #0f172a; border: 1px solid var(--admin-border);">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold text-white small">{{ $vote->user->name ?? 'Member' }}</span>
                                            @if($vote->vote_type === 'yes')
                                                <span class="badge rounded-pill px-2.5 py-1 d-inline-flex align-items-center gap-1"
                                                      style="background-color: rgba(34, 197, 94, 0.2); border: 1px solid rgba(34, 197, 94, 0.4); color: #4ade80 !important; font-size: 0.7rem; font-weight: 700;">
                                                    <i class="fa-regular fa-thumbs-up"></i> YES
                                                </span>
                                            @else
                                                <span class="badge rounded-pill px-2.5 py-1 d-inline-flex align-items-center gap-1"
                                                      style="background-color: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); color: #f87171 !important; font-size: 0.7rem; font-weight: 700;">
                                                    <i class="fa-regular fa-thumbs-down"></i> NO
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-muted" style="font-size: 0.72rem;">{{ $vote->updated_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="mb-0 text-subtle small" style="line-height: 1.5; font-size: 0.82rem;">{{ $vote->feedback }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3 text-muted small">
                            <i class="fa-regular fa-comment-dots fs-4 mb-2 d-block opacity-50"></i>
                            No member feedback comments provided yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- REQUEST REVISION MODAL -->
<div class="modal fade" id="requestRevisionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-white p-3" style="background-color: var(--admin-card-bg); border-radius: 14px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Request Revision</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.proposals.requestRevision', $proposal->id) }}">
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
                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4"><i class="fa-regular fa-paper-plane me-1"></i> Send Revision Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- APPROVE PROPOSAL CONFIRMATION MODAL -->
<div class="modal fade" id="approveProposalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
        <div class="modal-content text-white p-3" style="background-color: var(--admin-card-bg); border-radius: 14px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-primary"><i class="fa-solid fa-circle-check me-2"></i>Approve Proposal</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <p class="text-subtle small mb-0">
                    Are you sure you want to approve "<strong>{{ $proposal->title }}</strong>"? This will release the proposal for member voting.
                </p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('admin.proposals.approveVoting', $proposal->id) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4 fw-semibold">Confirm Approval</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- REJECT PROPOSAL CONFIRMATION MODAL -->
<div class="modal fade" id="rejectProposalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 460px;">
        <div class="modal-content text-white p-3" style="background-color: var(--admin-card-bg); border-radius: 14px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i>Reject Proposal</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.proposals.reject', $proposal->id) }}">
                @csrf
                @method('PATCH')
                <div class="modal-body py-3">
                    <p class="text-subtle small mb-3">
                        Are you sure you want to reject "<strong>{{ $proposal->title }}</strong>"?
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
@endsection
