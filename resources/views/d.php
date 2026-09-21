<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $activity->title }} Details - UYA Connect</title>

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
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        @media (min-width: 1400px) {
            .app-container {
                padding-left: 2.5rem;
                padding-right: 2.5rem;
            }
        }

        .pastel-card {
            background-color: #ffffff;
            border: 1px solid #dce5e8 !important;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.04);
            border-radius: 16px;
        }

        .info-box {
            background-color: #f8fafc;
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

        /* 1:1 Grid Gallery Styles */
        .ig-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }
        .ig-grid-item {
            position: relative;
            width: 100%;
            padding-top: 100%;
            overflow: hidden;
            border-radius: 10px;
            background-color: #0d1117;
            cursor: pointer;
        }
        .ig-grid-item img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.25s ease, filter 0.25s ease;
        }
        .ig-grid-item:hover img {
            transform: scale(1.05);
            filter: brightness(0.85);
        }

        /* Multi-Photo Count Badge Overlay */
        .multi-photo-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(4px);
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 2;
        }

        .star-rating i {
            cursor: pointer;
            font-size: 1.25rem;
            color: #cbd5e1;
            transition: color 0.15s ease;
        }
        .star-rating i.active {
            color: #f59e0b;
        }
    </style>
</head>
<body>

    @include('layouts.navbar')

    <div class="app-container py-3 py-md-4">

        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ route('activities') }}" class="btn btn-light border rounded-pill px-3 py-2 fw-semibold text-brand shadow-sm d-inline-flex align-items-center gap-2" style="font-size: 0.85rem;">
                <i class="fa-solid fa-arrow-left"></i> Back to Activities
            </a>
        </div>

        <!-- Main Banner Header Card -->
        <div class="card p-3 p-md-4 pastel-card mb-4">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h3 class="fw-bold mb-0 text-brand fs-4 fs-md-3">{{ $activity->title }}</h3>
                    <span class="badge rounded-pill bg-success bg-opacity-15 text-success border border-success border-opacity-25 px-3 py-1.5 fw-semibold" style="font-size: 0.75rem;">
                        {{ ucfirst($activity->status) }}
                    </span>
                </div>
            </div>
            <p class="text-muted mb-4 small">{{ $activity->description }}</p>

            <!-- Metadata Info Grid -->
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <div class="info-box h-100">
                        <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">Date</span>
                        <div class="fw-semibold text-dark d-flex align-items-center gap-2 small">
                            <i class="fa-regular fa-calendar text-secondary"></i> {{ $activity->date->format('M j, Y') }}
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="info-box h-100">
                        <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">Location</span>
                        <div class="fw-semibold text-dark d-flex align-items-center gap-2 small text-truncate">
                            <i class="fa-solid fa-location-dot text-secondary"></i> {{ $activity->location ?? 'TBD' }}
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="info-box h-100">
                        <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">Organizer</span>
                        <div class="fw-semibold text-dark d-flex align-items-center gap-2 small">
                            <i class="fa-regular fa-user text-secondary"></i> {{ $activity->organizer_name ?? 'Admin' }}
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="info-box h-100">
                        <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">Duration</span>
                        <div class="fw-semibold text-dark d-flex align-items-center gap-2 small">
                            <i class="fa-regular fa-clock text-secondary"></i> {{ $activity->duration ?? 'Not set' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            $groupedPhotos = $activity->photos->groupBy(function ($photo) {
                return $photo->batch_id ?? ('single_' . $photo->id);
            });
        @endphp

        <!-- Admin-Style Side-by-Side Content Grid -->
        <div class="row g-4">
            <!-- Documentation Column (Left) -->
            <div class="col-12 col-lg-7">
                <div class="card p-3 p-md-4 pastel-card h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2 text-brand fw-bold" style="font-size: 1rem;">
                            <i class="fa-regular fa-images"></i> Event Gallery ({{ $groupedPhotos->count() }} Posts)
                        </div>
                    </div>

                    @if($groupedPhotos->count() > 0)
                        <div class="ig-grid">
                            @foreach($groupedPhotos as $batchId => $photos)
                                @php
                                    $coverPhoto = $photos->first();
                                    $photoCount = $photos->count();
                                    $batchJson = json_encode($photos->map(function($p) {
                                        return [
                                            'id' => $p->id,
                                            'url' => asset('storage/' . $p->photo_path),
                                            'caption' => $p->caption ?? 'No caption provided.'
                                        ];
                                    })->values());
                                @endphp
                                <div class="ig-grid-item" onclick='openSlideshowModal({{ $batchJson }})'>
                                    <img src="{{ asset('storage/' . $coverPhoto->photo_path) }}" alt="Documentation Photo">
                                    @if($photoCount > 1)
                                        <div class="multi-photo-badge">
                                            <i class="fa-solid fa-layer-group me-1"></i> {{ $photoCount }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-5 info-box">
                            <i class="fa-regular fa-images fa-2x mb-2 opacity-50 d-block"></i>
                            No documentation photos uploaded yet.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Feedback Column (Right) -->
            <div class="col-12 col-lg-5">
                <div class="card p-3 p-md-4 pastel-card h-100">
                    <div class="d-flex align-items-center gap-2 text-brand fw-bold mb-3" style="font-size: 1rem;">
                        <i class="fa-regular fa-comment"></i> Your Feedback
                    </div>

                    @if($userFeedback)
                        <div class="info-box">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-semibold text-dark small">Feedback Submitted</span>
                                <div class="text-warning small">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-{{ $i <= $userFeedback->rating ? 'solid' : 'regular' }} fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-muted small mb-0">{{ $userFeedback->comments }}</p>
                        </div>
                    @else
                        <div class="info-box d-flex flex-column gap-3">
                            <span class="text-muted small">Share your experience from this finished activity.</span>
                            <button onclick="openFeedbackModal()" class="btn rounded-pill py-2.5 fw-semibold custom-btn-filled d-flex align-items-center justify-content-center gap-2 shadow-sm w-100" style="font-size: 0.85rem;">
                                <i class="fa-regular fa-comment-dots"></i> Add Feedback
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- Member Carousel Slideshow Modal -->
    <div class="modal fade" id="slideshowModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 overflow-hidden rounded-4 shadow-lg">
                <div class="row g-0">
                    <div class="col-12 col-md-7 bg-black position-relative d-flex align-items-center justify-content-center" style="min-height: 360px;">
                        <div id="lightboxCarousel" class="carousel slide w-100" data-bs-ride="false">
                            <div class="carousel-inner" id="carouselInner"></div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>

                    <div class="col-12 col-md-5 p-3.5 d-flex flex-column justify-content-between bg-white border-start">
                        <div>
                            <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom">
                                <div>
                                    <span class="fw-bold text-dark small d-block">Documentation Gallery</span>
                                    <span class="text-muted micro-text d-block" style="font-size: 0.68rem;" id="carouselCounter">Photo 1 of 1</span>
                                </div>
                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <p id="slideshowCaption" class="text-muted small mb-3" style="line-height: 1.5; font-size: 0.85rem;"></p>
                        </div>

                        <div class="pt-3 border-top text-end">
                            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Activity Feedback Modal Popup -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.1rem;">Add Activity Feedback</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('activities.feedback.store', $activity->id) }}">
                    @csrf
                    <div class="mb-3">
                        <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">Activity</span>
                        <h6 class="fw-bold text-brand mb-0" style="font-size: 0.95rem;">{{ $activity->title }}</h6>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Rating</label>
                        <div class="star-rating d-flex gap-2" id="starRatingContainer">
                            <i class="fa-solid fa-star active" data-value="1"></i>
                            <i class="fa-solid fa-star active" data-value="2"></i>
                            <i class="fa-solid fa-star active" data-value="3"></i>
                            <i class="fa-solid fa-star active" data-value="4"></i>
                            <i class="fa-solid fa-star active" data-value="5"></i>
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="5">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Your Feedback</label>
                        <textarea name="comments" class="form-control rounded-4 p-3 shadow-none border" rows="3" placeholder="Share your thoughts about this activity..." required style="font-size: 0.88rem; resize: none;"></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light border rounded-pill py-2 w-50 fw-semibold text-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-btn-filled rounded-pill py-2 w-50 fw-semibold shadow-sm">Submit Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentBatchPhotos = [];

        function openFeedbackModal() {
            const modal = new bootstrap.Modal(document.getElementById('feedbackModal'));
            modal.show();
        }

        function openSlideshowModal(photosList) {
            currentBatchPhotos = photosList;
            const inner = document.getElementById('carouselInner');
            inner.innerHTML = '';

            photosList.forEach((photo, index) => {
                const item = document.createElement('div');
                item.className = `carousel-item ${index === 0 ? 'active' : ''}`;
                item.innerHTML = `
                    <div class="d-flex align-items-center justify-content-center" style="height: 420px; background: #000;">
                        <img src="${photo.url}" class="img-fluid" style="max-height: 100%; width: 100%; object-fit: contain;">
                    </div>
                `;
                inner.appendChild(item);
            });

            updateCarouselMetadata(0);

            const carouselElem = document.getElementById('lightboxCarousel');
            carouselElem.addEventListener('slid.bs.carousel', function (e) {
                updateCarouselMetadata(e.to);
            });

            const modal = new bootstrap.Modal(document.getElementById('slideshowModal'));
            modal.show();
        }

        function updateCarouselMetadata(index) {
            if (currentBatchPhotos.length > 0 && currentBatchPhotos[index]) {
                const photo = currentBatchPhotos[index];
                document.getElementById('slideshowCaption').innerText = photo.caption || 'No caption provided.';
                document.getElementById('carouselCounter').innerText = `Photo ${index + 1} of ${currentBatchPhotos.length}`;
            }
        }

        document.querySelectorAll('#starRatingContainer i').forEach(star => {
            star.addEventListener('click', function () {
                const val = parseInt(this.getAttribute('data-value'), 10);
                document.getElementById('ratingInput').value = val;

                document.querySelectorAll('#starRatingContainer i').forEach((s, idx) => {
                    if (idx < val) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });
        });
    </script>
</body>
</html>
