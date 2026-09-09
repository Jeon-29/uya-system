<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal Details - UYA Connect</title>

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
        }

        .pastel-card {
            background-color: #ffffff;
            border: 1px solid #dce5e8 !important;
            border-radius: 16px;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.03);
        }

        .info-pill-box {
            background-color: #f3f7f9;
            border: 1px solid #dce5e8;
            border-radius: 12px;
            padding: 0.85rem 1.15rem;
            font-size: 0.85rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-warning-custom {
            background-color: #fff8f0;
            border: 1px solid #fce8d2;
            border-radius: 12px;
            padding: 1.25rem;
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

    <!-- Responsive container using full width on desktop with comfortable padding -->
    <div class="container-fluid py-4 px-3 px-md-4 px-lg-5">

        @if (session('success'))
            <div class="alert alert-success rounded-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
        @endif
        @if ($errors->any() && !old('title'))
            <div class="alert alert-danger rounded-4">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Back Button -->
        <div class="mb-4">
            <a href="/proposals" class="btn btn-light border rounded-pill px-3 py-2 fw-semibold text-brand shadow-sm d-inline-flex align-items-center gap-2" style="font-size: 0.85rem;">
                <i class="fa-solid fa-arrow-left"></i> Back to Proposals
            </a>
        </div>

        <!-- Main Proposal Details Card -->
        <div class="card p-4 pastel-card mb-4">
            <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                <div>
                    <h3 class="fw-bold mb-1 text-brand" style="font-size: 1.4rem;">{{ $proposal->title }}</h3>
                    <div class="d-flex align-items-center gap-1.5 text-muted small" style="font-size: 0.85rem;">
                        <i class="fa-regular fa-user"></i> {{ $proposal->proposer->name ?? 'Unknown' }}
                    </div>
                </div>
                <div>
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
                    <!-- Single Clean Status Badge -->
                    <span class="badge rounded-pill px-3 py-1.5 fw-semibold {{ $statusClasses[$proposal->status] ?? 'bg-secondary' }}"
                        style="font-size: 0.75rem;">
                        {{ $statusLabels[$proposal->status] ?? ucfirst(str_replace('_', ' ', $proposal->status)) }}
                    </span>
                </div>
            </div>

            <p class="text-muted mt-2 mb-4" style="font-size: 0.95rem; line-height: 1.5;">{{ $proposal->description }}</p>

            <!-- Info Pills Grid -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="info-pill-box">
                        <i class="fa-solid fa-location-dot text-secondary"></i>
                        <span>{{ $proposal->location }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-pill-box">
                        <i class="fa-regular fa-clock text-secondary"></i>
                        <span>{{ $proposal->duration }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-pill-box">
                        <i class="fa-regular fa-calendar text-secondary"></i>
                        <span>Proposed date: {{ $proposal->proposed_date ? $proposal->proposed_date->format('F j, Y') : 'TBD' }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-pill-box">
                        <i class="fa-solid fa-hourglass-half text-secondary"></i>
                        <span>Voting deadline: {{ $proposal->voting_deadline ? $proposal->voting_deadline->format('F j, Y') : 'TBD' }}</span>
                    </div>
                </div>
            </div>

            <!-- Vote Summary Box -->
            <div class="bg-light border rounded-3 p-3 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 0.85rem;">
                    <span class="text-muted fw-semibold">Vote Summary</span>
                    <span class="text-muted">{{ $proposal->total_votes }} total votes</span>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <div class="p-2 rounded-2 border border-success border-opacity-25 d-flex justify-content-between align-items-center" style="background-color: #e8f8f0;">
                            <span class="text-success fw-semibold" style="font-size: 0.8rem;"><i class="fa-regular fa-thumbs-up me-1"></i> Yes: {{ $proposal->yes_count }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 rounded-2 bg-white border border-danger border-opacity-25 d-flex justify-content-between align-items-center">
                            <span class="text-danger fw-semibold" style="font-size: 0.8rem;"><i class="fa-regular fa-thumbs-down me-1"></i> No: {{ $proposal->no_count }}</span>
                        </div>
                    </div>
                </div>
                <div class="progress mb-1" style="height: 6px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $proposal->approval_percentage }}%;"></div>
                </div>
            </div>

            <!-- Revision Requested Notification Box -->
            @if ($proposal->status === 'revision_requested')
                <div class="alert-warning-custom mb-4">
                    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">Revision Requested</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.85rem;">Revision requested. Open the proposal details or edit form to review the officer feedback before resubmitting.</p>
                </div>
            @endif

            <!-- Proposal Editing Action Box (Strictly restricted to the author) -->
            @if (auth()->check() && auth()->id() === $proposal->user_id && in_array($proposal->status, ['submitted', 'revision_requested']))
                <div class="card p-3.5 border rounded-3 bg-white mb-4">
                    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">Proposal editing</h6>
                    <p class="text-muted small mb-3" style="font-size: 0.8rem;">Editable only during Submission phase while the status is Pending Review or Revision Requested.</p>
                    <div>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#editProposalModal"
                            class="btn btn-sm rounded-pill px-4 py-2 fw-semibold custom-btn-outline d-inline-flex align-items-center gap-2 shadow-sm" style="font-size: 0.85rem;">
                            <i class="fa-regular fa-pen-to-square"></i> Edit Proposal
                        </button>
                    </div>
                </div>
            @endif

            <!-- Admin/Coordinator Feedback History (Visible only to the proposal owner or officers/admins) -->
            @if (auth()->check() && (auth()->id() === $proposal->user_id || in_array(auth()->user()->role ?? 'member', ['admin', 'officer'])))
                <div class="alert-warning-custom mb-4">
                    <div class="d-flex align-items-center gap-2 mb-2 text-dark fw-bold" style="font-size: 0.9rem;">
                        <i class="fa-solid fa-triangle-exclamation text-warning"></i> Admin/Coordinator Feedback History
                    </div>
                    <div class="bg-white p-3 rounded-3 border border-warning border-opacity-25">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold text-dark" style="font-size: 0.85rem;">Revision Requested</span>
                            <span class="text-muted small" style="font-size: 0.75rem;">{{ $proposal->updated_at->format('F j, Y') }}</span>
                        </div>
                        <p class="text-muted mb-0 small" style="font-size: 0.85rem;">Please review the revision notes and update your proposal details accordingly.</p>
                    </div>
                </div>
            @endif

            <!-- Voting feedback from members -->
            <div class="card p-3.5 border rounded-3 bg-white">
                <div class="d-flex align-items-center gap-2 mb-2 text-dark fw-bold" style="font-size: 0.9rem;">
                    <i class="fa-regular fa-comment"></i> Voting feedback from members
                </div>
                @if ($proposal->votes->isNotEmpty())
                    <div class="text-center text-muted py-3 border border-dashed rounded-3 bg-light" style="font-size: 0.85rem;">
                        @foreach ($proposal->votes as $vote)
                            @if ($vote->feedback)
                                <div class="mb-2 p-3 rounded bg-light">{{ $vote->feedback }}</div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-3 border border-dashed rounded-3 bg-light" style="font-size: 0.85rem;">
                        No voting feedback submitted yet for this proposal.
                    </div>
                @endif
            </div>

        </div>

    </div>

    <!-- Edit Proposal Modal Popup (Rendered only if authorized) -->
    @if (auth()->check() && auth()->id() === $proposal->user_id)
    <div class="modal fade" id="editProposalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 600px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">Edit Proposal</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-4">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('proposals.update', $proposal) }}">
                    @csrf
                    @method('PUT')
                    <div class="bg-light border p-3 rounded-3 mb-3" style="font-size: 0.85rem; line-height: 1.4;">
                        You may update only the title, description, venue/location, duration, and proposed date. Saving a revision returns the status to Pending Review.
                    </div>

                    @if ($proposal->status === 'revision_requested')
                        <div class="alert-warning-custom mb-3 p-3">
                            <span class="fw-bold text-dark d-block mb-1" style="font-size: 0.8rem;">Revision feedback</span>
                            <p class="text-muted mb-0 small" style="font-size: 0.8rem;">Please review the officer feedback above before resubmitting your proposal.</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Proposal Title *</label>
                        <input type="text" name="title"
                            class="form-control rounded-pill py-2 px-3 shadow-none border"
                            value="{{ old('title', $proposal->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Description *</label>
                        <textarea name="description" class="form-control rounded-4 p-3 shadow-none border" rows="3"
                            style="resize: none;" required>{{ old('description', $proposal->description) }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Venue / Location *</label>
                            <input type="text" name="location"
                                class="form-control rounded-pill py-2 px-3 shadow-none border" value="{{ old('location', $proposal->location) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Duration *</label>
                            <input type="text" name="duration"
                                class="form-control rounded-pill py-2 px-3 shadow-none border" value="{{ old('duration', $proposal->duration) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Estimated Budget</label>
                        <input type="text" name="estimated_budget"
                            class="form-control rounded-pill py-2 px-3 shadow-none border" value="{{ old('estimated_budget', $proposal->estimated_budget) }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Proposed Date *</label>
                        <input type="date" name="proposed_date"
                            class="form-control rounded-pill py-2 px-3 shadow-none border"
                            value="{{ old('proposed_date', $proposal->proposed_date ? $proposal->proposed_date->format('Y-m-d') : '') }}" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button"
                            class="btn btn-light border rounded-pill py-2 w-50 fw-semibold text-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit"
                            class="btn rounded-pill py-2 w-50 fw-semibold text-white shadow-sm d-flex align-items-center justify-content-center gap-1.5"
                            style="background-color: var(--uya-dark-teal);">
                            <i class="fa-regular fa-pen-to-square"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @if ($errors->any() && auth()->check() && auth()->id() === $proposal->user_id)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = new bootstrap.Modal(document.getElementById('editProposalModal'));
                modal.show();
            });
        </script>
    @endif
</body>

</html>
