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

        /* =============================================
           PHOTO GALLERY GRID
           ============================================= */
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 0.5rem;
        }
        .photo-thumb {
            position: relative;
            aspect-ratio: 1 / 1;
            border-radius: 10px;
            overflow: hidden;
            cursor: zoom-in;
            background-color: #eaf1f3;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }
        .photo-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }
        .photo-thumb:hover {
            box-shadow: 0 4px 12px rgba(34, 77, 91, 0.18);
            transform: translateY(-2px);
        }
        .photo-thumb:hover img {
            transform: scale(1.05);
        }
        .photo-thumb__count {
            position: absolute;
            bottom: 6px;
            right: 6px;
            background-color: rgba(0, 0, 0, 0.6);
            color: #fff;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 0.15rem 0.45rem;
            border-radius: 50rem;
            backdrop-filter: blur(4px);
        }
        .photo-thumb--more::after {
            content: '';
            position: absolute;
            inset: 0;
            background-color: rgba(34, 77, 91, 0.55);
        }
        .photo-thumb--more span {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 0.95rem;
            z-index: 1;
        }

        /* =============================================
           LIGHTBOX
           ============================================= */
        .lightbox {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.85);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            backdrop-filter: blur(6px);
        }
        .lightbox.is-open {
            display: flex;
            animation: lightbox-fade 0.2s ease;
        }
        @keyframes lightbox-fade {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        .lightbox__img {
            max-width: 92vw;
            max-height: 82vh;
            border-radius: 14px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            object-fit: contain;
        }
        .lightbox__close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.15);
            color: #fff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        .lightbox__close:hover {
            background-color: rgba(255,255,255,0.3);
        }
        .lightbox__caption {
            position: absolute;
            bottom: 1.25rem;
            left: 50%;
            transform: translateX(-50%);
            color: #fff;
            font-size: 0.85rem;
            text-align: center;
            max-width: 90vw;
            opacity: 0.9;
        }

        /* =============================================
           MOBILE-FIRST COMPACT LAYOUT
           ============================================= */
        @media (max-width: 575.98px) {
            body {
                padding-top: 75px;
            }
            .container-fluid {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }

            /* Back button */
            .back-btn {
                font-size: 0.78rem !important;
                padding: 0.4rem 0.85rem !important;
            }

            /* Header card */
            .pastel-card {
                padding: 1rem !important;
                border-radius: 0.85rem !important;
            }
            .pastel-card h3 {
                font-size: 1.05rem;
            }
            .pastel-card > p.text-muted {
                font-size: 0.82rem !important;
                margin-bottom: 0.85rem !important;
            }
            .pastel-card .badge {
                font-size: 0.62rem !important;
                padding: 0.2rem 0.55rem !important;
            }

            /* Info boxes — compact 2x2 grid */
            .info-box {
                padding: 0.6rem 0.7rem;
                border-radius: 10px;
            }
            .info-box .text-muted {
                font-size: 0.6rem !important;
            }
            .info-box .fw-semibold {
                font-size: 0.78rem !important;
                gap: 0.3rem;
            }
            .info-box .fw-semibold i {
                font-size: 0.75rem;
            }

            /* Photo grid — tighter gaps and smaller thumbs on mobile */
            .photo-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 0.4rem;
            }
            .photo-thumb {
                border-radius: 8px;
            }
            .photo-thumb__count {
                font-size: 0.6rem;
                padding: 0.1rem 0.35rem;
                bottom: 4px;
                right: 4px;
            }

            /* Feedback card */
            .feedback-cta {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 0.65rem;
                padding: 0.7rem 0.85rem !important;
            }
            .feedback-cta span {
                font-size: 0.78rem !important;
            }
            .feedback-cta .btn {
                width: 100%;
                justify-content: center;
                font-size: 0.78rem !important;
                padding: 0.5rem 0.85rem !important;
            }

            /* Section heading */
            .section-heading {
                font-size: 0.88rem !important;
            }
            .section-sub {
                font-size: 0.7rem !important;
                margin-bottom: 0.6rem !important;
            }
        }
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <div class="container-fluid py-4">

        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('activities') }}" class="btn btn-light border rounded-pill px-3 py-2 fw-semibold text-brand shadow-sm d-inline-flex align-items-center gap-2 back-btn" style="font-size: 0.85rem;">
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

        <!-- Bottom: Documentation (left) + Feedback (right corner) -->
        <div class="row g-4">
            <!-- Documentation Section -->
            <div class="col-lg-8">
                <div class="card rounded-4 p-4 pastel-card">
                    <div class="d-flex align-items-center gap-2 text-brand fw-bold mb-1 section-heading" style="font-size: 1rem;">
                        <i class="fa-regular fa-images"></i> Documentation
                    </div>
                    <p class="text-muted small mb-3 section-sub">Event photos uploaded by admin or coordinator are visible to members.</p>

                    <div class="photo-grid">
                        <div class="photo-thumb" onclick="openLightbox(this)" data-src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&q=80&w=1200" data-caption="Group Presentation — Uploaded by Nayeon">
                            <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&q=80&w=300" alt="Group Presentation">
                        </div>
                        <div class="photo-thumb" onclick="openLightbox(this)" data-src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?auto=format&fit=crop&q=80&w=1200" data-caption="Cultural Performance">
                            <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?auto=format&fit=crop&q=80&w=300" alt="Cultural Performance">
                        </div>
                        <div class="photo-thumb" onclick="openLightbox(this)" data-src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&q=80&w=1200" data-caption="International Cuisine">
                            <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&q=80&w=300" alt="International Cuisine">
                        </div>
                        <div class="photo-thumb" onclick="openLightbox(this)" data-src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&q=80&w=1200" data-caption="Event Setup">
                            <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&q=80&w=300" alt="Event Setup">
                        </div>
                        <div class="photo-thumb" onclick="openLightbox(this)" data-src="https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?auto=format&fit=crop&q=80&w=1200" data-caption="Crowd Shot">
                            <img src="https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?auto=format&fit=crop&q=80&w=300" alt="Crowd Shot">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feedback Section (right corner) -->
            <div class="col-lg-4">
                <div class="card rounded-4 p-4 pastel-card">
                    <div class="d-flex align-items-center gap-2 text-brand fw-bold mb-3 section-heading" style="font-size: 1rem;">
                        <i class="fa-regular fa-comment"></i> Your Feedback
                    </div>

                    <div class="info-box d-flex justify-content-between align-items-center flex-wrap gap-3 feedback-cta">
                        <span class="text-muted" style="font-size: 0.9rem;">Share your experience from this finished activity.</span>
                        <button onclick="openFeedbackModal()" class="btn rounded-pill px-4 py-2 fw-semibold custom-btn-filled d-flex align-items-center gap-2 shadow-sm" style="font-size: 0.85rem;">
                            <i class="fa-regular fa-comment-dots"></i> Add Feedback
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Photo Lightbox -->
    <div class="lightbox" id="lightbox" onclick="if(event.target===this)closeLightbox()">
        <button class="lightbox__close" onclick="closeLightbox()" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <img class="lightbox__img" id="lightboxImg" src="" alt="">
        <div class="lightbox__caption" id="lightboxCaption"></div>
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

        /* --------------------------------------------------
           Photo lightbox
           -------------------------------------------------- */
        function openLightbox(thumb) {
            const lightbox = document.getElementById('lightbox');
            const img = document.getElementById('lightboxImg');
            const caption = document.getElementById('lightboxCaption');
            img.src = thumb.getAttribute('data-src');
            caption.textContent = thumb.getAttribute('data-caption') || '';
            lightbox.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.remove('is-open');
            document.body.style.overflow = '';
            document.getElementById('lightboxImg').src = '';
        }

        // Close on backdrop click or Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLightbox();
        });
    </script>
</body>
</html>
