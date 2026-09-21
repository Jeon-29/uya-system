<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $activity->title }} - UYA Connect</title>

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

        .pastel-card-primary {
            background-color: #ffffff;
            border: 1px solid rgba(131, 182, 190, 0.25) !important;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.04);
            border-radius: 16px;
        }

        .detail-subcard {
            background-color: #f8fafc;
            border: 1px solid #dce5e8 !important;
            border-radius: 12px;
            padding: 0.85rem;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.25rem 0.75rem;
            font-size: 0.72rem;
            font-weight: 600;
            line-height: 1.2;
            border-radius: 50rem;
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
    </style>
</head>
<body>

    @include('layouts.navbar')

    <div class="app-container py-3 py-md-4">

        <!-- Back Button -->
        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('activities') }}" class="btn btn-light border rounded-pill px-3 py-1.5 text-brand fw-semibold shadow-sm text-decoration-none" style="font-size: 0.85rem;">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Activities
                </a>
            </div>
        </div>

        @php
            $isDeadlinePassed = $activity->registration_deadline && now()->greaterThan($activity->registration_deadline);
            $canRegister = $activity->is_registration_open && !$isDeadlinePassed && $activity->hasAvailableSlots();
            $groupedPhotos = $activity->photos->groupBy(function ($photo) {
                return $photo->batch_id ?? ('single_' . $photo->id);
            });
        @endphp

        <!-- Main Overview Banner Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm rounded-4 p-3 p-md-4 pastel-card-primary">
                    <div class="row align-items-start justify-content-between g-4">

                        <!-- Left Info Section -->
                        <div class="col-12 col-lg-8">
                            <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                <h3 class="fw-bold mb-0 text-brand fs-4 fs-md-3">{{ $activity->title }}</h3>
                                @if($activity->status === 'completed')
                                    <span class="status-pill bg-success bg-opacity-15 text-success border border-success border-opacity-25">
                                        <i class="fa-solid fa-check-circle me-1"></i> Completed
                                    </span>
                                @else
                                    <span class="status-pill text-dark" style="background-color: var(--uya-gold);">
                                        {{ ucfirst($activity->status) }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-muted small mb-3">{{ $activity->description }}</p>

                            <!-- Attendance Verification Card for Finished Activity -->
                            @if($activity->status === 'completed')
                                <div class="detail-subcard mb-3 border-success border-opacity-25 bg-success bg-opacity-10">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                        <div>
                                            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.65rem; letter-spacing: 0.5px;">Attendance Verification</span>
                                            @if($hasAttended)
                                                <div class="text-success fw-bold mt-0.5" style="font-size: 0.88rem;">
                                                    <i class="fa-solid fa-circle-check me-1"></i> Successfully Attended
                                                </div>
                                                <div class="text-muted small" style="font-size: 0.75rem;">
                                                    Verified on {{ $userParticipant->updated_at ? $userParticipant->updated_at->format('M j, Y \a\t g:i A') : 'N/A' }}
                                                </div>
                                            @else
                                                <div class="text-secondary fw-semibold mt-0.5" style="font-size: 0.85rem;">
                                                    <i class="fa-solid fa-circle-xmark me-1"></i> Not Verified Present
                                                </div>
                                            @endif
                                        </div>

                                        @if($hasAttended)
                                            <a href="{{ route('certificates') }}" class="btn btn-sm custom-btn-filled rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5" style="font-size: 0.8rem;">
                                                <i class="fa-solid fa-award"></i> View Certificate
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Mini Metadata Grid -->
                            <div class="row g-2 g-md-3">
                                <div class="col-6 col-md-3">
                                    <div class="detail-subcard h-100">
                                        <span class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Date</span>
                                        <div class="text-dark fw-semibold mt-1" style="font-size: 0.85rem;">
                                            <i class="fa-regular fa-calendar me-1 text-secondary"></i> {{ $activity->date->format('M j, Y') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3">
                                    <div class="detail-subcard h-100">
                                        <span class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Time</span>
                                        <div class="text-dark fw-semibold mt-1" style="font-size: 0.85rem;">
                                            <i class="fa-regular fa-clock me-1 text-secondary"></i> {{ $activity->date->format('g:i A') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3">
                                    <div class="detail-subcard h-100">
                                        <span class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Location</span>
                                        <div class="text-dark fw-semibold mt-1 text-truncate" style="font-size: 0.85rem;">
                                            <i class="fa-solid fa-location-dot me-1 text-secondary"></i> {{ $activity->location ?? 'TBD' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3">
                                    <div class="detail-subcard h-100">
                                        <span class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Organizer</span>
                                        <div class="text-dark fw-semibold mt-1" style="font-size: 0.85rem;">
                                            <i class="fa-solid fa-user me-1 text-secondary"></i> {{ $activity->organizer_name ?? 'Admin' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Right Summary Widget -->
                        <div class="col-12 col-lg-4">
                            <div class="detail-subcard bg-light bg-opacity-50">
                                <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                    <span class="text-muted small" style="font-size: 0.8rem;">Registration</span>
                                    <span class="badge {{ $canRegister ? 'bg-success bg-opacity-15 text-success' : 'bg-secondary bg-opacity-15 text-dark' }} px-2 py-1" style="font-size: 0.65rem;">
                                        {{ $canRegister ? 'Open' : 'Closed' }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                    <span class="text-muted small" style="font-size: 0.8rem;">Attendance</span>
                                    <span class="badge {{ $activity->is_attendance_open ? 'bg-success bg-opacity-15 text-success' : 'bg-secondary bg-opacity-15 text-dark' }} px-2 py-1" style="font-size: 0.65rem;">
                                        {{ $activity->is_attendance_open ? 'Open' : 'Closed' }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small" style="font-size: 0.8rem;">Feedback</span>
                                    <span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $activity->feedback->count() }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small" style="font-size: 0.8rem;">Photos</span>
                                    <span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $activity->photos->count() }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Documentation & Feedback Grid -->
        <div class="row g-4">
            <!-- Documentation Column -->
            <div class="col-12 col-lg-7">
                <div class="card p-3 p-md-4 pastel-card-primary h-100">
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
                        <div class="text-center text-muted py-5 detail-subcard">
                            <i class="fa-regular fa-images fa-2x mb-2 opacity-50 d-block"></i>
                            No documentation photos uploaded yet.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Feedback Column -->
            <div class="col-12 col-lg-5">
                <div class="card p-3 p-md-4 pastel-card-primary h-100">
                    <div class="d-flex align-items-center gap-2 text-brand fw-bold mb-3" style="font-size: 1rem;">
                        <i class="fa-regular fa-comment"></i> Your Feedback
                    </div>

                    @if($userFeedback)
                        <div class="detail-subcard">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                @if(auth()->user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                                         alt="{{ auth()->user()->name }}"
                                         class="rounded-circle object-fit-cover shadow-sm flex-shrink-0"
                                         style="width: 32px; height: 32px;">
                                @else
                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold shadow-sm flex-shrink-0"
                                         style="width: 32px; height: 32px; background-color: var(--uya-dark-teal); font-size: 0.8rem;">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif

                                <div class="d-flex flex-wrap align-items-baseline gap-1.5 overflow-hidden">
                                    <span class="fw-bold text-dark text-truncate" style="font-size: 0.85rem;">{{ auth()->user()->name }}</span>
                                    <span class="text-muted small" style="font-size: 0.72rem;">
                                        • {{ $userFeedback->created_at->format('M j, Y \a\t g:i A') }}
                                    </span>
                                </div>
                            </div>

                            <div class="px-3 py-2 rounded-3 bg-white border border-light-subtle shadow-xs">
                                <p class="text-secondary small mb-0" style="font-size: 0.85rem; line-height: 1.4; white-space: pre-line;">
                                    {{ $userFeedback->comment ?? $userFeedback->comments }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="detail-subcard d-flex flex-column gap-3">
                            <span class="text-muted small">Share your thoughts or experience regarding this activity.</span>
                            <button onclick="openFeedbackModal()" class="btn rounded-pill py-2.5 fw-semibold custom-btn-filled d-flex align-items-center justify-content-center gap-2 shadow-sm w-100" style="font-size: 0.85rem;">
                                <i class="fa-regular fa-comment-dots"></i> Add Feedback
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
