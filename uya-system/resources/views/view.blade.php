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
            padding-left: 2.5rem !important;
            padding-right: 2.5rem !important;
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

    <div class="container-fluid py-4" style="max-width: 1100px;">

        <!-- Back Button -->
        <div class="mb-4">
            <a href="/proposals" class="btn btn-light border rounded-pill px-3 py-2 fw-semibold text-brand shadow-sm d-inline-flex align-items-center gap-2" style="font-size: 0.85rem;">
                <i class="fa-solid fa-arrow-left"></i> Back to Proposals
            </a>
        </div>

        <!-- Main Proposal Details Card matching screenshot -->
        <div class="card p-4 pastel-card mb-4">
            <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                <div>
                    <h3 class="fw-bold mb-1 text-brand" style="font-size: 1.4rem;">Community Garden Project</h3>
                    <div class="d-flex align-items-center gap-1.5 text-muted small" style="font-size: 0.85rem;">
                        <i class="fa-regular fa-user"></i> Dahyun
                    </div>
                </div>
                <div class="d-flex gap-1.5">
                    <span class="badge rounded-pill bg-warning text-dark px-3 py-1.5 fw-semibold" style="font-size: 0.75rem;">Voting</span>
                    <span class="badge rounded-pill text-success px-3 py-1.5 fw-semibold" style="background-color: rgba(25, 135, 84, 0.15); font-size: 0.75rem;">Open for Voting</span>
                </div>
            </div>

            <p class="text-muted mt-2 mb-4" style="font-size: 0.95rem; line-height: 1.5;">Start a community garden where members can grow vegetables and flowers together</p>

            <!-- Info Pills Grid -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="info-pill-box">
                        <i class="fa-solid fa-location-dot text-secondary"></i>
                        <span>Carmona Community Center</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-pill-box">
                        <i class="fa-regular fa-clock text-secondary"></i>
                        <span>Ongoing</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-pill-box">
                        <i class="fa-regular fa-calendar text-secondary"></i>
                        <span>Proposed date: May 30, 2026</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-pill-box">
                        <i class="fa-regular fa-hourglass-half text-secondary"></i>
                        <span>Voting deadline: May 31, 2026</span>
                    </div>
                </div>
            </div>

            <!-- Vote Summary Box matching screenshot -->
            <div class="bg-light border rounded-3 p-3 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 0.85rem;">
                    <span class="text-dark fw-bold">Vote Summary</span>
                    <span class="text-muted">6 total votes</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 0.8rem;">
                    <span class="text-dark">Yes: 5</span>
                    <span class="text-danger fw-semibold">No: 1</span>
                </div>
                <div class="progress mb-1" style="height: 8px; background-color: #dc3545;">
                    <div class="progress-bar" role="progressbar" style="width: 83%; background-color: var(--uya-dark-teal);"></div>
                </div>
            </div>

            <!-- Voting Action Buttons matching screenshot -->
            <div class="row g-3">
                <div class="col-md-6">
                    <button onclick="openFeedbackModal('YES')" class="btn w-100 rounded-pill py-2.5 fw-semibold custom-btn-filled d-flex align-items-center justify-content-center gap-2 shadow-sm" style="font-size: 0.9rem;">
                        <i class="fa-regular fa-thumbs-up"></i> Vote Yes
                    </button>
                </div>
                <div class="col-md-6">
                    <button onclick="openFeedbackModal('NO')" class="btn w-100 rounded-pill py-2.5 fw-semibold border border-danger text-danger bg-white d-flex align-items-center justify-content-center gap-2 shadow-sm" style="font-size: 0.9rem;">
                        <i class="fa-regular fa-thumbs-down"></i> Vote No
                    </button>
                </div>
            </div>

        </div>

    </div>

    <!-- Vote & Feedback Modal Popup -->
    <div class="modal fade" id="voteFeedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">Share your thoughts on this proposal</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="p-3 rounded-3 mb-3 border bg-light" id="voteSelectionNotice" style="font-size: 0.85rem; line-height: 1.4;">
                    You selected <strong>YES</strong>. Add short feedback so the proposer and officers can understand your vote.
                </div>

                <div class="mb-4">
                    <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Thoughts on this proposal</label>
                    <textarea class="form-control rounded-4 p-3 shadow-none border" rows="4" placeholder="Example: This activity is helpful because..." style="font-size: 0.9rem; resize: none;" required></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light border rounded-pill py-2 w-50 fw-semibold text-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn rounded-pill py-2 w-50 fw-semibold text-white shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: var(--uya-dark-teal);" onclick="submitVoteAndFeedback()">
                        <i class="fa-regular fa-comment-dots"></i> Submit Vote &amp; Feedback
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openFeedbackModal(voteType) {
            const noticeBox = document.getElementById('voteSelectionNotice');
            if (voteType === 'YES') {
                noticeBox.innerHTML = `You selected <strong>YES</strong>. Add short feedback so the proposer and officers can understand your vote.`;
            } else {
                noticeBox.innerHTML = `You selected <strong>NO</strong>. Add short feedback so the proposer and officers can understand your vote.`;
            }
            const modal = new bootstrap.Modal(document.getElementById('voteFeedbackModal'));
            modal.show();
        }

        function submitVoteAndFeedback() {
            alert('Vote and feedback submitted successfully!');
            const modalEl = document.getElementById('voteFeedbackModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
        }
    </script>
</body>
</html>
