{{--
    Reusable Activity Card
    ----------------------
    Required props:
      - $activity       (object)  Activity model with: id, title, date, location, organizer, description, status, category

    Status options (drives visual state):
      - open           (registration open)
      - closed         (registration closed)
      - registered     (user is registered, upcoming)
      - ongoing        (activity in progress, can scan QR)
      - finished       (activity completed)

    Category options (drives icon + accent color):
      - community, environment, education, sports, leadership, default
--}}

@php
    // Map status -> { color, badge, accent, cta_label, cta_action, cta_disabled, secondary_label }
    $statusMap = [
        'open' => [
            'color' => 'gold',
            'badge' => 'Open',
            'cta_label' => 'Register Now',
            'cta_action' => 'register',
            'cta_disabled' => false,
            'secondary_label' => 'View Details',
        ],
        'closed' => [
            'color' => 'muted',
            'badge' => 'Closed',
            'cta_label' => 'Registration Closed',
            'cta_action' => null,
            'cta_disabled' => true,
            'secondary_label' => 'View Details',
        ],
        'registered' => [
            'color' => 'success',
            'badge' => 'Registered',
            'cta_label' => 'View Details',
            'cta_action' => 'view',
            'cta_disabled' => false,
            'secondary_label' => null,
        ],
        'ongoing' => [
            'color' => 'primary',
            'badge' => 'Ongoing',
            'cta_label' => 'Scan QR',
            'cta_action' => 'scan',
            'cta_disabled' => false,
            'secondary_label' => 'View Details',
        ],
        'finished' => [
            'color' => 'secondary',
            'badge' => 'Completed',
            'cta_label' => 'View Details',
            'cta_action' => 'view',
            'cta_disabled' => false,
            'secondary_label' => null,
        ],
    ];

    // Map category -> { icon, gradient }
    $categoryMap = [
        'community'   => ['icon' => 'fa-solid fa-hand-holding-heart', 'gradient' => 'linear-gradient(135deg, #fce7c4 0%, #f4d28a 100%)', 'icon_color' => '#9a6f1d'],
        'environment' => ['icon' => 'fa-solid fa-leaf',                'gradient' => 'linear-gradient(135deg, #d4ecdd 0%, #a8d8b9 100%)', 'icon_color' => '#2f6b4a'],
        'education'   => ['icon' => 'fa-solid fa-graduation-cap',       'gradient' => 'linear-gradient(135deg, #d6e4f0 0%, #aac6e1 100%)', 'icon_color' => '#224d5b'],
        'sports'      => ['icon' => 'fa-solid fa-medal',               'gradient' => 'linear-gradient(135deg, #f8d7da 0%, #e8a8ad 100%)', 'icon_color' => '#842029'],
        'leadership'  => ['icon' => 'fa-solid fa-compass',             'gradient' => 'linear-gradient(135deg, #e0d4f1 0%, #b8a3d6 100%)', 'icon_color' => '#4a2c7a'],
        'default'     => ['icon' => 'fa-solid fa-calendar-day',         'gradient' => 'linear-gradient(135deg, #e4edf0 0%, #b6cdd3 100%)', 'icon_color' => '#224d5b'],
    ];

    $status = $activity->status ?? 'open';
    $category = $activity->category ?? 'default';
    $state = $statusMap[$status] ?? $statusMap['open'];

    // Dashboard context: registration is handled elsewhere, so only show "View Details".
    if (isset($context) && $context === 'dashboard') {
        $state['cta_action'] = 'view';
        $state['cta_label'] = 'View Details';
        $state['secondary_label'] = null;
    }
@endphp

<div class="activity-card activity-card--{{ $status }}">

    {{-- Empty header (status moved next to title) --}}
    <div class="activity-card__header"></div>

    {{-- Body --}}
    <div class="activity-card__body">
        <div class="d-flex align-items-start justify-content-between gap-2 mb-1">
            <h6 class="activity-card__title" title="{{ $activity->title }}">{{ $activity->title }}</h6>
            @if ($status === 'ongoing')
                <span class="activity-card__badge activity-card__badge--pulse flex-shrink-0">
                    <span class="activity-card__pulse-dot"></span>
                    Ongoing
                </span>
            @else
                <span class="activity-card__badge activity-card__badge--{{ $state['color'] }} flex-shrink-0">
                    {{ $state['badge'] }}
                </span>
            @endif
        </div>

        {{-- Category chip --}}
        @if ($category !== 'default')
            <span class="activity-card__chip">{{ ucfirst($category) }}</span>
        @endif

        <p class="activity-card__desc">{{ $activity->description ?? '' }}</p>
    </div>

    {{-- Metadata grid (date, location, organizer) --}}
    <div class="activity-card__meta">
        <div class="activity-card__meta-item">
            <i class="fa-regular fa-calendar"></i>
            <div>
                <span class="activity-card__meta-label">Date</span>
                <span class="activity-card__meta-value">{{ $activity->date?->format('D, M j') ?? 'TBA' }}</span>
            </div>
        </div>
        <div class="activity-card__meta-item">
            <i class="fa-solid fa-location-dot"></i>
            <div>
                <span class="activity-card__meta-label">Location</span>
                <span class="activity-card__meta-value">{{ $activity->location ?? 'TBA' }}</span>
            </div>
        </div>
        <div class="activity-card__meta-item">
            <i class="fa-solid fa-user"></i>
            <div>
                <span class="activity-card__meta-label">Organizer</span>
                <span class="activity-card__meta-value">{{ $activity->organizer->name ?? $activity->organizer ?? 'TBA' }}</span>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="activity-card__actions">
        @if ($state['secondary_label'])
            <a href="{{ $status === 'finished' ? route('activities.finished.show', $activity->id) : route('activities.show', $activity->id) }}"
               class="activity-card__btn activity-card__btn--ghost">
                <i class="fa-regular fa-eye"></i>
                {{ $state['secondary_label'] }}
            </a>
        @endif

        @if ($state['cta_action'] === 'register')
            <button class="activity-card__btn activity-card__btn--primary"
                    data-action="register"
                    data-activity-id="{{ $activity->id }}"
                    data-activity-title="{{ $activity->title }}"
                    data-activity-date="{{ $activity->date?->format('D, M j, Y') ?? 'TBA' }}"
                    data-activity-location="{{ $activity->location ?? 'TBA' }}">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                {{ $state['cta_label'] }}
            </button>
        @elseif ($state['cta_action'] === 'scan')
            <button onclick="openQRScanner()" class="activity-card__btn activity-card__btn--primary activity-card__btn--blue">
                <i class="fa-solid fa-camera"></i>
                {{ $state['cta_label'] }}
            </button>
        @elseif ($state['cta_action'] === 'view')
            <a href="{{ $status === 'finished' ? route('activities.finished.show', $activity->id) : route('activities.show', $activity->id) }}"
               class="activity-card__btn activity-card__btn--primary">
                <i class="fa-solid fa-arrow-right"></i>
                {{ $state['cta_label'] }}
            </a>
        @else
            <button class="activity-card__btn activity-card__btn--disabled" disabled>
                <i class="fa-solid fa-lock"></i>
                {{ $state['cta_label'] }}
            </button>
        @endif
    </div>

</div>
