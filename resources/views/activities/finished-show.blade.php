<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cultural Night Details - UYA Connect</title>

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
            padding-left: 2rem !important;
            padding-right: 2rem !important;
        }

        .pastel-card {
            background-color: #ffffff;
            border: 1px solid #dce5e8 !important;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.04);
        }

        .info-box {
            background-color: #f3f7f9;
            border: 1px solid #dce5e8;
            border-radius: 12px;
            padding: 1rem;
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

        .doc-card {
            background-color: #f3f7f9;
            border: 1px solid #dce5e8;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.2s ease;
        }
        .doc-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <div class="container-fluid py-4" style="max-width: 1100px;">

        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('activities') }}" class="btn btn-light border rounded-pill px-3 py-2 fw-semibold text-brand shadow-sm d-inline-flex align-items-center gap-2" style="font-size: 0.85rem;">
                <i class="fa-solid fa-arrow-left"></i> Back to Activities
            </a>
        </div>

        <!-- Main Header Card -->
        <div class="card rounded-4 p-4 pastel-card mb-4">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="d-flex align-items-center gap-3">
                    <h3 class="fw-bold mb-0 text-brand">Cultural Night</h3>
                    <span class="badge rounded-pill bg-success bg-opacity-15 text-success px-3 py-1.5 fw-semibold" style="font-size: 0.75rem;">Completed</span>
                </div>
            </div>
            <p class="text-muted mb-4" style="font-size: 0.95rem;">Celebrate diversity with cultural performances and international cuisine.</p>

            <!-- Info Grid Boxes -->
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <div class="info-box h-100">
                        <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">Date</span>
                        <div class="fw-semibold text-dark d-flex align-items-center gap-2" style="font-size: 0.9rem;">
                            <i class="fa-regular fa-calendar text-secondary"></i> May 18, 2026
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="info-box h-100">
                        <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">Location</span>
                        <div class="fw-semibold text-dark d-flex align-items-center gap-2" style="font-size: 0.9rem;">
                            <i class="fa-solid fa-location-dot text-secondary"></i> CvSU Role Hall
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="info-box h-100">
                        <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">Organizer</span>
                        <div class="fw-semibold text-dark d-flex align-items-center gap-2" style="font-size: 0.9rem;">
                            <i class="fa-regular fa-user text-secondary"></i> Nayeon
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="info-box h-100">
                        <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">Duration</span>
                        <div class="fw-semibold text-dark d-flex align-items-center gap-2" style="font-size: 0.9rem;">
                            <i class="fa-regular fa-clock text-secondary"></i> Not set
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Your Feedback Section Card -->
        <div class="card rounded-4 p-4 pastel-card mb-4">
            <div class="d-flex align-items-center gap-2 text-brand fw-bold mb-3" style="font-size: 1rem;">
                <i class="fa-regular fa-comment"></i> Your Feedback
            </div>

            <div class="info-box d-flex justify-content-between align-items-center flex-wrap gap-3">
                <span class="text-muted" style="font-size: 0.9rem;">Share your experience from this finished activity.</span>
                <button onclick="openFeedbackModal()" class="btn rounded-pill px-4 py-2 fw-semibold custom-btn-filled d-flex align-items-center gap-2 shadow-sm" style="font-size: 0.85rem;">
                    <i class="fa-regular fa-comment-dots"></i> Add Feedback
                </button>
            </div>
        </div>

        <!-- Documentation Section Card -->
        <div class="card rounded-4 p-4 pastel-card">
            <div class="d-flex align-items-center gap-2 text-brand fw-bold mb-1" style="font-size: 1rem;">
                <i class="fa-regular fa-images"></i> Documentation
            </div>
            <p class="text-muted small mb-3">Event photos uploaded by admin or coordinator are visible to members.</p>

            <div class="row">
                <div class="col-md-4">
                    <div class="doc-card p-3">
                        <div class="rounded-3 overflow-hidden mb-3 shadow-sm" style="height: 180px;">
                            <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&q=80&w=600" alt="Group Presentation" class="w-100 h-100 object-fit-cover">
                        </div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">Group Presentation</h6>
                        <span class="text-muted" style="font-size: 0.75rem;">Uploaded by Nayeon • 2026-03-15</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Add Activity Feedback Modal Popup -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">Add Activity Feedback</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="mb-3">
                    <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">Activity</span>
                    <h6 class="fw-bold text-brand mb-0" style="font-size: 1rem;">Cultural Night</h6>
                </div>

                <div class="mb-3">
                    <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Feedback Type</label>
                    <select class="form-select rounded-pill py-2 shadow-none border" style="font-size: 0.9rem;">
                        <option selected disabled>Select feedback type</option>
                        <option value="general">General Experience</option>
                        <option value="suggestion">Suggestion for Improvement</option>
                        <option value="praise">Praise / Appreciation</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Your Feedback</label>
                    <textarea class="form-control rounded-4 p-3 shadow-none border" rows="4" placeholder="Share your thoughts about this activity" style="font-size: 0.9rem; resize: none;"></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light border rounded-pill py-2 w-50 fw-semibold text-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn rounded-pill py-2 w-50 fw-semibold text-white shadow-sm" style="background-color: var(--uya-dark-teal);" onclick="submitFeedback()">Submit Feedback</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openFeedbackModal() {
            const modal = new bootstrap.Modal(document.getElementById('feedbackModal'));
            modal.show();
        }

        function submitFeedback() {
            alert('Feedback submitted successfully!');
            const modalEl = document.getElementById('feedbackModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
        }
    </script>
</body>
</html>
