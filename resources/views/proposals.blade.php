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
            padding-left: 2.5rem !important;
            padding-right: 2.5rem !important;
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

    <div class="container-fluid py-4" id="proposalsMainView">

        <!-- Header & Action Section -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h2 class="fw-bold mb-1 text-brand">Activity Proposals</h2>
                <p class="text-muted small mb-0">Submit, review, revise, and vote on member activity proposals.</p>
            </div>
            <button onclick="toggleCreateView(true)"
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
                    <button class="nav-link active shadow-sm" id="other-proposals-tab" data-bs-toggle="pill"
                        data-bs-target="#tab-other-proposals" type="button" role="tab">
                        <i class="fa-solid fa-list-check me-1"></i> Proposals <span
                            class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">6</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link shadow-sm" id="my-proposals-tab" data-bs-toggle="pill"
                        data-bs-target="#tab-my-proposals" type="button" role="tab">
                        <i class="fa-solid fa-user-pen me-1"></i> My Proposals <span
                            class="badge bg-white text-dark ms-1 rounded-pill" style="font-size: 0.65rem;">3</span>
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="proposalTabsContent">

            <!-- TAB 1: Proposals (6 Mock Items in 3-column grid with increased card padding & spacing) -->
            <div class="tab-pane fade show active" id="tab-other-proposals" role="tabpanel">
                <div class="row g-4">

                    <!-- Proposal 1 -->
                    <div class="col-xl-4 col-md-6">
                        <div class="card p-4 proposal-item shadow-sm h-100 d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2.5 gap-2">
                                    <h5 class="fw-bold mb-0 text-brand" style="font-size: 1rem;">Community Garden
                                        Project</h5>
                                    <div class="d-flex gap-1 flex-shrink-0">
                                        <span class="badge rounded-pill bg-warning text-dark px-2.5 py-1 fw-semibold"
                                            style="font-size: 0.65rem;">Voting</span>
                                        <span class="badge rounded-pill text-success px-2.5 py-1 fw-semibold"
                                            style="background-color: rgba(25, 135, 84, 0.15); font-size: 0.65rem;">Open</span>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3" style="font-size: 0.85rem; line-height: 1.4;">Start a
                                    community garden where members can grow vegetables and flowers together.</p>

                                <div class="d-flex flex-wrap gap-1.5 mb-3">
                                    <div class="info-pill"><i class="fa-regular fa-user text-secondary"></i> Dahyun
                                    </div>
                                    <div class="info-pill"><i class="fa-solid fa-location-dot text-secondary"></i>
                                        Carmona</div>
                                    <div class="info-pill"><i class="fa-regular fa-clock text-secondary"></i> Ongoing
                                    </div>
                                    <div class="info-pill"><i class="fa-regular fa-calendar text-secondary"></i> August
                                        15</div>
                                </div>

                                <div class="bg-light border rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2"
                                        style="font-size: 0.8rem;">
                                        <span class="text-muted fw-semibold">Voting Summary</span>
                                        <span class="text-muted">6 total votes</span>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            <div class="p-2 rounded-2 border border-success border-opacity-25 d-flex justify-content-between align-items-center"
                                                style="background-color: #e8f8f0;">
                                                <span class="text-success fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-up me-1"></i> Yes</span>
                                                <span class="fw-bold text-success" style="font-size: 0.8rem;">5</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div
                                                class="p-2 rounded-2 bg-white border border-danger border-opacity-25 d-flex justify-content-between align-items-center">
                                                <span class="text-danger fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-down me-1"></i> No</span>
                                                <span class="fw-bold text-danger" style="font-size: 0.8rem;">1</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress mb-1.5" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 83%;">
                                        </div>
                                    </div>
                                    <div class="text-end text-muted" style="font-size: 0.7rem;">83% approval</div>
                                </div>
                            </div>

                            <div class="d-flex flex-column gap-2 pt-2">
                                <a href="{{ route('view-detail') }}"
                                    class="btn btn-sm rounded-pill py-2 fw-semibold custom-btn-outline"
                                    style="font-size: 0.8rem;">View Details</a>
                                <div class="bg-light border rounded-3 p-2 text-center">
                                    <span class="text-muted d-block mb-1.5" style="font-size: 0.7rem;">Cast your
                                        vote</span>
                                    <div class="d-flex gap-2">
                                        <button onclick="openFeedbackModal('YES', 'Community Garden Project')"
                                            class="btn btn-sm rounded-pill w-50 py-1.5 fw-semibold text-white custom-btn-filled"
                                            style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-up me-1"></i>
                                            Yes</button>
                                        <button onclick="openFeedbackModal('NO', 'Community Garden Project')"
                                            class="btn btn-sm rounded-pill w-50 py-1.5 fw-semibold border border-danger text-danger bg-white"
                                            style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-down me-1"></i>
                                            No</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Proposal 2 -->
                    <div class="col-xl-4 col-md-6">
                        <div class="card p-4 proposal-item shadow-sm h-100 d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2.5 gap-2">
                                    <h5 class="fw-bold mb-0 text-brand" style="font-size: 1rem;">Peer Tutoring Circle
                                    </h5>
                                    <div class="d-flex gap-1 flex-shrink-0">
                                        <span class="badge rounded-pill bg-dark text-white px-2.5 py-1 fw-semibold"
                                            style="font-size: 0.65rem;">Closed</span>
                                        <span class="badge rounded-pill text-success px-2.5 py-1 fw-semibold"
                                            style="background-color: rgba(25, 135, 84, 0.15); font-size: 0.65rem;">Approved</span>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3" style="font-size: 0.85rem; line-height: 1.4;">A small
                                    study-support circle where members help other youth with basic school subjects.</p>

                                <div class="d-flex flex-wrap gap-1.5 mb-3">
                                    <div class="info-pill"><i class="fa-regular fa-user text-secondary"></i> Sana
                                    </div>
                                    <div class="info-pill"><i class="fa-solid fa-location-dot text-secondary"></i> UYA
                                        Hall</div>
                                    <div class="info-pill"><i class="fa-regular fa-clock text-secondary"></i> 2 hours
                                    </div>
                                    <div class="info-pill"><i class="fa-regular fa-calendar text-secondary"></i>
                                        August 18</div>
                                </div>

                                <div class="bg-light border rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2"
                                        style="font-size: 0.8rem;">
                                        <span class="text-muted fw-semibold">Voting Summary</span>
                                        <span class="text-muted">33 total votes</span>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            <div class="p-2 rounded-2 border border-success border-opacity-25 d-flex justify-content-between align-items-center"
                                                style="background-color: #e8f8f0;">
                                                <span class="text-success fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-up me-1"></i> Yes</span>
                                                <span class="fw-bold text-success"
                                                    style="font-size: 0.8rem;">31</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div
                                                class="p-2 rounded-2 bg-white border border-danger border-opacity-25 d-flex justify-content-between align-items-center">
                                                <span class="text-danger fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-down me-1"></i> No</span>
                                                <span class="fw-bold text-danger" style="font-size: 0.8rem;">2</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress mb-1.5" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 94%;">
                                        </div>
                                    </div>
                                    <div class="text-end text-muted" style="font-size: 0.7rem;">94% approval</div>
                                </div>
                            </div>

                            <div class="d-flex flex-column gap-2 pt-2">
                                <a href="{{ route('view-detail') }}"
                                    class="btn btn-sm rounded-pill py-2 fw-semibold custom-btn-outline"
                                    style="font-size: 0.8rem;">View Details</a>
                                <div class="bg-light border rounded-3 py-2 text-center text-muted small"
                                    style="font-size: 0.75rem;">
                                    Voting is already closed for this proposal.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Proposal 3 -->
                    <div class="col-xl-4 col-md-6">
                        <div class="card p-4 proposal-item shadow-sm h-100 d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2.5 gap-2">
                                    <h5 class="fw-bold mb-0 text-brand" style="font-size: 1rem;">Open Mic Night</h5>
                                    <div class="d-flex gap-1 flex-shrink-0">
                                        <span class="badge rounded-pill bg-dark text-white px-2.5 py-1 fw-semibold"
                                            style="font-size: 0.65rem;">Closed</span>
                                        <span class="badge rounded-pill text-danger px-2.5 py-1 fw-semibold"
                                            style="background-color: rgba(220, 53, 69, 0.15); font-size: 0.65rem;">Rejected</span>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3" style="font-size: 0.85rem; line-height: 1.4;">A
                                    casual talent-sharing night showcasing local youth music and performances.</p>

                                <div class="d-flex flex-wrap gap-1.5 mb-3">
                                    <div class="info-pill"><i class="fa-regular fa-user text-secondary"></i> Chaeyoung
                                    </div>
                                    <div class="info-pill"><i class="fa-solid fa-location-dot text-secondary"></i>
                                        Baras</div>
                                    <div class="info-pill"><i class="fa-regular fa-clock text-secondary"></i> 3 hours
                                    </div>
                                    <div class="info-pill"><i class="fa-regular fa-calendar text-secondary"></i>
                                        August 22</div>
                                </div>

                                <div class="bg-light border rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2"
                                        style="font-size: 0.8rem;">
                                        <span class="text-muted fw-semibold">Voting Summary</span>
                                        <span class="text-muted">32 total votes</span>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            <div class="p-2 rounded-2 border border-success border-opacity-25 d-flex justify-content-between align-items-center"
                                                style="background-color: #e8f8f0;">
                                                <span class="text-success fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-up me-1"></i> Yes</span>
                                                <span class="fw-bold text-success"
                                                    style="font-size: 0.8rem;">14</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div
                                                class="p-2 rounded-2 bg-white border border-danger border-opacity-25 d-flex justify-content-between align-items-center">
                                                <span class="text-danger fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-down me-1"></i> No</span>
                                                <span class="fw-bold text-danger" style="font-size: 0.8rem;">18</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress mb-1.5" style="height: 6px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 44%;">
                                        </div>
                                    </div>
                                    <div class="text-end text-muted" style="font-size: 0.7rem;">44% approval</div>
                                </div>
                            </div>

                            <div class="d-flex flex-column gap-2 pt-2">
                                <a href="{{ route('view-detail') }}"
                                    class="btn btn-sm rounded-pill py-2 fw-semibold custom-btn-outline"
                                    style="font-size: 0.8rem;">View Details</a>
                                <div class="bg-light border rounded-3 py-2 text-center text-muted small"
                                    style="font-size: 0.75rem;">
                                    Voting is already closed for this proposal.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Proposal 4 -->
                    <div class="col-xl-4 col-md-6">
                        <div class="card p-4 proposal-item shadow-sm h-100 d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2.5 gap-2">
                                    <h5 class="fw-bold mb-0 text-brand" style="font-size: 1rem;">Coding for Kids
                                        Workshop</h5>
                                    <div class="d-flex gap-1 flex-shrink-0">
                                        <span class="badge rounded-pill bg-warning text-dark px-2.5 py-1 fw-semibold"
                                            style="font-size: 0.65rem;">Voting</span>
                                        <span class="badge rounded-pill text-success px-2.5 py-1 fw-semibold"
                                            style="background-color: rgba(25, 135, 84, 0.15); font-size: 0.65rem;">Open</span>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3" style="font-size: 0.85rem; line-height: 1.4;">
                                    Introduce basic programming concepts to elementary students using interactive
                                    blocks.</p>

                                <div class="d-flex flex-wrap gap-1.5 mb-3">
                                    <div class="info-pill"><i class="fa-regular fa-user text-secondary"></i> Mina
                                    </div>
                                    <div class="info-pill"><i class="fa-solid fa-location-dot text-secondary"></i>
                                        CvSU Lab</div>
                                    <div class="info-pill"><i class="fa-regular fa-clock text-secondary"></i> Half day
                                    </div>
                                    <div class="info-pill"><i class="fa-regular fa-calendar text-secondary"></i>
                                        August 25</div>
                                </div>

                                <div class="bg-light border rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2"
                                        style="font-size: 0.8rem;">
                                        <span class="text-muted fw-semibold">Voting Summary</span>
                                        <span class="text-muted">12 total votes</span>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            <div class="p-2 rounded-2 border border-success border-opacity-25 d-flex justify-content-between align-items-center"
                                                style="background-color: #e8f8f0;">
                                                <span class="text-success fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-up me-1"></i> Yes</span>
                                                <span class="fw-bold text-success"
                                                    style="font-size: 0.8rem;">10</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div
                                                class="p-2 rounded-2 bg-white border border-danger border-opacity-25 d-flex justify-content-between align-items-center">
                                                <span class="text-danger fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-down me-1"></i> No</span>
                                                <span class="fw-bold text-danger" style="font-size: 0.8rem;">2</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress mb-1.5" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 83%;">
                                        </div>
                                    </div>
                                    <div class="text-end text-muted" style="font-size: 0.7rem;">83% approval</div>
                                </div>
                            </div>

                            <div class="d-flex flex-column gap-2 pt-2">
                                <a href="{{ route('view-detail') }}"
                                    class="btn btn-sm rounded-pill py-2 fw-semibold custom-btn-outline"
                                    style="font-size: 0.8rem;">View Details</a>
                                <div class="bg-light border rounded-3 p-2 text-center">
                                    <span class="text-muted d-block mb-1.5" style="font-size: 0.7rem;">Cast your
                                        vote</span>
                                    <div class="d-flex gap-2">
                                        <button onclick="openFeedbackModal('YES', 'Coding for Kids Workshop')"
                                            class="btn btn-sm rounded-pill w-50 py-1.5 fw-semibold text-white custom-btn-filled"
                                            style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-up me-1"></i>
                                            Yes</button>
                                        <button onclick="openFeedbackModal('NO', 'Coding for Kids Workshop')"
                                            class="btn btn-sm rounded-pill w-50 py-1.5 fw-semibold border border-danger text-danger bg-white"
                                            style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-down me-1"></i>
                                            No</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Proposal 5 -->
                    <div class="col-xl-4 col-md-6">
                        <div class="card p-4 proposal-item shadow-sm h-100 d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2.5 gap-2">
                                    <h5 class="fw-bold mb-0 text-brand" style="font-size: 1rem;">Youth Leadership
                                        Summit</h5>
                                    <div class="d-flex gap-1 flex-shrink-0">
                                        <span class="badge rounded-pill bg-warning text-dark px-2.5 py-1 fw-semibold"
                                            style="font-size: 0.65rem;">Voting</span>
                                        <span class="badge rounded-pill text-success px-2.5 py-1 fw-semibold"
                                            style="background-color: rgba(25, 135, 84, 0.15); font-size: 0.65rem;">Open</span>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3" style="font-size: 0.85rem; line-height: 1.4;">A
                                    full-day conference featuring guest speakers on community leadership and teamwork.
                                </p>

                                <div class="d-flex flex-wrap gap-1.5 mb-3">
                                    <div class="info-pill"><i class="fa-regular fa-user text-secondary"></i> Jihyo
                                    </div>
                                    <div class="info-pill"><i class="fa-solid fa-location-dot text-secondary"></i>
                                        Auditorium</div>
                                    <div class="info-pill"><i class="fa-regular fa-clock text-secondary"></i> Full day
                                    </div>
                                    <div class="info-pill"><i class="fa-regular fa-calendar text-secondary"></i>
                                        August 28</div>
                                </div>

                                <div class="bg-light border rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2"
                                        style="font-size: 0.8rem;">
                                        <span class="text-muted fw-semibold">Voting Summary</span>
                                        <span class="text-muted">20 total votes</span>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            <div class="p-2 rounded-2 border border-success border-opacity-25 d-flex justify-content-between align-items-center"
                                                style="background-color: #e8f8f0;">
                                                <span class="text-success fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-up me-1"></i> Yes</span>
                                                <span class="fw-bold text-success"
                                                    style="font-size: 0.8rem;">18</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div
                                                class="p-2 rounded-2 bg-white border border-danger border-opacity-25 d-flex justify-content-between align-items-center">
                                                <span class="text-danger fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-down me-1"></i> No</span>
                                                <span class="fw-bold text-danger" style="font-size: 0.8rem;">2</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress mb-1.5" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 90%;">
                                        </div>
                                    </div>
                                    <div class="text-end text-muted" style="font-size: 0.7rem;">90% approval</div>
                                </div>
                            </div>

                            <div class="d-flex flex-column gap-2 pt-2">
                                <a href="{{ route('view-detail') }}"
                                    class="btn btn-sm rounded-pill py-2 fw-semibold custom-btn-outline"
                                    style="font-size: 0.8rem;">View Details</a>
                                <div class="bg-light border rounded-3 p-2 text-center">
                                    <span class="text-muted d-block mb-1.5" style="font-size: 0.7rem;">Cast your
                                        vote</span>
                                    <div class="d-flex gap-2">
                                        <button onclick="openFeedbackModal('YES', 'Youth Leadership Summit')"
                                            class="btn btn-sm rounded-pill w-50 py-1.5 fw-semibold text-white custom-btn-filled"
                                            style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-up me-1"></i>
                                            Yes</button>
                                        <button onclick="openFeedbackModal('NO', 'Youth Leadership Summit')"
                                            class="btn btn-sm rounded-pill w-50 py-1.5 fw-semibold border border-danger text-danger bg-white"
                                            style="font-size: 0.75rem;"><i class="fa-regular fa-thumbs-down me-1"></i>
                                            No</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Proposal 6 -->
                    <div class="col-xl-4 col-md-6">
                        <div class="card p-4 proposal-item shadow-sm h-100 d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2.5 gap-2">
                                    <h5 class="fw-bold mb-0 text-brand" style="font-size: 1rem;">Charity Basketball
                                        League</h5>
                                    <div class="d-flex gap-1 flex-shrink-0">
                                        <span class="badge rounded-pill bg-dark text-white px-2.5 py-1 fw-semibold"
                                            style="font-size: 0.65rem;">Closed</span>
                                        <span class="badge rounded-pill text-success px-2.5 py-1 fw-semibold"
                                            style="background-color: rgba(25, 135, 84, 0.15); font-size: 0.65rem;">Approved</span>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3" style="font-size: 0.85rem; line-height: 1.4;">A
                                    weekend sports tournament to raise funds for local community outreach programs.</p>

                                <div class="d-flex flex-wrap gap-1.5 mb-3">
                                    <div class="info-pill"><i class="fa-regular fa-user text-secondary"></i> Nayeon
                                    </div>
                                    <div class="info-pill"><i class="fa-solid fa-location-dot text-secondary"></i>
                                        City Gym</div>
                                    <div class="info-pill"><i class="fa-regular fa-clock text-secondary"></i> Full day
                                    </div>
                                    <div class="info-pill"><i class="fa-regular fa-calendar text-secondary"></i>
                                        August 30</div>
                                </div>

                                <div class="bg-light border rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2"
                                        style="font-size: 0.8rem;">
                                        <span class="text-muted fw-semibold">Voting Summary</span>
                                        <span class="text-muted">40 total votes</span>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            <div class="p-2 rounded-2 border border-success border-opacity-25 d-flex justify-content-between align-items-center"
                                                style="background-color: #e8f8f0;">
                                                <span class="text-success fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-up me-1"></i> Yes</span>
                                                <span class="fw-bold text-success"
                                                    style="font-size: 0.8rem;">35</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div
                                                class="p-2 rounded-2 bg-white border border-danger border-opacity-25 d-flex justify-content-between align-items-center">
                                                <span class="text-danger fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-down me-1"></i> No</span>
                                                <span class="fw-bold text-danger" style="font-size: 0.8rem;">5</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress mb-1.5" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 87%;">
                                        </div>
                                    </div>
                                    <div class="text-end text-muted" style="font-size: 0.7rem;">87% approval</div>
                                </div>
                            </div>

                            <div class="d-flex flex-column gap-2 pt-2">
                                <a href="{{ route('view-detail') }}"
                                    class="btn btn-sm rounded-pill py-2 fw-semibold custom-btn-outline"
                                    style="font-size: 0.8rem;">View Details</a>
                                <div class="bg-light border rounded-3 py-2 text-center text-muted small"
                                    style="font-size: 0.75rem;">
                                    Voting is already closed for this proposal.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- TAB 2: My Proposals -->
            <div class="tab-pane fade" id="tab-my-proposals" role="tabpanel">
                <div class="row g-4">

                    <!-- My Proposal Item 1 -->
                    <div class="col-xl-4 col-md-6">
                        <div class="card p-4 proposal-item shadow-sm h-100 d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2.5 gap-2">
                                    <h5 class="fw-bold mb-0 text-brand" style="font-size: 1rem;">CleanUp Drive in
                                        Carmona</h5>
                                    <div class="d-flex gap-1 flex-shrink-0">
                                        <span class="badge rounded-pill bg-primary px-2.5 py-1 fw-semibold"
                                            style="font-size: 0.65rem;">Submission</span>
                                        <span class="badge rounded-pill bg-warning text-dark px-2.5 py-1 fw-semibold"
                                            style="font-size: 0.65rem;">Revision</span>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3" style="font-size: 0.85rem; line-height: 1.4;">
                                    Organize a community cleanup drive around local parks.</p>

                                <div class="d-flex flex-wrap gap-1.5 mb-3">
                                    <div class="info-pill"><i class="fa-regular fa-user text-secondary"></i> Momo
                                    </div>
                                    <div class="info-pill"><i class="fa-solid fa-location-dot text-secondary"></i>
                                        Carmona</div>
                                    <div class="info-pill"><i class="fa-regular fa-clock text-secondary"></i> 3 hours
                                    </div>
                                    <div class="info-pill"><i class="fa-regular fa-calendar text-secondary"></i>
                                        August 12</div>
                                </div>

                                <div class="bg-light border rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2"
                                        style="font-size: 0.8rem;">
                                        <span class="text-muted fw-semibold">Voting Summary</span>
                                        <span class="text-muted">0 total votes</span>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            <div class="p-2 rounded-2 border border-success border-opacity-25 d-flex justify-content-between align-items-center"
                                                style="background-color: #e8f8f0;">
                                                <span class="text-success fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-up me-1"></i> Yes</span>
                                                <span class="fw-bold text-success" style="font-size: 0.8rem;">0</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div
                                                class="p-2 rounded-2 bg-white border border-danger border-opacity-25 d-flex justify-content-between align-items-center">
                                                <span class="text-danger fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-down me-1"></i> No</span>
                                                <span class="fw-bold text-danger" style="font-size: 0.8rem;">0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress mb-1.5" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%;">
                                        </div>
                                    </div>
                                    <div class="text-end text-muted" style="font-size: 0.7rem;">0% approval</div>
                                </div>
                            </div>

                            <div class="d-flex gap-2 pt-2">
                                <a href="{{ route('details') }}"
                                    class="btn btn-sm rounded-pill py-2 w-50 fw-semibold custom-btn-outline"
                                    style="font-size: 0.8rem;">View Details</a>
                                <button type="button" onclick="openEditProposalModal()"
                                    class="btn btn-sm rounded-pill py-2 w-50 fw-semibold custom-btn-filled"
                                    style="font-size: 0.8rem;"><i class="fa-regular fa-pen-to-square me-1"></i>
                                    Edit</button>
                            </div>
                        </div>
                    </div>

                    <!-- My Proposal Item 2 -->
                    <div class="col-xl-4 col-md-6">
                        <div class="card p-4 proposal-item shadow-sm h-100 d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2.5 gap-2">
                                    <h5 class="fw-bold mb-0 text-brand" style="font-size: 1rem;">Youth Digital
                                        Literacy Bootcamp</h5>
                                    <div class="d-flex gap-1 flex-shrink-0">
                                        <span class="badge rounded-pill bg-dark text-white px-2.5 py-1 fw-semibold"
                                            style="font-size: 0.65rem;">Closed</span>
                                        <span class="badge rounded-pill text-success px-2.5 py-1 fw-semibold"
                                            style="background-color: rgba(25, 135, 84, 0.15); font-size: 0.65rem;">Approved</span>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3" style="font-size: 0.85rem; line-height: 1.4;">A
                                    beginner-friendly training program that helps youth members learn basic computer
                                    safety.</p>

                                <div class="d-flex flex-wrap gap-1.5 mb-3">
                                    <div class="info-pill"><i class="fa-regular fa-user text-secondary"></i> Momo
                                    </div>
                                    <div class="info-pill"><i class="fa-solid fa-location-dot text-secondary"></i> GMA
                                        Hall</div>
                                    <div class="info-pill"><i class="fa-regular fa-clock text-secondary"></i> 1 day
                                    </div>
                                    <div class="info-pill"><i class="fa-regular fa-calendar text-secondary"></i>
                                        August 20</div>
                                </div>

                                <div class="bg-light border rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2"
                                        style="font-size: 0.8rem;">
                                        <span class="text-muted fw-semibold">Voting Summary</span>
                                        <span class="text-muted">35 total votes</span>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            <div class="p-2 rounded-2 border border-success border-opacity-25 d-flex justify-content-between align-items-center"
                                                style="background-color: #e8f8f0;">
                                                <span class="text-success fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-up me-1"></i> Yes</span>
                                                <span class="fw-bold text-success"
                                                    style="font-size: 0.8rem;">28</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div
                                                class="p-2 rounded-2 bg-white border border-danger border-opacity-25 d-flex justify-content-between align-items-center">
                                                <span class="text-danger fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-down me-1"></i> No</span>
                                                <span class="fw-bold text-danger" style="font-size: 0.8rem;">7</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress mb-1.5" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 80%;">
                                        </div>
                                    </div>
                                    <div class="text-end text-muted" style="font-size: 0.7rem;">80% approval</div>
                                </div>
                            </div>

                            <div class="pt-2">
                                <a href="{{ route('details') }}"
                                    class="btn btn-sm rounded-pill py-2 w-100 fw-semibold custom-btn-outline"
                                    style="font-size: 0.8rem;">View Details</a>
                            </div>
                        </div>
                    </div>

                    <!-- My Proposal Item 3 -->
                    <div class="col-xl-4 col-md-6">
                        <div class="card p-4 proposal-item shadow-sm h-100 d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2.5 gap-2">
                                    <h5 class="fw-bold mb-0 text-brand" style="font-size: 1rem;">Weekend Movie Night
                                        Fundraiser</h5>
                                    <div class="d-flex gap-1 flex-shrink-0">
                                        <span class="badge rounded-pill bg-dark text-white px-2.5 py-1 fw-semibold"
                                            style="font-size: 0.65rem;">Closed</span>
                                        <span class="badge rounded-pill text-danger px-2.5 py-1 fw-semibold"
                                            style="background-color: rgba(220, 53, 69, 0.15); font-size: 0.65rem;">Rejected</span>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3" style="font-size: 0.85rem; line-height: 1.4;">A small
                                    fundraising activity proposal that did not meet the required approval threshold.</p>

                                <div class="d-flex flex-wrap gap-1.5 mb-3">
                                    <div class="info-pill"><i class="fa-regular fa-user text-secondary"></i> Momo
                                    </div>
                                    <div class="info-pill"><i class="fa-solid fa-location-dot text-secondary"></i> UYA
                                        Ctr</div>
                                    <div class="info-pill"><i class="fa-regular fa-clock text-secondary"></i> 3 hours
                                    </div>
                                    <div class="info-pill"><i class="fa-regular fa-calendar text-secondary"></i>
                                        August 24</div>
                                </div>

                                <div class="bg-light border rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2"
                                        style="font-size: 0.8rem;">
                                        <span class="text-muted fw-semibold">Voting Summary</span>
                                        <span class="text-muted">35 total votes</span>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            <div class="p-2 rounded-2 border border-success border-opacity-25 d-flex justify-content-between align-items-center"
                                                style="background-color: #e8f8f0;">
                                                <span class="text-success fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-up me-1"></i> Yes</span>
                                                <span class="fw-bold text-success"
                                                    style="font-size: 0.8rem;">20</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div
                                                class="p-2 rounded-2 bg-white border border-danger border-opacity-25 d-flex justify-content-between align-items-center">
                                                <span class="text-danger fw-semibold" style="font-size: 0.75rem;"><i
                                                        class="fa-regular fa-thumbs-down me-1"></i> No</span>
                                                <span class="fw-bold text-danger" style="font-size: 0.8rem;">15</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress mb-1.5" style="height: 6px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 57%;">
                                        </div>
                                    </div>
                                    <div class="text-end text-muted" style="font-size: 0.7rem;">57% approval</div>
                                </div>
                            </div>

                            <div class="pt-2">
                                <a href="{{ route('details') }}"
                                    class="btn btn-sm rounded-pill py-2 w-100 fw-semibold custom-btn-outline"
                                    style="font-size: 0.8rem;">View Details</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <!-- CREATE PROPOSAL VIEW CONTAINER (Updated with new fields from screenshot: Estimated Budget, Voting Deadline, Attachments, and Buttons) -->
    <div class="container-fluid py-4 d-none" style="max-width: 900px;" id="createProposalView">

        <!-- Back Button -->
        <div class="mb-4">
            <button onclick="toggleCreateView(false)"
                class="btn btn-light border rounded-pill px-3 py-2 fw-semibold text-brand shadow-sm d-inline-flex align-items-center gap-2"
                style="font-size: 0.85rem;">
                <i class="fa-solid fa-arrow-left"></i> Back to Proposals
            </button>
        </div>

        <!-- Create Proposal Form Card -->
        <div class="card p-4 pastel-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold text-brand mb-0" style="font-size: 1.15rem;">Create New Proposal</h4>
                <button type="button" class="btn-close shadow-none" onclick="toggleCreateView(false)"></button>
            </div>
            <hr class="text-muted opacity-25 mb-4">

            <form onsubmit="submitNewProposal(event)">
                <div class="mb-3">
                    <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Proposal Title
                        *</label>
                    <input type="text" class="form-control rounded-pill py-2 px-3 shadow-none border"
                        placeholder="e.g., Beach Cleanup Activity" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Location *</label>
                        <input type="text" class="form-control rounded-pill py-2 px-3 shadow-none border"
                            placeholder="e.g., Silang, Cavite" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Duration *</label>
                        <input type="text" class="form-control rounded-pill py-2 px-3 shadow-none border"
                            placeholder="e.g., 3 hours, Half day, Full day" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Proposed Date
                            *</label>
                        <div class="input-group">
                            <input type="text" class="form-control rounded-pill-start py-2 px-3 shadow-none border"
                                placeholder="mm/dd/yyyy" required>
                            <span class="input-group-text bg-white border rounded-pill-end px-3 text-muted"><i
                                    class="fa-regular fa-calendar"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Voting Deadline
                            *</label>
                        <input type="text" class="form-control rounded-pill py-2 px-3 shadow-none border bg-light"
                            value="08/20/2026" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Estimated
                        Budget</label>
                    <input type="text" class="form-control rounded-pill py-2 px-3 shadow-none border"
                        placeholder="e.g., ₱1,500">
                </div>

                <div class="mb-3">
                    <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Description *</label>
                    <textarea class="form-control rounded-4 p-3 shadow-none border" rows="4"
                        placeholder="Describe your proposal in detail..." style="resize: none;" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Attachments <span
                            class="text-muted fw-normal">(optional — PDF, DOC, DOCX)</span></label>
                    <div class="border border-dashed rounded-4 p-4 text-center bg-light"
                        style="border-style: dashed !important; border-color: #cbd9df !important;">
                        <div class="text-secondary mb-2" style="font-size: 1.25rem;"><i
                                class="fa-solid fa-paperclip"></i></div>
                        <div class="fw-semibold text-dark mb-1" style="font-size: 0.85rem;">Click to browse or drag
                            &amp; drop files here</div>
                        <div class="text-muted" style="font-size: 0.75rem;">PDF, DOC, DOCX · max 10 MB each</div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <button type="button" onclick="toggleCreateView(false)"
                        class="btn btn-light border rounded-pill px-4 py-2 fw-semibold text-secondary">Cancel</button>
                    <button type="button"
                        class="btn border rounded-pill px-4 py-2 fw-semibold text-dark bg-white shadow-sm"
                        style="border-color: #D8B257 !important;" onclick="saveAsDraft()">
                        <i class="fa-regular fa-file-lines me-1 text-warning"></i> Save as Draft
                    </button>
                    <button type="submit" class="btn rounded-pill px-4 py-2 fw-semibold text-dark shadow-sm"
                        style="background-color: var(--uya-gold);">Submit Proposal</button>
                </div>
            </form>
        </div>

    </div>

    <!-- Vote & Feedback Modal Popup -->
    <div class="modal fade" id="voteFeedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">Share your thoughts on this
                        proposal</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="p-3 rounded-3 mb-3 border bg-light" id="voteSelectionNotice"
                    style="font-size: 0.85rem; line-height: 1.4;">
                    You selected <strong>YES</strong>. Add short feedback so the proposer and officers can understand
                    your vote.
                </div>

                <div class="mb-4">
                    <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Thoughts on this
                        proposal</label>
                    <textarea class="form-control rounded-4 p-3 shadow-none border" rows="4"
                        placeholder="Example: This activity is helpful because..." style="font-size: 0.9rem; resize: none;" required></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="button"
                        class="btn btn-light border rounded-pill py-2 w-50 fw-semibold text-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button"
                        class="btn rounded-pill py-2 w-50 fw-semibold text-white shadow-sm d-flex align-items-center justify-content-center gap-2"
                        style="background-color: var(--uya-dark-teal);" onclick="submitVoteAndFeedback()">
                        <i class="fa-regular fa-comment-dots"></i> Submit Vote &amp; Feedback
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Proposal Modal Popup -->
    <div class="modal fade" id="editProposalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 900px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <h5 class="fw-bold text-brand mb-0" style="font-size: 1.15rem;">Edit Proposal</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form onsubmit="saveProposalEdit(event)">
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Proposal Title
                            *</label>
                        <input type="text" id="editTitle"
                            class="form-control rounded-pill py-2 px-3 shadow-none border"
                            value="CleanUp Drive in Carmona" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Location
                                *</label>
                            <input type="text" id="editLocation"
                                class="form-control rounded-pill py-2 px-3 shadow-none border" value="Carmona"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Duration
                                *</label>
                            <input type="text" id="editDuration"
                                class="form-control rounded-pill py-2 px-3 shadow-none border" value="3 hours"
                                required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Proposed Date
                                *</label>
                            <div class="input-group">
                                <input type="text" id="editDate"
                                    class="form-control rounded-pill-start py-2 px-3 shadow-none border"
                                    value="08/12/2026" required>
                                <span class="input-group-text bg-white border rounded-pill-end px-3 text-muted"><i
                                        class="fa-regular fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Voting
                                Deadline *</label>
                            <input type="text" id="editDeadline"
                                class="form-control rounded-pill py-2 px-3 shadow-none border bg-light"
                                value="08/20/2026" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Estimated
                            Budget</label>
                        <input type="text" id="editBudget"
                            class="form-control rounded-pill py-2 px-3 shadow-none border" value="₱1,500">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Description
                            *</label>
                        <textarea id="editDescription" class="form-control rounded-4 p-3 shadow-none border" rows="4"
                            style="resize: none;" required>Organize a community cleanup drive around local parks.</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Attachments <span
                                class="text-muted fw-normal">(optional — PDF, DOC, DOCX)</span></label>
                        <div class="border border-dashed rounded-4 p-4 text-center bg-light"
                            style="border-style: dashed !important; border-color: #cbd9df !important;">
                            <div class="text-secondary mb-2" style="font-size: 1.25rem;"><i
                                    class="fa-solid fa-paperclip"></i></div>
                            <div class="fw-semibold text-dark mb-1" style="font-size: 0.85rem;">Click to browse or
                                drag &amp; drop files here</div>
                            <div class="text-muted" style="font-size: 0.75rem;">PDF, DOC, DOCX · max 10 MB each</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <button type="button"
                            class="btn btn-light border rounded-pill px-4 py-2 fw-semibold text-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="button"
                            class="btn border rounded-pill px-4 py-2 fw-semibold text-dark bg-white shadow-sm"
                            style="border-color: #D8B257 !important;" onclick="saveProposalDraft()">
                            <i class="fa-regular fa-file-lines me-1 text-warning"></i> Save as Draft
                        </button>
                        <button type="submit" class="btn rounded-pill px-4 py-2 fw-semibold text-dark shadow-sm"
                            style="background-color: var(--uya-gold);">Update Proposal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleCreateView(showCreate) {
            const mainView = document.getElementById('proposalsMainView');
            const createView = document.getElementById('createProposalView');

            if (showCreate) {
                mainView.classList.add('d-none');
                createView.classList.remove('d-none');
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            } else {
                createView.classList.add('d-none');
                mainView.classList.remove('d-none');
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        }

        function openFeedbackModal(voteType, proposalTitle) {
            const noticeBox = document.getElementById('voteSelectionNotice');
            if (voteType === 'YES') {
                noticeBox.innerHTML =
                    `You selected <strong>YES</strong>. Add short feedback so the proposer and officers can understand your vote.`;
            } else {
                noticeBox.innerHTML =
                    `You selected <strong>NO</strong>. Add short feedback so the proposer and officers can understand your vote.`;
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

        function saveAsDraft() {
            alert('Proposal saved as draft successfully!');
            toggleCreateView(false);
        }

        function submitNewProposal(event) {
            event.preventDefault();
            alert('Proposal submitted successfully!');
            toggleCreateView(false);
        }

        function openEditProposalModal() {
            const modal = new bootstrap.Modal(document.getElementById('editProposalModal'));
            modal.show();
        }

        function saveProposalEdit(event) {
            event.preventDefault();
            alert('Proposal updated successfully!');
            const modalEl = document.getElementById('editProposalModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
        }
    </script>
</body>

</html>
