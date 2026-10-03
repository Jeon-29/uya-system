@extends('layouts.admin')

@section('title', $activity->title . ' - Activity Details')

@push('styles')
<style>
    .admin-card { background-color: var(--admin-card-bg); border: 1px solid var(--admin-border); border-radius: 16px; padding: 24px; }
    .btn-purple { background-color: var(--admin-accent-purple); color: #ffffff; border: none; border-radius: 10px; font-weight: 600; font-size: 0.85rem; padding: 9px 18px; }
    .btn-purple:hover { background-color: var(--admin-accent-purple-hover); color: #ffffff; }
    .qr-container { background: #ffffff; border-radius: 16px; padding: 16px; display: inline-block; }

    .glass-box {
        background-color: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--admin-border);
        border-radius: 12px;
    }

    .admin-modal .modal-content {
        background-color: var(--admin-card-bg);
        border: 1px solid var(--admin-border);
        color: #ffffff;
        border-radius: 16px;
    }

    /* Status Pill Styles */
    .badge-status-pill-upcoming { background-color: rgba(99, 102, 241, 0.25); color: #a5b4fc; border: 1px solid rgba(99, 102, 241, 0.45); font-size: 0.72rem; font-weight: 600; padding: 5px 14px; border-radius: 12px; display: inline-block; }
    .badge-status-pill-ongoing { background-color: rgba(245, 158, 11, 0.25); color: #fde047; border: 1px solid rgba(245, 158, 11, 0.45); font-size: 0.72rem; font-weight: 600; padding: 5px 14px; border-radius: 12px; display: inline-block; }
    .badge-status-pill-completed { background-color: rgba(34, 197, 94, 0.25); color: #86efac; border: 1px solid rgba(34, 197, 94, 0.45); font-size: 0.72rem; font-weight: 600; padding: 5px 14px; border-radius: 12px; display: inline-block; }

    /* High-contrast Completed Activity Badge */
    .badge-completed-activity {
        background-color: rgba(34, 197, 94, 0.15) !important;
        color: #4ade80 !important;
        border: 1px solid rgba(34, 197, 94, 0.4) !important;
        padding: 6px 16px !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        font-size: 0.82rem !important;
        display: inline-flex;
        align-items: center;
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
        filter: brightness(0.75);
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

    /* Dropzone Styles */
    .ig-dropzone {
        border: 2px dashed rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        background: rgba(255, 255, 255, 0.02);
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .ig-dropzone:hover {
        border-color: var(--admin-accent-purple);
        background: rgba(99, 102, 241, 0.05);
    }

    /* Preview Grid Container & Square Thumbnails */
    .preview-thumb-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 10px;
    }
    .preview-grid-card {
        position: relative;
        width: 100%;
        padding-top: 100%;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid var(--admin-border);
        background: #000;
    }
    .preview-grid-card img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .input-dark-custom {
        background-color: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid var(--admin-border) !important;
        color: #ffffff !important;
    }
    .input-dark-custom::placeholder {
        color: rgba(255, 255, 255, 0.4) !important;
    }
</style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.activities.index') }}" class="btn btn-outline-light btn-sm rounded-3 px-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Activities
        </a>

        @if($activity->status !== 'completed')
            <button type="button" onclick="confirmCompleteModal()" class="btn btn-sm btn-success rounded-3 px-3 fw-semibold">
                <i class="fa-solid fa-flag-checkered me-1"></i> Mark as Completed Early
            </button>
        @else
            <!-- Fixed High-Contrast Completed Tag -->
            <span class="badge-completed-activity">
                <i class="fa-solid fa-circle-check me-1.5"></i> Completed Activity
            </span>
        @endif
    </div>

    <!-- Main Banner Overview Card -->
    <div class="admin-card mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <h4 class="fw-bold text-white mb-0">{{ $activity->title }}</h4>
                    <span class="badge-status-pill-{{ $activity->status }}">{{ ucfirst($activity->status) }}</span>
                </div>
                <p class="text-subtle small mb-0">{{ $activity->description }}</p>
            </div>

            <div class="d-flex align-items-center gap-3 text-subtle small glass-box p-3">
                <div>
                    <span class="d-block text-muted" style="font-size: 0.7rem;">Registration</span>
                    @if($activity->status === 'completed')
                        <span class="fw-semibold text-danger" style="font-size: 0.82rem;"><i class="fa-solid fa-lock me-1"></i> Locked</span>
                    @else
                        <button type="button" onclick="confirmToggle('registration', {{ $activity->is_registration_open ? 'true' : 'false' }}, '{{ route('admin.activities.toggle-registration', $activity->id) }}')" class="btn btn-link p-0 text-decoration-none shadow-none fw-semibold {{ $activity->is_registration_open ? 'text-success' : 'text-danger' }}" style="font-size: 0.82rem;">
                            <i class="fa-solid {{ $activity->is_registration_open ? 'fa-toggle-on text-success' : 'fa-toggle-off text-muted' }} me-1"></i>
                            {{ $activity->is_registration_open ? 'Open' : 'Closed' }}
                        </button>
                    @endif
                </div>
                <div class="border-start border-white border-opacity-10 ps-3">
                    <span class="d-block text-muted" style="font-size: 0.7rem;">Attendance</span>
                    @if($activity->status === 'completed')
                        <span class="fw-semibold text-danger" style="font-size: 0.82rem;"><i class="fa-solid fa-lock me-1"></i> Locked</span>
                    @else
                        <button type="button" onclick="confirmToggle('attendance', {{ $activity->is_attendance_open ? 'true' : 'false' }}, '{{ route('admin.activities.toggle-attendance', $activity->id) }}')" class="btn btn-link p-0 text-decoration-none shadow-none fw-semibold {{ $activity->is_attendance_open ? 'text-success' : 'text-danger' }}" style="font-size: 0.82rem;">
                            <i class="fa-solid {{ $activity->is_attendance_open ? 'fa-toggle-on text-success' : 'fa-toggle-off text-muted' }} me-1"></i>
                            {{ $activity->is_attendance_open ? 'Open' : 'Closed' }}
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="row g-3 text-subtle small pt-3 border-top border-white border-opacity-10">
            <div class="col-6 col-md-2">
                <span class="text-muted d-block" style="font-size: 0.72rem;">Event Date</span>
                <span class="fw-semibold text-white"><i class="fa-regular fa-calendar me-1"></i>{{ $activity->date->format('M j, Y') }}</span>
            </div>
            <div class="col-6 col-md-2">
                <span class="text-muted d-block" style="font-size: 0.72rem;">Event Time</span>
                <span class="fw-semibold text-white"><i class="fa-regular fa-clock me-1"></i>{{ $activity->date->format('g:i A') }}</span>
            </div>
            <div class="col-6 col-md-3">
                <span class="text-muted d-block" style="font-size: 0.72rem;">Location</span>
                <span class="fw-semibold text-white"><i class="fa-solid fa-location-dot me-1"></i>{{ $activity->location ?? 'TBD' }}</span>
            </div>
            <div class="col-6 col-md-3">
                <span class="text-muted d-block" style="font-size: 0.72rem;">Organizer</span>
                <span class="fw-semibold text-white"><i class="fa-regular fa-user me-1"></i>{{ $activity->organizer_name ?? 'Admin' }}</span>
            </div>
            <div class="col-6 col-md-2">
                <span class="text-muted d-block" style="font-size: 0.72rem;">Budget</span>
                <span class="fw-semibold text-white"><i class="fa-solid fa-peso-sign me-1"></i>₱{{ number_format($activity->budget, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Attendance QR Generation Card -->
        <div class="col-12 col-lg-8">
            <div class="admin-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold text-white mb-0"><i class="fa-solid fa-qrcode me-2 text-primary"></i>Single-Use Dynamic QR Code</h6>
                    <span class="badge border border-white border-opacity-10 {{ $activity->is_attendance_open ? 'text-success' : 'text-subtle' }}">
                        Attendance {{ $activity->is_attendance_open ? 'Open' : 'Closed' }}
                    </span>
                </div>
                <p class="text-subtle small mb-3">Each QR code auto-invalidates upon scan to prevent unauthorized sharing.</p>

                <div class="p-4 text-center rounded-3 glass-box d-flex flex-column align-items-center justify-content-center">
                    @if($activity->is_attendance_open && $activity->status !== 'completed')
                        <div class="qr-container shadow-lg mb-3">
                            <img id="qrImageDisplay" src="" class="img-fluid" alt="Event QR Code" style="width: 210px; height: 210px;">
                        </div>

                        <div class="d-flex flex-column align-items-center gap-2">
                            <div id="countdownBadge" class="badge text-dark bg-warning border border-warning border-opacity-30 px-3 py-1.5 fw-semibold" style="font-size: 0.8rem;">
                                <i class="fa-solid fa-arrows-rotate me-1"></i> Refreshing in <span id="secondsLeft">10</span>s
                            </div>

                            <div class="d-flex align-items-center gap-2 justify-content-center flex-wrap mt-1">
                                <button type="button" onclick="manualRefreshQR({{ $activity->id }})" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1" style="font-size: 0.78rem;">
                                    <i class="fa-solid fa-rotate me-1"></i> Refresh Now
                                </button>

                                <div class="d-flex align-items-center gap-1 text-subtle small">
                                    <span>Interval:</span>
                                    <select id="qrIntervalSelect" onchange="changeQrInterval({{ $activity->id }})" class="form-select form-select-sm glass-box text-white shadow-none" style="width: 95px; font-size: 0.75rem;">
                                        <option value="5">5s</option>
                                        <option value="10" selected>10s</option>
                                        <option value="30">30s</option>
                                        <option value="0">Manual</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @else
                        <i class="fa-solid fa-lock fa-3x mb-3 text-muted opacity-50"></i>
                        <p class="text-subtle small mb-0">
                            {{ $activity->status === 'completed' ? 'Event is completed. Check-in QR generation is locked.' : 'Attendance check-in is currently closed.' }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Attendance Summary Widget -->
        <div class="col-12 col-lg-4">
            <div class="admin-card h-100">
                <h6 class="fw-bold text-white mb-3">Attendance Summary</h6>

                <div class="d-flex flex-column gap-3">
                    <div class="p-3 glass-box">
                        <span class="text-muted d-block small" style="font-size: 0.75rem;">Verified Present</span>
                        <span class="fw-bold text-white fs-4">{{ $presentCount }}</span>
                    </div>

                    <div class="p-3 glass-box">
                        <span class="text-muted d-block small" style="font-size: 0.75rem;">Registered</span>
                        <span class="fw-bold text-white fs-4">{{ $registeredCount }}</span>
                    </div>

                    <div class="p-3 glass-box">
                        <span class="text-muted d-block small" style="font-size: 0.75rem;">Waiting Check-in</span>
                        <span class="fw-bold text-white fs-4">{{ $waitingCount }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DOCUMENTATION / GROUPED GRID & MEMBER FEEDBACK SECTION -->
    <div class="row g-4 mb-4">
        <!-- Grouped Event Documentation Grid -->
        <div class="col-12 col-lg-7">
            <div class="admin-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-images me-1 text-primary"></i>
                        <h6 class="fw-bold text-white mb-0">Event Gallery ({{ $groupedPhotos->count() }} Posts)</h6>
                    </div>
                    <button type="button" class="btn btn-sm btn-purple d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#uploadPhotosModal">
                        <i class="fa-solid fa-plus"></i> New Post
                    </button>
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
                                        'caption' => $p->caption ?? 'No caption provided.',
                                        'delete_url' => route('admin.activities.photos.destroy', $p->id)
                                    ];
                                })->values());
                            @endphp
                            <div class="ig-grid-item" onclick='openSlideshowModal({{ $batchJson }})'>
                                <img src="{{ asset('storage/' . $coverPhoto->photo_path) }}" alt="Activity photo">
                                @if($photoCount > 1)
                                    <div class="multi-photo-badge">
                                        <i class="fa-solid fa-layer-group me-1"></i> {{ $photoCount }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-subtle py-5 glass-box">
                        <i class="fa-solid fa-camera fa-2x mb-2 opacity-40 d-block"></i>
                        No documentation photos posted yet.
                    </div>
                @endif
            </div>
        </div>

        <!-- Member Feedback Section (Star rating removed) -->
        <div class="col-12 col-lg-5">
            <div class="admin-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-white mb-0">
                        <i class="fa-solid fa-comments me-2 text-warning"></i>Member Feedback
                    </h6>
                    <span class="badge border border-white border-opacity-10 text-subtle">
                        {{ $activity->feedback->count() }} Responses
                    </span>
                </div>

                <div class="d-flex flex-column gap-3 max-vh-50 overflow-auto pe-1">
                    @forelse($activity->feedback as $item)
                        <div class="p-3 glass-box">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-semibold text-white small">{{ $item->user->name ?? 'Anonymous Member' }}</span>
                                <span class="text-muted micro-text">{{ $item->created_at ? $item->created_at->diffForHumans() : '' }}</span>
                            </div>
                            <p class="text-subtle small mb-0">{{ $item->comments ?? $item->comment ?? 'No comment provided.' }}</p>
                        </div>
                    @empty
                        <div class="text-center text-subtle py-4">
                            <i class="fa-regular fa-comment-dots fa-2x mb-2 opacity-40 d-block"></i>
                            No feedback submitted by members yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- COMPACT GALLERY POST UPLOAD MODAL -->
    <div class="modal fade admin-modal" id="uploadPhotosModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-0 border-0 overflow-hidden shadow-lg">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom border-white border-opacity-10">
                    <h6 class="fw-bold mb-0 text-white" style="font-size: 0.95rem;"><i class="fa-solid fa-images me-2 text-primary"></i>Create Gallery Post</h6>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('admin.activities.photos.store', $activity->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="captionTypeInput" name="caption_type" value="single">

                    <div class="modal-body p-3">
                        <div class="ig-dropzone mb-3" onclick="document.getElementById('photoFileInput').click()">
                            <i class="fa-solid fa-cloud-arrow-up text-primary fs-5 mb-1"></i>
                            <div class="fw-semibold text-white small">Select or Drag Photos</div>
                            <span class="text-subtle" style="font-size: 0.72rem;">Multiple photo uploads supported</span>
                            <input type="file" id="photoFileInput" name="photos[]" class="d-none" multiple accept="image/*" required onchange="renderIgPostPreviews(this)">
                        </div>

                        <div id="captionToggleWrapper" class="d-none mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-subtle small" style="font-size: 0.75rem;">Caption Option:</span>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" id="btnModeSingle" class="btn btn-purple btn-sm py-1 px-2.5" style="font-size: 0.72rem;" onclick="switchCaptionMode('single')">Single Caption</button>
                                    <button type="button" id="btnModeIndividual" class="btn btn-outline-light btn-sm py-1 px-2.5" style="font-size: 0.72rem;" onclick="switchCaptionMode('individual')">Per Photo</button>
                                </div>
                            </div>

                            <div id="singleCaptionBox">
                                <textarea name="single_caption" class="form-control input-dark-custom p-2.5" rows="2" placeholder="Write a single caption for all photos..." style="font-size: 0.82rem; resize: none;"></textarea>
                            </div>
                        </div>

                        <div id="previewContainer" style="max-height: 240px; overflow-y: auto;"></div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 p-2.5 border-top border-white border-opacity-10 bg-black bg-opacity-20">
                        <button type="button" class="btn btn-outline-light rounded-pill btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="btnSubmitPost" class="btn btn-purple rounded-pill btn-sm px-4 fw-semibold" disabled>Share Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CAROUSEL SLIDESHOW LIGHTBOX POPUP MODAL -->
    <div class="modal fade admin-modal" id="slideshowModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-0 border-0 overflow-hidden">
                <div class="row g-0">
                    <div class="col-12 col-md-7 bg-black position-relative d-flex align-items-center justify-content-center" style="min-height: 360px;">
                        <!-- Carousel -->
                        <div id="lightboxCarousel" class="carousel slide w-100" data-bs-ride="false">
                            <div class="carousel-inner" id="carouselInner"></div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <div class="col-12 col-md-5 p-3 d-flex flex-column justify-content-between border-start border-white border-opacity-10">
                        <div>
                            <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom border-white border-opacity-10">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-purple text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="fw-bold text-white small d-block">{{ auth()->user()->name ?? 'Admin' }}</span>
                                        <span class="text-subtle micro-text d-block" style="font-size: 0.65rem;" id="carouselCounter">Photo 1 of 1</span>
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <p id="slideshowCaption" class="text-white small mb-3" style="line-height: 1.5; font-size: 0.85rem;"></p>
                        </div>

                        <div class="pt-3 border-top border-white border-opacity-10 d-flex justify-content-between align-items-center">
                            <!-- Button triggers confirmation modal -->
                            <button type="button" onclick="confirmDeletePhotoModal()" class="btn btn-sm btn-outline-danger rounded-pill px-3" style="font-size: 0.78rem;">
                                <i class="fa-solid fa-trash-can me-1"></i> Delete Current Photo
                            </button>

                            <button type="button" class="btn btn-outline-light btn-sm rounded-pill px-3" data-bs-dismiss="modal" style="font-size: 0.78rem;">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PHOTO DELETE CONFIRMATION MODAL -->
    <div class="modal fade admin-modal" id="deletePhotoConfirmModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 text-center">
                <div class="modal-body p-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 56px; height: 56px; background-color: rgba(239, 68, 68, 0.15);">
                        <i class="fa-solid fa-trash-can text-danger fa-lg"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2">Delete Photo?</h5>
                    <p class="text-subtle small mb-4">Are you sure you want to remove this photo from the event gallery? This action cannot be undone.</p>

                    <form id="deleteSlideshowPhotoForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger rounded-3 px-4 fw-semibold">Delete Photo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- EARLY COMPLETE CONFIRMATION MODAL -->
    <div class="modal fade admin-modal" id="completeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 text-center">
                <div class="modal-body p-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 56px; height: 56px; background-color: rgba(34, 197, 94, 0.15);">
                        <i class="fa-solid fa-flag-checkered text-success fa-lg"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2">Mark Activity as Completed?</h5>
                    <p class="text-subtle small mb-4">This will close all registrations, lock attendance check-in, and unlock photo documentation features for members.</p>

                    <form method="POST" action="{{ route('admin.activities.complete', $activity->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success rounded-3 px-4 fw-semibold">Yes, Complete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- REGISTRATION / ATTENDANCE TOGGLE CONFIRMATION MODAL -->
    <div class="modal fade admin-modal" id="toggleConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 text-center">
                <div class="modal-body p-4">
                    <div id="toggleModalIconWrap" class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 56px; height: 56px;">
                        <i id="toggleModalIcon" class="fa-solid fa-lg"></i>
                    </div>
                    <h5 id="toggleModalTitle" class="fw-bold text-white mb-2"></h5>
                    <p id="toggleModalMessage" class="text-subtle small mb-4"></p>

                    <form id="toggleConfirmForm" method="POST" action="">
                        @csrf
                        @method('PATCH')
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-outline-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" id="toggleModalConfirmBtn" class="btn rounded-3 px-4 fw-semibold"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let activeActivityId = {{ $activity->id }};
    let isAttendanceOpen = {{ $activity->is_attendance_open && $activity->status !== 'completed' ? 'true' : 'false' }};
    let countdownTimer = null;
    let refreshInterval = 10;
    let secondsRemaining = 10;
    let currentCaptionMode = 'single';
    let currentBatchPhotos = [];

    function confirmCompleteModal() {
        const modal = new bootstrap.Modal(document.getElementById('completeModal'));
        modal.show();
    }

    function confirmToggle(type, isOpen, url) {
        const closing = isOpen;
        const copy = {
            registration: {
                label: 'Registration',
                close: 'Members will no longer be able to register for this activity. You can reopen registration at any time.',
                open: 'Members will be able to register for this activity again.'
            },
            attendance: {
                label: 'Attendance Check-in',
                close: 'Members will no longer be able to check in, and QR check-in will be turned off. You can reopen it at any time.',
                open: 'Members will be able to check in with the QR code, and registered participants will be notified. An upcoming activity will be marked as ongoing.'
            }
        }[type];

        const wrap = document.getElementById('toggleModalIconWrap');
        const icon = document.getElementById('toggleModalIcon');
        const btn = document.getElementById('toggleModalConfirmBtn');

        document.getElementById('toggleConfirmForm').action = url;
        document.getElementById('toggleModalTitle').textContent = (closing ? 'Close ' : 'Open ') + copy.label + '?';
        document.getElementById('toggleModalMessage').textContent = closing ? copy.close : copy.open;

        if (closing) {
            wrap.style.backgroundColor = 'rgba(244, 63, 94, 0.15)';
            icon.className = 'fa-solid fa-lock fa-lg text-danger';
            btn.className = 'btn btn-danger rounded-3 px-4 fw-semibold';
            btn.textContent = 'Yes, Close';
        } else {
            wrap.style.backgroundColor = 'rgba(34, 197, 94, 0.15)';
            icon.className = 'fa-solid fa-lock-open fa-lg text-success';
            btn.className = 'btn btn-success rounded-3 px-4 fw-semibold';
            btn.textContent = 'Yes, Open';
        }

        new bootstrap.Modal(document.getElementById('toggleConfirmModal')).show();
    }

    function confirmDeletePhotoModal() {
        const modal = new bootstrap.Modal(document.getElementById('deletePhotoConfirmModal'));
        modal.show();
    }

    function switchCaptionMode(mode) {
        currentCaptionMode = mode;
        document.getElementById('captionTypeInput').value = mode;

        const btnSingle = document.getElementById('btnModeSingle');
        const btnIndividual = document.getElementById('btnModeIndividual');
        const singleBox = document.getElementById('singleCaptionBox');

        if (mode === 'single') {
            btnSingle.className = 'btn btn-purple btn-sm py-1 px-2.5';
            btnIndividual.className = 'btn btn-outline-light btn-sm py-1 px-2.5';
            singleBox.classList.remove('d-none');
        } else {
            btnSingle.className = 'btn btn-outline-light btn-sm py-1 px-2.5';
            btnIndividual.className = 'btn btn-purple btn-sm py-1 px-2.5';
            singleBox.classList.add('d-none');
        }

        const input = document.getElementById('photoFileInput');
        renderIgPostPreviews(input);
    }

    function renderIgPostPreviews(input) {
        const container = document.getElementById('previewContainer');
        const submitBtn = document.getElementById('btnSubmitPost');
        const captionToggle = document.getElementById('captionToggleWrapper');

        container.innerHTML = '';

        if (input.files && input.files.length > 0) {
            submitBtn.disabled = false;
            captionToggle.classList.remove('d-none');

            if (currentCaptionMode === 'individual') {
                const list = document.createElement('div');
                list.className = 'd-flex flex-column gap-2';

                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const row = document.createElement('div');
                        row.className = 'glass-box p-2.5 d-flex align-items-center gap-3';
                        row.innerHTML = `
                            <div style="width: 56px; height: 56px; aspect-ratio: 1 / 1; overflow: hidden; border-radius: 8px; border: 1px solid var(--admin-border);" class="flex-shrink-0">
                                <img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1">
                                <label class="text-subtle micro-text d-block mb-1" style="font-size: 0.72rem;">Caption for Photo ${index + 1}</label>
                                <input type="text" name="captions[${index}]" class="form-control form-control-sm input-dark-custom" placeholder="Write caption for photo ${index + 1}..." style="font-size: 0.8rem;">
                            </div>
                        `;
                        list.appendChild(row);
                    };
                    reader.readAsDataURL(file);
                });
                container.appendChild(list);
            } else {
                const grid = document.createElement('div');
                grid.className = 'preview-thumb-grid';

                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const card = document.createElement('div');
                        card.className = 'preview-grid-card';
                        card.innerHTML = `<img src="${e.target.result}" title="Photo ${index + 1}">`;
                        grid.appendChild(card);
                    };
                    reader.readAsDataURL(file);
                });
                container.appendChild(grid);
            }
        } else {
            submitBtn.disabled = true;
            captionToggle.classList.add('d-none');
        }
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
            document.getElementById('deleteSlideshowPhotoForm').action = photo.delete_url;
            document.getElementById('carouselCounter').innerText = `Photo ${index + 1} of ${currentBatchPhotos.length}`;
        }
    }

    function fetchNextQR(activityId) {
        const ttl = refreshInterval;
        fetch(`/admin/activities/${activityId}/qr-payload?ttl=${ttl}`)
            .then(res => res.json())
            .then(data => {
                if(data.qr_url) {
                    const img = document.getElementById('qrImageDisplay');
                    if (img) img.src = data.qr_url;
                    resetCountdown();
                }
            });
    }

    function resetCountdown() {
        secondsRemaining = refreshInterval;
        const badge = document.getElementById('countdownBadge');
        if (!badge) return;

        if (refreshInterval === 0) {
            badge.className = "badge text-dark bg-warning border border-warning border-opacity-30 px-3 py-1.5 fw-semibold";
            badge.innerHTML = '<i class="fa-solid fa-hand me-1"></i> Manual Refresh Only';
        } else {
            badge.className = "badge text-dark bg-warning border border-warning border-opacity-30 px-3 py-1.5 fw-semibold";
            badge.innerHTML = `<i class="fa-solid fa-arrows-rotate me-1"></i> Refreshing in <span id="secondsLeft">${secondsRemaining}</span>s`;
        }
    }

    function startTimer(activityId) {
        stopTimers();
        if (refreshInterval > 0) {
            countdownTimer = setInterval(() => {
                secondsRemaining--;
                const elem = document.getElementById('secondsLeft');
                if (elem) elem.innerText = secondsRemaining;

                if (secondsRemaining <= 0) {
                    fetchNextQR(activityId);
                }
            }, 1000);
        }
    }

    function stopTimers() {
        if (countdownTimer) clearInterval(countdownTimer);
    }

    function manualRefreshQR(activityId) {
        fetchNextQR(activityId);
    }

    function changeQrInterval(activityId) {
        refreshInterval = parseInt(document.getElementById('qrIntervalSelect').value, 10);
        resetCountdown();
        startTimer(activityId);
    }

    document.addEventListener("DOMContentLoaded", function () {
        if (isAttendanceOpen) {
            fetchNextQR(activeActivityId);
            startTimer(activeActivityId);
        }
    });
</script>
@endpush
