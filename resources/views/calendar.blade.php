<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar - UYA Connect</title>

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
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }

        .pastel-card-primary {
            background-color: #ffffff;
            border: 1px solid rgba(131, 182, 190, 0.25) !important;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.04);
        }

        /* Calendar Grid */
        .cal-grid {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .cal-row {
            display: flex;
            gap: 4px;
        }
        .cal-day-cell {
            flex: 1;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            height: 95px;
            padding: 10px 6px;
            position: relative;
            transition: all 0.15s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .cal-day-cell.other-month {
            opacity: 0.4;
            background-color: #f1f5f9;
        }
        .cal-day-cell.today {
            border: 2px solid var(--uya-dark-teal);
            background-color: #f0f7f9;
        }
        .cal-day-cell.selected {
            background-color: var(--uya-dark-teal);
            color: #fff;
        }
        .cal-day-cell.selected .cal-day-number,
        .cal-day-cell.selected .cal-count {
            color: #fff !important;
        }
        .cal-day-cell:hover:not(.other-month):not(.today):not(.selected) {
            border-color: var(--uya-light-blue);
            box-shadow: 0 0 0 1px var(--uya-light-blue);
        }
        .cal-day-number {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--uya-dark-teal);
            line-height: 1;
        }
        .cal-day-number.other-month {
            color: #888;
        }
        .cal-count {
            font-size: 0.65rem;
            font-weight: 600;
            background-color: var(--uya-dark-teal);
            color: #fff;
            border-radius: 9999px;
            width: 18px;
            height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            margin-top: 4px;
        }
        .cal-count-zero {
            visibility: hidden;
        }

        /* Mobile: show only the current week by default */
        @media (max-width: 768px) {
            .cal-week-only .cal-row:not(.cal-row--current) {
                display: none;
            }
            .cal-week-only .cal-row.cal-row--current {
                display: flex !important;
            }

            /* Tighten the calendar card on small screens */
            .pastel-card-primary.p-4 {
                padding: 1rem !important;
            }

            /* Smaller day cells so 7 fit comfortably */
            .cal-day-cell {
                height: 80px;
                padding: 6px 4px;
            }
            .cal-day-number {
                font-size: 0.95rem;
            }
            .cal-count {
                width: 16px;
                height: 16px;
                font-size: 0.6rem;
            }

            /* Smaller month name */
            .cal-month-label {
                font-size: 0.95rem !important;
            }

            /* Smaller weekday header */
            .cal-weekday {
                font-size: 0.65rem !important;
            }

            /* Tighter header padding */
            .cal-header {
                margin-bottom: 1rem !important;
            }

            /* Compact control buttons so they don't push off the card */
            .cal-controls .btn,
            .cal-controls a.btn {
                padding: 0.25rem 0.65rem !important;
                font-size: 0.72rem !important;
            }
            .cal-controls .btn-group .btn {
                padding: 0.25rem 0.45rem !important;
            }
        }
    </style>
</head>
<body>

    @php
        use Carbon\Carbon;

        // Current viewing month: ?month=YYYY-MM overrides; otherwise today.
        $today = Carbon::today();
        $viewMonth = request('month')
            ? Carbon::createFromFormat('Y-m', request('month'))->startOfMonth()
            : $today->copy()->startOfMonth();

        // Selected date: ?date=YYYY-MM-DD overrides; otherwise today.
        $selectedDate = request('date')
            ? Carbon::createFromFormat('Y-m-d', request('date'))->startOfDay()
            : $today->copy();

        // Build the 6×7 grid (Sun–Sat) that contains this month.
        $gridStart = $viewMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $gridEnd   = $gridStart->copy()->addDays(41); // 6 full weeks

        // Index activities by date string for O(1) lookup per day cell.
        $eventsByDate = $activities
            ->groupBy(fn ($a) => $a->date?->format('Y-m-d'));

        // Count events per day for the grid.
        $eventCounts = $eventsByDate->map(fn ($a) => count($a))->all();

        // Right-side panel: next 5 upcoming activities from today.
        $upcoming = $activities
            ->filter(fn ($a) => $a->date && $a->date->gte($today))
            ->sortBy('date')
            ->take(5)
            ->values();

        // "Selected Date" panel = the date the user clicked (or today if none).
        $selectedActivities = $eventsByDate[$selectedDate->format('Y-m-d')] ?? collect();
    @endphp

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <div class="container-fluid py-3">

        <!-- Header Section -->
        <div class="row mb-3">
            <div class="col-12">
                <h2 class="fw-bold mb-1 text-brand">Calendar</h2>
                <p class="text-muted small mb-0">Check your upcoming activities, attendance actions, certificates, and feedback tasks.</p>
            </div>
        </div>

        <div class="row g-4">

            <!-- Left Column: Month Grid Calendar -->
            <div class="col-lg-8">
                <div class="card shadow-sm rounded-4 p-4 pastel-card-primary">

                    <!-- Month Header Navigation -->
                    <div class="d-flex justify-content-between align-items-center mb-4 cal-header">
                        <div class="d-flex align-items-center gap-2 text-brand fw-bold cal-month-label" style="font-size: 1.05rem;">
                            <i class="fa-regular fa-calendar-days"></i>
                            <span>{{ $viewMonth->format('F Y') }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 cal-controls">
                            <!-- Mobile: expand / collapse full month -->
                            <button id="toggleMonthBtn"
                                    class="btn btn-sm d-md-none align-items-center gap-1 px-3 py-1 rounded-pill fw-semibold text-white"
                                    style="font-size: 0.78rem; background-color: var(--uya-gold); border: none;"
                                    onclick="toggleMonth()">
                                <i class="fa-solid fa-expand fa-xs" id="toggleMonthIcon"></i>
                                <span id="toggleMonthLabel">Expand</span>
                            </button>
                            <a href="{{ route('calendar') }}"
                               class="btn btn-sm btn-light border px-3 py-1 rounded-pill fw-semibold"
                               style="font-size: 0.78rem;">Today</a>
                            <div class="btn-group border rounded-pill overflow-hidden shadow-sm">
                                <a href="{{ route('calendar', array_merge(request()->except(['month','date']), ['month' => $viewMonth->copy()->subMonth()->format('Y-m')])) }}"
                                   class="btn btn-sm btn-light px-2 border-0"><i class="fa-solid fa-chevron-left fa-xs"></i></a>
                                <a href="{{ route('calendar', array_merge(request()->except(['month','date']), ['month' => $viewMonth->copy()->addMonth()->format('Y-m')])) }}"
                                   class="btn btn-sm btn-light px-2 border-0"><i class="fa-solid fa-chevron-right fa-xs"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Weekdays Header -->
                    <div class="row text-center text-muted fw-bold mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <div class="col cal-weekday">SUN</div>
                        <div class="col cal-weekday">MON</div>
                        <div class="col cal-weekday">TUE</div>
                        <div class="col cal-weekday">WED</div>
                        <div class="col cal-weekday">THU</div>
                        <div class="col cal-weekday">FRI</div>
                        <div class="col cal-weekday">SAT</div>
                    </div>

                    <!-- Days Grid (built from $gridStart) -->
                    <div id="calGrid" class="d-flex flex-column gap-2 cal-week-only" style="font-size: 0.85rem;">
                        @for ($week = 0; $week < 6; $week++)
                            @php
                                $rowStart = $gridStart->copy()->addDays($week * 7);
                                $rowEnd = $rowStart->copy()->addDays(6);
                                $isCurrentWeek = $today->between($rowStart, $rowEnd);
                            @endphp
                            <div class="row g-2 cal-row {{ $isCurrentWeek ? 'cal-row--current' : '' }}">
                                @for ($dow = 0; $dow < 7; $dow++)
                                    @php
                                        $cellDate = $gridStart->copy()->addDays($week * 7 + $dow);
                                        $isOtherMonth = !$cellDate->isSameMonth($viewMonth);
                                        $isToday = $cellDate->isSameDay($today);
                                        $isSelected = $cellDate->isSameDay($selectedDate);
                                        $key = $cellDate->format('Y-m-d');
                                        $count = $eventCounts[$key] ?? 0;
                                    @endphp

                                    @php
                                        $baseParams = array_merge(request()->except(['month','date']), ['date' => $cellDate->format('Y-m-d')]);
                                        if (!$cellDate->isSameMonth($viewMonth)) {
                                            $baseParams['month'] = $cellDate->format('Y-m');
                                        }
                                    @endphp

                                    <a href="{{ route('calendar', $baseParams) }}"
                                       class="col cal-day-cell {{ $isOtherMonth ? 'other-month' : '' }} {{ $isToday && !$isSelected ? 'today' : '' }} {{ $isSelected ? 'selected' : '' }} d-block text-decoration-none">
                                        <span class="cal-day-number {{ $isOtherMonth ? 'other-month' : '' }}">{{ $cellDate->day }}</span>
                                        @if (!$isOtherMonth)
                                            <span class="cal-count {{ $count > 0 ? '' : 'cal-count-zero' }}">{{ $count > 0 ? $count : '' }}</span>
                                        @endif
                                    </a>
                                @endfor
                            </div>
                        @endfor
                    </div>

                </div>
            </div>

            <!-- Right Column: Selected Date Info & Upcoming Activities List -->
            <div class="col-lg-4 d-flex flex-column gap-4">

                <!-- Selected Date Card -->
                <div class="card shadow-sm rounded-4 p-4 pastel-card-primary">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0 text-brand" style="font-size: 0.95rem;">
                            {{ $selectedDate->format('l, F j, Y') }}
                        </h6>
                        @if (!$selectedDate->isSameDay($today))
                            <a href="{{ route('calendar') }}" class="btn btn-sm btn-light border px-3 py-1 rounded-pill fw-semibold" style="font-size: 0.7rem;">Today</a>
                        @endif
                    </div>

                    @forelse ($selectedActivities as $event)
                        <div class="p-2 border-bottom border-light" style="font-size: 0.75rem;">
                            <span class="fw-bold text-dark">{{ $event->title }}</span>
                            <span class="text-muted ms-2">{{ $event->date->format('n/j/Y') }} • {{ $event->location }}</span>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">No activities scheduled for {{ $selectedDate->format('F j') }}.</p>
                    @endforelse
                </div>

                <!-- Upcoming Activities List Card -->
                <div class="card shadow-sm rounded-4 p-4 pastel-card-primary">
                    <h6 class="fw-bold mb-3 text-brand" style="font-size: 0.95rem;">Upcoming Activities</h6>

                    <div class="d-flex flex-column gap-2">
                        @forelse ($upcoming as $event)
                            <div class="p-2 border-bottom border-light" style="font-size: 0.75rem;">
                                <span class="fw-bold text-dark">{{ $event->title }}</span>
                                <span class="text-muted ms-2">{{ $event->date->format('n/j/Y') }} • {{ $event->location }}</span>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">No upcoming activities.</p>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile: default to the current week only; toggle to full month.
        function toggleMonth() {
            const grid = document.getElementById('calGrid');
            const icon = document.getElementById('toggleMonthIcon');
            const label = document.getElementById('toggleMonthLabel');

            if (grid.classList.contains('cal-week-only')) {
                grid.classList.remove('cal-week-only');
                icon.className = 'fa-solid fa-compress fa-xs';
                label.textContent = 'Collapse';
            } else {
                grid.classList.add('cal-week-only');
                icon.className = 'fa-solid fa-expand fa-xs';
                label.textContent = 'Expand';
            }
        }
    </script>
</body>
</html>