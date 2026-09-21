@extends('layouts.admin')

@section('title', $activity->title . ' - Finished Activity Details')

@push('styles')
<style>
    .admin-card { background-color: var(--admin-card-bg); border: 1px solid var(--admin-border); border-radius: 16px; padding: 24px; }
    .cert-item-card { background-color: rgba(255, 255, 255, 0.02); border: 1px solid var(--admin-border); border-radius: 12px; padding: 14px 18px; }
</style>
@endpush

@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.activities.index', ['tab' => 'finished']) }}" class="btn btn-outline-light btn-sm rounded-3 px-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Finished Activities
        </a>
    </div>

    <!-- Banner Header -->
    <div class="admin-card mb-4">
        <div class="d-flex align-items-center gap-2 mb-2">
            <h4 class="fw-bold text-white mb-0">{{ $activity->title }}</h4>
            <span class="badge bg-success bg-opacity-20 text-success border border-success border-opacity-20">Completed</span>
        </div>
        <p class="text-subtle small mb-4">{{ $activity->description }}</p>

        <div class="row g-3 text-subtle small pt-3 border-top border-white border-opacity-10">
            <div class="col-6 col-md-3">
                <span class="text-muted d-block" style="font-size: 0.72rem;">Date</span>
                <span class="fw-semibold text-white"><i class="fa-regular fa-calendar me-1"></i>{{ $activity->date->format('M j, Y') }}</span>
            </div>
            <div class="col-6 col-md-3">
                <span class="text-muted d-block" style="font-size: 0.72rem;">Location</span>
                <span class="fw-semibold text-white"><i class="fa-solid fa-location-dot me-1"></i>{{ $activity->location ?? 'N/A' }}</span>
            </div>
            <div class="col-6 col-md-3">
                <span class="text-muted d-block" style="font-size: 0.72rem;">Organizer</span>
                <span class="fw-semibold text-white"><i class="fa-regular fa-user me-1"></i>{{ $activity->organizer_name ?? 'Admin' }}</span>
            </div>
            <div class="col-6 col-md-3">
                <span class="text-muted d-block" style="font-size: 0.72rem;">Budget</span>
                <span class="fw-semibold text-white"><i class="fa-solid fa-peso-sign me-1"></i>₱{{ number_format($activity->budget, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Certificates List -->
        <div class="col-12 col-lg-7">
            <div class="admin-card h-100">
                <h6 class="fw-bold text-white mb-1"><i class="fa-solid fa-certificate me-2 text-primary"></i>Issued Certificates</h6>
                <p class="text-subtle small mb-4">Members listed here earned certificates via QR attendance check-in.</p>

                <div class="d-flex flex-column gap-2.5">
                    @forelse($activity->participants->where('status', 'attended') as $participant)
                        <div class="cert-item-card d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <h6 class="fw-bold text-white mb-1" style="font-size: 0.9rem;">{{ $participant->user->name ?? 'Member' }}</h6>
                                <div class="text-subtle small" style="font-size: 0.75rem;">
                                    Attendance: <span class="text-success fw-semibold">Present</span> · Issued: {{ $participant->updated_at->format('Y-m-d') }}
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-light btn-sm rounded-3" style="font-size: 0.78rem;">
                                    <i class="fa-regular fa-eye me-1"></i> View Certificate
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4 small">
                            <i class="fa-solid fa-certificate fa-2x mb-2 d-block opacity-50"></i>
                            No certificates issued yet for this activity.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Activity Feedback Panel -->
        <div class="col-12 col-lg-5">
            <div class="admin-card h-100">
                <h6 class="fw-bold text-white mb-1"><i class="fa-regular fa-comments me-2 text-primary"></i>Activity Feedback</h6>
                <p class="text-subtle small mb-4">Feedback submitted by participating members.</p>

                <div class="d-flex flex-column gap-3">
                    @forelse($activity->feedback as $fb)
                        <div class="p-3 rounded-3 bg-black bg-opacity-20 border border-white border-opacity-10">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-white small">{{ $fb->user->name ?? 'Anonymous' }}</span>
                                <span class="badge bg-primary bg-opacity-20 text-primary small" style="font-size: 0.68rem;">{{ $fb->rating_label ?? 'Feedback' }}</span>
                            </div>
                            <p class="text-subtle small mb-0" style="font-size: 0.8rem; line-height: 1.4;">{{ $fb->comment }}</p>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4 small">
                            <i class="fa-regular fa-comment-dots fa-2x mb-2 d-block opacity-50"></i>
                            No feedback submitted for this event yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
