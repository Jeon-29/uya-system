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
        .pastel-card {
            background: rgba(255, 255, 255, 0.22) !important;
            border-radius: 18px !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08) !important;
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            border: 1px solid rgba(255, 255, 255, 0.45) !important;
        }

        /* Nested Liquid Glass Subcards */
        .glass-subcard {
            background: rgba(255, 255, 255, 0.45) !important;
            backdrop-filter: blur(6px) !important;
            -webkit-backdrop-filter: blur(6px) !important;
            border: 1px solid rgba(255, 255, 255, 0.7) !important;
            border-radius: 12px;
            padding: 0.65rem 0.85rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
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
            font-size: 0.85rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0;
            line-height: 1.25;
        }

        .btn-action-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            font-size: 0.78rem;
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
            background: rgba(255, 255, 255, 0.5) !important;
            backdrop-filter: blur(6px) !important;
            -webkit-backdrop-filter: blur(6px) !important;
            border: 1px solid rgba(255, 255, 255, 0.75) !important;
            border-radius: 12px;
            padding: 0.85rem 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .feedback-item-card:hover {
            background: rgba(255, 255, 255, 0.75) !important;
            border-color: rgba(255, 255, 255, 0.95) !important;
        }

        /* Collapsible Smooth Transition for Feedback */
        .feedback-hidden-wrapper {
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows 0.35s ease-out, opacity 0.3s ease-out;
            opacity: 0;
        }

        .feedback-hidden-wrapper.show {
            grid-template-rows: 1fr;
            opacity: 1;
        }

        .feedback-hidden-inner {
            overflow: hidden;
        }

        /* Glass Modal Styles */
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

    @include('layouts.navbar')

    <div class="app-container py-2 py-md-4">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ route('proposals') }}" class="btn btn-light border rounded-pill px-3 py-1.5 text-brand fw-bold shadow-sm text-decoration-none" style="font-size: 0.85rem; background-color: #ffffff;">
                <i class="fa-solid fa-arrow-left me-2"></i> Back to Proposals
            </a>
        </div>

        <div class="row g-3 g-md-4">
            <!-- Left Main Column: Proposal & Member Feedback -->
            <div class="col-12 col-lg-8">
                <!-- Proposal Overview Card -->
                <div class="card p-3 p-md-4 pastel-card mb-3">

                    <!-- Top Row: Status Badge & Actions -->
                    <div class="d-flex justify-content-between align-items-center mb-2 gap-2">
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
                        <span class="badge rounded-pill px-2.5 py-1.5 fw-bold {{ $statusClasses[$proposal->status] ?? 'bg-secondary' }}" style="font-size: 0.7rem;">
                            {{ ucfirst(str_replace('_', ' ', $proposal->status)) }}
                        </span>

                        <div class="d-flex align-items-center gap-1.5 flex-shrink-0">
                            @if ($isOwner && $proposal->status === 'needs_revision')
                                <button type="button" data-bs-toggle="modal" data-bs-target="#editProposalModal" class="btn btn-action-icon btn-edit-icon" title="Edit Proposal">
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

                    <!-- Full-Width Title Line -->
                    <h3 class="fw-bold text-brand mb-3 fs-5 fs-md-3 text-wrap" style="line-height: 1.35;">{{ $proposal->title }}</h3>

                    <!-- Sub-Card Metadata Grid -->
                    <div class="row g-2 mb-3">
                        <div class="col-6 col-md-4">
                            <div class="glass-subcard h-100">
                                <span class="subcard-label">PROPOSER</span>
                                <div class="subcard-value d-flex align-items-center gap-2 overflow-hidden">
                                    <i class="fa-regular fa-user text-brand flex-shrink-0 me-1"></i>
                                    <span class="text-truncate">{{ $proposal->user->name ?? 'Unknown' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="glass-subcard h-100">
                                <span class="subcard-label">DATE</span>
                                <div class="subcard-value d-flex align-items-center gap-2">
                                    <i class="fa-regular fa-calendar text-brand flex-shrink-0 me-1"></i>
                                    <span>{{ $proposal->proposed_date ? $proposal->proposed_date->format('M j, Y') : 'TBD' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="glass-subcard h-100">
                                <span class="subcard-label">BUDGET</span>
                                <div class="subcard-value d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-coins text-brand flex-shrink-0 me-1"></i>
                                    <span>₱{{ number_format($proposal->estimated_budget, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="glass-subcard h-100">
                                <span class="subcard-label">DURATION</span>
                                <div class="subcard-value d-flex align-items-center gap-2 overflow-hidden">
                                    <i class="fa-regular fa-clock text-brand flex-shrink-0 me-1"></i>
                                    <span class="text-truncate">{{ $proposal->duration }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Location Sub-Card -->
                        <div class="col-12 col-md-8">
                            <div class="glass-subcard h-100">
                                <span class="subcard-label">LOCATION</span>
                                <div class="subcard-value d-flex align-items-center gap-2 overflow-hidden">
                                    <i class="fa-solid fa-location-dot text-brand flex-shrink-0 me-1"></i>
                                    <span class="text-wrap" title="{{ $proposal->location }}">{{ $proposal->location }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold text-brand mb-1.5" style="font-size: 0.9rem;">Description</h6>
                    <p class="text-dark small mb-3 fw-medium" style="line-height: 1.5; font-size: 0.85rem; white-space: pre-line;">{{ $proposal->description }}</p>

                    <!-- PDF Card -->
                    @if($proposal->supporting_document_path)
                        <div class="glass-subcard p-2.5 d-flex justify-content-between align-items-center gap-2 mt-3 mb-1">
                            <div class="d-flex align-items-center gap-2 overflow-hidden">
                                <i class="fa-regular fa-file-pdf text-danger fs-5 flex-shrink-0 me-1"></i>
                                <span class="fw-bold text-dark small text-truncate" style="font-size: 0.82rem;">Supporting Document</span>
                            </div>
                            <a href="{{ asset('storage/' . $proposal->supporting_document_path) }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1 fw-bold flex-shrink-0 bg-white" style="font-size: 0.78rem;">
                                View PDF
                            </a>
                        </div>
                    @endif
                </div>

                <!-- MEMBER VOTER FEEDBACK -->
                @if($isOwner)
                    @php
                        $allFeedback = $yesFeedback->concat($noFeedback)->sortByDesc('updated_at');
                        $visibleFeedback =$allFeedback->take(3);
                        $extraFeedback =$allFeedback->skip(3);
                    @endphp

                    @if($allFeedback->count() > 0)
                        <div class="card p-3 p-md-4 pastel-card mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-brand mb-0" style="font-size: 0.9rem;">
                                    <i class="fa-regular fa-comments me-1.5 text-primary"></i> Voter Feedback <span class="text-secondary fw-semibold" style="font-size: 0.75rem;">(Private)</span>
                                </h6>
                                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-sm" style="font-size: 0.68rem;">{{ $allFeedback->count() }} comments</span>
                            </div>

                            <div class="d-flex flex-column gap-2 mt-2">
                                <!-- First 3 Visible Feedbacks -->
                                @foreach($visibleFeedback as $vote)
                                    <div class="feedback-item-card">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <div class="d-flex align-items-center gap-1.5">
                                                <span class="fw-bold text-dark small" style="font-size: 0.82rem;">{{ $vote->user->name ?? 'Member' }}</span>
                                                @if($vote->vote_type === 'yes')
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-0.5 fw-bold" style="font-size: 0.65rem;">
                                                        <i class="fa-regular fa-thumbs-up me-1"></i> YES
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2 py-0.5 fw-bold" style="font-size: 0.65rem;">
                                                        <i class="fa-regular fa-thumbs-down me-1"></i> NO
                                                    </span>
                                                @endif
                                            </div>
                                            <span class="text-secondary fw-semibold" style="font-size: 0.7rem;">{{ $vote->updated_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mb-0 text-dark small fw-medium" style="line-height: 1.4; font-size: 0.82rem;">{{ $vote->feedback }}</p>
                                    </div>
                                @endforeach

                                <!-- Remaining Feedbacks inside Collapsible Container -->
                                @if ($extraFeedback->count() > 0)
                                    <div id="feedbackHiddenWrapper" class="feedback-hidden-wrapper">
                                        <div class="feedback-hidden-inner d-flex flex-column gap-2 pt-2">
                                            @foreach($extraFeedback as $vote)
                                                <div class="feedback-item-card">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <div class="d-flex align-items-center gap-1.5">
                                                            <span class="fw-bold text-dark small" style="font-size: 0.82rem;">{{ $vote->user->name ?? 'Member' }}</span>
                                                            @if($vote->vote_type === 'yes')
                                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-0.5 fw-bold" style="font-size: 0.65rem;">
                                                                    <i class="fa-regular fa-thumbs-up me-1"></i> YES
                                                                </span>
                                                            @else
                                                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2 py-0.5 fw-bold" style="font-size: 0.65rem;">
                                                                    <i class="fa-regular fa-thumbs-down me-1"></i> NO
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <span class="text-secondary fw-semibold" style="font-size: 0.7rem;">{{ $vote->updated_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="mb-0 text-dark small fw-medium" style="line-height: 1.4; font-size: 0.82rem;">{{ $vote->feedback }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- See All Button -->
                                    <div class="text-center pt-2">
                                        <button type="button" id="toggleFeedbackBtn" onclick="toggleFeedbackList()" class="btn btn-sm btn-light border rounded-pill px-3 py-1.5 fw-bold text-brand shadow-sm" style="font-size: 0.8rem; background-color: #ffffff;">
                                            See All ({{ $allFeedback->count() }}) <i class="fa-solid fa-chevron-down ms-1"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Right Column: Voting Results & Officer Feedback -->
            <div class="col-12 col-lg-4">
                <div class="d-flex flex-column gap-3">
                    <!-- Voting Results Card -->
                    <div class="card p-3 p-md-4 pastel-card">
                        <h6 class="fw-bold text-brand mb-3" style="font-size: 0.9rem;">Voting Results</h6>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="p-2.5 rounded-3 text-center border border-success border-opacity-25" style="background-color: rgba(232, 248, 240, 0.85);">
                                    <span class="text-success d-block small fw-bold mb-1" style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-up me-1"></i> YES</span>
                                    <span class="fs-4 fw-bold text-success">{{ $proposal->yesVotesCount() }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2.5 rounded-3 text-center border border-danger border-opacity-25" style="background-color: rgba(255, 255, 255, 0.85);">
                                    <span class="text-danger d-block small fw-bold mb-1" style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-down me-1"></i> NO</span>
                                    <span class="fs-4 fw-bold text-danger">{{ $proposal->noVotesCount() }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="progress mt-2.5 mb-1.5" style="height: 6px;">
                            <div class="progress-bar bg-{{ $proposal->approvalRatePercentage() >= 60 ? 'success' : 'danger' }}" role="progressbar" style="width: {{ $proposal->approvalRatePercentage() }}%;"></div>
                        </div>
                        <div class="d-flex justify-content-between text-secondary fw-semibold small" style="font-size: 0.78rem;">
                            <span>Approval Rate</span>
                            <span class="fw-bold text-dark">{{ $proposal->approvalRatePercentage() }}%</span>
                        </div>
                    </div>

                    <!-- PRIVATE OFFICER REVISION FEEDBACK -->
                    @if ($isOwner && $proposal->revisions && $proposal->revisions->count() > 0)
                        <div class="card p-3 p-md-4 pastel-card border-warning border-opacity-50">
                            <h6 class="fw-bold text-brand mb-2.5" style="font-size: 0.9rem;">
                                <i class="fa-solid fa-comments me-1.5 text-warning"></i> Officer Revision Requests <span class="text-secondary fw-semibold" style="font-size: 0.72rem;">(Private)</span>
                            </h6>
                            <div class="d-flex flex-column gap-2 mt-2">
                                @foreach ($proposal->revisions as $revision)
                                    <div class="feedback-item-card border-warning border-opacity-25" style="background-color: rgba(255, 253, 245, 0.85);">
                                        <div class="d-flex justify-content-between text-secondary small mb-1">
                                            <span class="fw-bold text-dark" style="font-size: 0.8rem;"><i class="fa-solid fa-user-shield me-1 text-secondary"></i> {{ $revision->officer->name ?? 'Officer' }}</span>
                                            <span class="fw-semibold" style="font-size: 0.7rem;">{{ $revision->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mb-0 text-dark small fw-medium" style="line-height: 1.4; font-size: 0.82rem;">{{ $revision->feedback }}</p>
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
                <div class="modal-content rounded-4 shadow-lg border-0 p-3 glass-modal-content">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2 border-secondary border-opacity-10">
                        <h5 class="fw-bold text-brand mb-0" style="font-size: 1.05rem;">Edit Proposal</h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form method="POST" action="{{ route('proposals.update', $proposal->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-2">
                            <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Proposal Title *</label>
                            <input type="text" name="title" value="{{ $proposal->title }}" class="form-control rounded-pill py-1.5 px-3 shadow-none border bg-light" style="font-size: 0.85rem;" required>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Location *</label>
                                <input type="text" name="location" value="{{ $proposal->location }}" class="form-control rounded-pill py-1.5 px-3 shadow-none border bg-light" style="font-size: 0.85rem;" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Duration *</label>
                                <input type="text" name="duration" value="{{ $proposal->duration }}" class="form-control rounded-pill py-1.5 px-3 shadow-none border bg-light" style="font-size: 0.85rem;" required>
                            </div>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Proposed Date *</label>
                                <input type="date" name="proposed_date" value="{{ $proposal->proposed_date ? $proposal->proposed_date->format('Y-m-d') : '' }}" class="form-control rounded-pill py-1.5 px-3 shadow-none border bg-light" style="font-size: 0.85rem;" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Estimated Budget</label>
                                <input type="text" name="estimated_budget" value="{{ $proposal->estimated_budget }}" class="form-control rounded-pill py-1.5 px-3 shadow-none border bg-light" style="font-size: 0.85rem;">
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Description *</label>
                            <textarea name="description" class="form-control rounded-4 p-2.5 shadow-none border bg-light" rows="3" style="font-size: 0.85rem; resize: none;" required>{{ $proposal->description }}</textarea>
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
    @endif

    <!-- DELETE PROPOSAL MODAL -->
    @if ($isOwner && in_array($proposal->status, ['pending', 'needs_revision', 'rejected']))
        <div class="modal fade" id="deleteProposalModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
                <div class="modal-content rounded-4 shadow-lg border-0 p-3 glass-modal-content">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2 border-secondary border-opacity-10">
                        <h5 class="fw-bold text-danger mb-0" style="font-size: 1.05rem;"><i class="fa-solid fa-triangle-exclamation me-1"></i> Delete Proposal</h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="py-2 text-dark fw-medium" style="font-size: 0.85rem;">
                        Are you sure you want to permanently delete proposal "<strong>{{ $proposal->title }}</strong>"? This action cannot be undone.
                    </div>
                    <form method="POST" action="{{ route('proposals.destroy', $proposal->id) }}">
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
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleFeedbackList() {
            const wrapper = document.getElementById('feedbackHiddenWrapper');
            const btn = document.getElementById('toggleFeedbackBtn');
            const isShowing = wrapper.classList.contains('show');

            if (isShowing) {
                wrapper.classList.remove('show');
                btn.innerHTML = `See All (${btn.dataset.total || 'All'}) <i class="fa-solid fa-chevron-down ms-1"></i>`;
            } else {
                if (!btn.dataset.total) {
                    btn.dataset.total = "{{ isset($allFeedback) ?$allFeedback->count() : '' }}";
                }
                wrapper.classList.add('show');
                btn.innerHTML = `Show Less <i class="fa-solid fa-chevron-up ms-1"></i>`;
            }
        }
    </script>
</body>
</html>
