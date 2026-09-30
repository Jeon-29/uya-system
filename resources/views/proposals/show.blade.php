<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $proposal->title }} - UYA Connect</title>

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

        .info-pill {
            background-color: #f3f7f9;
            border: 1px solid #dce5e8;
            border-radius: 50rem;
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
            color: #555;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .btn-action-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            font-size: 0.8rem;
        }

        .btn-edit-icon {
            color: #854d0e;
            background-color: #fefce8;
            border: 1px solid #fef08a;
        }

        .btn-edit-icon:hover {
            background-color: #eab308;
            color: #ffffff;
            border-color: #eab308;
        }

        .btn-delete-icon {
            color: #dc3545;
            background-color: #fff0f1;
            border: 1px solid #f8d7da;
        }

        .btn-delete-icon:hover {
            background-color: #dc3545;
            color: #ffffff;
            border-color: #dc3545;
        }

        .feedback-item-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            transition: all 0.2s ease;
        }

        .feedback-item-card:hover {
            border-color: #cbd5e1;
            background-color: #ffffff;
        }
    </style>
</head>

<body>

    @include('layouts.navbar')

    <div class="container-fluid py-4 px-3 px-md-4 px-lg-5">
        <!-- Back Link Header -->
        <div class="mb-3 d-flex align-items-center justify-content-between">
            <a href="{{ route('proposals') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1.5 fw-semibold" style="font-size: 0.8rem;">
                <i class="fa-solid fa-arrow-left me-1.5"></i> Back to Proposals
            </a>
        </div>

        <div class="row g-4">
            <!-- Left Main Column: Proposal & Member Feedback -->
            <div class="col-lg-8">
                <!-- Proposal Overview Card -->
                <div class="card p-4 pastel-card mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3 gap-2 flex-wrap">
                        <h3 class="fw-bold text-brand mb-0" style="font-size: 1.4rem;">{{ $proposal->title }}</h3>

                        <div class="d-flex align-items-center gap-2">
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
                            <span class="badge rounded-pill px-3 py-2 fw-semibold me-1 {{ $statusClasses[$proposal->status] ?? 'bg-secondary' }}" style="font-size: 0.75rem;">
                                {{ ucfirst(str_replace('_', ' ', $proposal->status)) }}
                            </span>

                            <!-- Top-Right Action Buttons for Proposer: Edit is only accessible when revision is requested -->
                            @if ($isOwner && $proposal->status === 'needs_revision')
                                <button type="button" data-bs-toggle="modal" data-bs-target="#editProposalModal" class="btn btn-action-icon btn-edit-icon" title="Edit Proposal (Feedback Received)">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                            @endif

                            @if ($isOwner && in_array($proposal->status, ['pending', 'needs_revision', 'rejected']))
                                <button type="button" data-bs-toggle="modal" data-bs-target="#deleteProposalModal" class="btn btn-action-icon btn-delete-icon" title="Delete Proposal">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <div class="info-pill"><i class="fa-regular fa-user text-secondary"></i> {{ $proposal->user->name ?? 'Unknown' }}</div>
                        <div class="info-pill"><i class="fa-solid fa-location-dot text-secondary"></i> {{ $proposal->location }}</div>
                        <div class="info-pill"><i class="fa-regular fa-clock text-secondary"></i> {{ $proposal->duration }}</div>
                        <div class="info-pill"><i class="fa-regular fa-calendar text-secondary"></i> {{ $proposal->proposed_date ? $proposal->proposed_date->format('F j, Y') : 'TBD' }}</div>
                        <div class="info-pill"><i class="fa-solid fa-coins text-secondary"></i> ₱{{ number_format($proposal->estimated_budget, 2) }}</div>
                    </div>

                    <h6 class="fw-bold text-brand mb-2" style="font-size: 0.95rem;">Description</h6>
                    <p class="text-secondary mb-4" style="line-height: 1.6; font-size: 0.9rem;">{{ $proposal->description }}</p>

                    @if($proposal->supporting_document_path)
                        <div class="p-3 bg-light rounded-3 border d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2.5">
                                <i class="fa-regular fa-file-pdf text-danger fs-4"></i>
                                <span class="fw-semibold text-dark small">Supporting Document Attached</span>
                            </div>
                            <a href="{{ asset('storage/' . $proposal->supporting_document_path) }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1 fw-semibold" style="font-size: 0.8rem;">
                                View PDF
                            </a>
                        </div>
                    @endif
                </div>

                <!-- UNIFIED MEMBER VOTER FEEDBACK (NEXT TO PROPOSAL) -->
                @if($isOwner)
                    @php
                        $allFeedback = $yesFeedback->concat($noFeedback)->sortByDesc('updated_at');
                    @endphp

                    @if($allFeedback->count() > 0)
                        <div class="card p-4 pastel-card mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-brand mb-0" style="font-size: 0.95rem;">
                                    <i class="fa-regular fa-comments me-2 text-primary"></i>Member Voter Feedback <span class="text-muted fw-normal" style="font-size: 0.8rem;">(Private to You)</span>
                                </h6>
                                <span class="badge bg-light text-dark border px-2.5 py-1" style="font-size: 0.72rem;">{{ $allFeedback->count() }} total comments</span>
                            </div>

                            <div class="d-flex flex-column gap-3">
                                @foreach($allFeedback as $vote)
                                    <div class="feedback-item-card">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="fw-bold text-dark small">{{ $vote->user->name ?? 'Member' }}</span>
                                                @if($vote->vote_type === 'yes')
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2.5 py-0.5" style="font-size: 0.68rem;">
                                                        <i class="fa-regular fa-thumbs-up me-1"></i> YES
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2.5 py-0.5" style="font-size: 0.68rem;">
                                                        <i class="fa-regular fa-thumbs-down me-1"></i> NO
                                                    </span>
                                                @endif
                                            </div>
                                            <span class="text-muted" style="font-size: 0.75rem;">{{ $vote->updated_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mb-0 text-dark small" style="line-height: 1.5; font-size: 0.85rem;">{{ $vote->feedback }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Right Side Column: Voting Results & Officer Feedback -->
            <div class="col-lg-4">
                <div class="d-flex flex-column gap-4">
                    <!-- Voting Results Card -->
                    <div class="card p-4 pastel-card">
                        <h6 class="fw-bold text-brand mb-3" style="font-size: 0.95rem;">Voting Results</h6>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="p-3 rounded-3 text-center border border-success border-opacity-25" style="background-color: #e8f8f0;">
                                    <span class="text-success d-block small fw-bold mb-1"><i class="fa-regular fa-thumbs-up me-1"></i> YES</span>
                                    <span class="fs-4 fw-bold text-success">{{ $proposal->yesVotesCount() }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-3 text-center border border-danger border-opacity-25 bg-white">
                                    <span class="text-danger d-block small fw-bold mb-1"><i class="fa-regular fa-thumbs-down me-1"></i> NO</span>
                                    <span class="fs-4 fw-bold text-danger">{{ $proposal->noVotesCount() }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="progress mb-2" style="height: 7px;">
                            <div class="progress-bar bg-{{ $proposal->approvalRatePercentage() >= 60 ? 'success' : 'danger' }}" role="progressbar" style="width: {{ $proposal->approvalRatePercentage() }}%;"></div>
                        </div>
                        <div class="d-flex justify-content-between text-muted small">
                            <span>Approval Rate</span>
                            <span class="fw-bold text-dark">{{ $proposal->approvalRatePercentage() }}%</span>
                        </div>
                    </div>

                    <!-- PRIVATE OFFICER REVISION FEEDBACK (BELOW VOTING RESULTS) -->
                    @if($isOwner && $proposal->revisions && $proposal->revisions->count() > 0)
                        <div class="card p-4 pastel-card border-warning border-opacity-50">
                            <h6 class="fw-bold text-brand mb-3" style="font-size: 0.95rem;">
                                <i class="fa-solid fa-comments me-2 text-warning"></i>Officer Revision Requests <div class="text-muted fw-normal mt-0.5" style="font-size: 0.75rem;">(Private to You)</div>
                            </h6>
                            <div class="d-flex flex-column gap-3">
                                @foreach($proposal->revisions as $revision)
                                    <div class="feedback-item-card border-warning border-opacity-25" style="background-color: #fffdf5;">
                                        <div class="d-flex justify-content-between text-muted small mb-1.5">
                                            <span class="fw-bold text-dark"><i class="fa-solid fa-user-shield me-1 text-secondary"></i> {{ $revision->officer->name ?? 'Officer' }}</span>
                                            <span style="font-size: 0.72rem;">{{ $revision->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mb-0 text-dark small" style="line-height: 1.5;">{{ $revision->feedback }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT PROPOSAL MODAL -->
    @if ($isOwner && $proposal->status === 'needs_revision')
        <div class="modal fade" id="editProposalModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 620px;">
                <div class="modal-content rounded-4 shadow-lg border-0 p-3">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <h5 class="fw-bold text-brand mb-0" style="font-size: 1.05rem;">Edit Proposal</h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form method="POST" action="{{ route('proposals.update', $proposal->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-2">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Proposal Title *</label>
                            <input type="text" name="title" value="{{ $proposal->title }}" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;" required>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Location *</label>
                                <input type="text" name="location" value="{{ $proposal->location }}" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Duration *</label>
                                <input type="text" name="duration" value="{{ $proposal->duration }}" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;" required>
                            </div>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Proposed Date *</label>
                                <input type="date" name="proposed_date" value="{{ $proposal->proposed_date ? $proposal->proposed_date->format('Y-m-d') : '' }}" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Estimated Budget</label>
                                <input type="text" name="estimated_budget" value="{{ $proposal->estimated_budget }}" class="form-control rounded-pill py-1.5 px-3 shadow-none border" style="font-size: 0.85rem;">
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Description *</label>
                            <textarea name="description" class="form-control rounded-4 p-2.5 shadow-none border" rows="3" style="font-size: 0.85rem; resize: none;" required>{{ $proposal->description }}</textarea>
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
    @endif

    <!-- DELETE PROPOSAL MODAL -->
    @if ($isOwner && in_array($proposal->status, ['pending', 'needs_revision', 'rejected']))
        <div class="modal fade" id="deleteProposalModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
                <div class="modal-content rounded-4 shadow-lg border-0 p-3">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <h5 class="fw-bold text-danger mb-0" style="font-size: 1.05rem;"><i class="fa-solid fa-triangle-exclamation me-1"></i> Delete Proposal</h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="py-2 text-secondary" style="font-size: 0.85rem;">
                        Are you sure you want to permanently delete proposal "<strong>{{ $proposal->title }}</strong>"? This action cannot be undone.
                    </div>
                    <form method="POST" action="{{ route('proposals.destroy', $proposal->id) }}">
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
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
