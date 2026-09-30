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
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        @media (min-width: 768px) {
            .container-fluid {
                padding-left: 2.5rem !important;
                padding-right: 2.5rem !important;
            }
        }

        .pastel-card-primary {
            background-color: #ffffff;
            border: 1px solid rgba(131, 182, 190, 0.25) !important;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.04);
            border-radius: 16px;
        }

        .cal-week-row {
            display: flex;
            gap: 4px;
            width: 100%;
        }

        .cal-day-cell {
            flex: 1;
            min-width: 0;
            background-color: #f8fafb;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            min-height: 95px;
            padding: 8px 6px;
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .cal-day-cell:hover {
            background-color: #edf2f7;
            border-color: var(--uya-light-blue);
        }
        .cal-day-cell.other-month {
            opacity: 0.4;
            background-color: #f1f5f9;
        }
        .cal-day-cell.active-today {
            border: 2px solid #dc3545;
            background-color: #fff5f5;
        }
        .cal-day-cell.selected-cell {
            border: 2px solid var(--uya-dark-teal) !important;
            background-color: #f0f7f9 !important;
        }
        .event-pill {
            font-size: 0.65rem;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 3px;
            background-color: var(--uya-gold);
            color: #000;
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

        @media (max-width: 767.98px) {
            .calendar-grid-wrapper:not(.expanded) .cal-week-row:not(.current-week-row) {
                display: none !important;
            }
            .calendar-grid-wrapper:not(.expanded) .cal-day-cell {
                aspect-ratio: 1;
                min-height: unset !important;
                height: auto !important;
                padding: 4px !important;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                background-color: #ffffff;
                border: 1px solid #edf2f7;
            }
            .calendar-grid-wrapper.expanded .cal-day-cell {
                aspect-ratio: 1;
                min-height: unset !important;
                padding: 4px !important;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
            .calendar-grid-wrapper:not(.expanded) .event-pill {
                display: none !important;
            }
            .calendar-grid-wrapper:not(.expanded) .date-number {
                font-size: 0.95rem !important;
            }
        }
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <div class="container-fluid py-3 py-md-4">

        <!-- Header Section -->
        <div class="row mb-3 mb-md-4 px-2 px-md-0">
            <div class="col-12">
                <h2 class="fw-bold mb-1 text-brand">Calendar</h2>
            </div>
        </div>

        <div class="row g-3 g-md-4">

            <!-- Left Column: Dynamic Grid Calendar -->
            <div class="col-lg-8">
                <div class="card shadow-sm p-2 p-md-4 pastel-card-primary">

                    <!-- Month Header Navigation & Mobile Expand Toggle -->
                    <div class="d-flex justify-content-between align-items-center mb-3 px-1">
                        <div class="d-flex align-items-center gap-2 text-brand fw-bold" style="font-size: 1.05rem;">
                            <i class="fa-regular fa-calendar-days"></i>
                            <span id="calendarTitleLabel">This week</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <!-- Mobile Expand Button -->
                            <button id="toggleCalendarBtn" class="btn btn-sm btn-link text-decoration-none text-dark fw-semibold p-0 d-md-none" style="font-size: 0.85rem;">
                                <span id="toggleText">Expand</span> <i class="fa-solid fa-chevron-down fa-xs ms-1" id="toggleIcon"></i>
                            </button>

                            <a href="{{ route('calendar') }}" class="btn btn-sm btn-light border px-3 py-1 rounded-pill fw-semibold text-decoration-none d-none d-md-inline-block" style="font-size: 0.8rem;">Today</a>
                            <div class="btn-group border rounded-pill overflow-hidden shadow-sm">
                                <a href="{{ route('calendar', ['month' => $prevMonth->month, 'year' =>$prevMonth->year]) }}" class="btn btn-sm btn-light px-2 border-0 text-dark"><i class="fa-solid fa-chevron-left fa-xs"></i></a>
                                <a href="{{ route('calendar', ['month' => $nextMonth->month, 'year' =>$nextMonth->year]) }}" class="btn btn-sm btn-light px-2 border-0 text-dark"><i class="fa-solid fa-chevron-right fa-xs"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Weekdays Header -->
                    <div class="row text-center text-muted fw-bold mb-2 g-0" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                        <div class="col">SUN</div>
                        <div class="col">MON</div>
                        <div class="col">TUE</div>
                        <div class="col">WED</div>
                        <div class="col">THU</div>
                        <div class="col">FRI</div>
                        <div class="col">SAT</div>
                    </div>

                    <!-- Dynamic Days Grid Generation -->
                    <div id="calendarGridWrapper" class="calendar-grid-wrapper d-flex flex-column gap-2 text-secondary" style="font-size: 0.85rem;">
                        @php
                            $period = \Carbon\CarbonPeriod::create($startOfCalendar,$endOfCalendar);
                            $weeks = collect($period)->chunk(7);

                            $currentWeekIndex = 0;
                            foreach ($weeks as $index =>$week) {
                                foreach ($week as $date) {
                                    if ($date->isToday()) {
                                        $currentWeekIndex =$index;
                                        break 2;
                                    }
                                }
                            }
                        @endphp

                        @foreach ($weeks as $index =>$week)
                            @php
                                $isCurrentWeek = ($index ===$currentWeekIndex);
                            @endphp
                            <div class="cal-week-row {{ $isCurrentWeek ? 'current-week-row' : '' }} {{ !$isCurrentWeek ? 'extra-week' : '' }}">
                                @foreach ($week as $date)
                                    @php
                                        $dateString = $date->format('Y-m-d');$isOtherMonth = $date->month !==$currentMonth->month;
                                        $isToday = $date->isToday();$dayEvents = $activities[$dateString] ?? collect();
                                        $eventCount =$dayEvents->count();
                                    @endphp
                                    <div class="cal-day-cell text-center text-md-start {{ $isOtherMonth ? 'other-month' : '' }} {{ $isToday ? 'active-today' : '' }}" data-date="{{ $dateString }}">

                                        <div class="d-flex justify-content-between align-items-center justify-content-md-between w-100">
                                            <span class="fw-semibold date-number {{ $isToday ? 'fw-bold text-danger' : 'text-dark' }}" style="font-size: 0.9rem;">{{ $date->format('d') }}</span>

                                            @if($isToday)
                                                <span class="badge bg-danger text-white px-1 d-none d-md-inline-block" style="font-size: 0.5rem;">Today</span>
                                            @endif

                                            @if($eventCount > 0)
                                                <span class="badge rounded-pill bg-danger d-md-none" style="font-size: 0.5rem; padding: 0.2em 0.4em;">
                                                    {{ $eventCount }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="mt-1">
                                            @foreach ($dayEvents as $event)
                                                <span class="event-pill d-none d-md-block" title="{{ $event->title ?? 'Activity' }}">
                                                    {{ $event->title ?? 'Activity' }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            <!-- Right Column: Date Info & Upcoming Activities List -->
            <div class="col-lg-4 d-flex flex-column gap-3 gap-md-4">

                <!-- Selected Date Info Card -->
                <div class="card shadow-sm p-3 p-md-4 pastel-card-primary">
                    <h6 id="selectedDateTitle" class="fw-bold mb-3 text-brand" style="font-size: 0.95rem;">{{ now()->format('l, F j, Y') }}</h6>

                    <div id="selectedDateEventsContainer" class="d-flex flex-column gap-2">
                        @php
                            $todayString = now()->format('Y-m-d');$todayEvents = $activities[$todayString] ?? collect();
                            $authUserId = auth()->id();
                        @endphp

                        @forelse ($todayEvents as $event)
                            @php
                                $isJoined = false;
                                if (isset($event->participants)) {$isJoined = $event->participants->contains('user_id',$authUserId);
                                }
                            @endphp
                            <div class="p-3 rounded-3 border bg-light bg-opacity-50">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $event->title ?? 'Activity' }}</span>
                                    @if($isJoined)
                                        <span class="badge rounded-pill text-white fw-normal" style="font-size: 0.6rem; background-color: #198754;">Joined</span>
                                    @elseif($event->status === 'completed')
                                        <span class="badge rounded-pill text-white fw-normal bg-secondary" style="font-size: 0.6rem;">Completed</span>
                                    @endif
                                </div>
                                <span class="text-muted small d-block mb-2" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> {{ $todayString }} • {{$event->location ?? 'TBD' }}</span>
                                <p class="text-muted small mb-2" style="font-size: 0.75rem;">{{ $event->description ?? 'No description provided.' }}</p>

                                <a href="{{ route('activities.show', $event->id) }}" class="btn btn-sm rounded-pill py-1 px-3 custom-btn-outline fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-eye me-1"></i> View Details
                                </a>
                            </div>
                        @empty
                            <div class="p-3 rounded-3 border bg-light bg-opacity-50 text-center text-muted small">
                                No activities scheduled for this date.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Upcoming Activities List Card -->
                <div class="card shadow-sm p-3 p-md-4 pastel-card-primary">
                    <h6 class="fw-bold mb-3 text-brand" style="font-size: 0.95rem;">Upcoming Activities</h6>

                    <div class="d-flex flex-column gap-3">
                        @forelse ($upcomingActivities as $activity)
                            @php
                                $isJoined = false;
                                if (isset($activity->participants)) {
                                    $isJoined =$activity->participants->contains('user_id', auth()->id());
                                }
                            @endphp
                            <div class="p-3 rounded-3 border bg-light bg-opacity-25">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $activity->title }}</span>
                                    @if($isJoined)
                                        <span class="badge rounded-pill text-white fw-normal" style="font-size: 0.6rem; background-color: #198754;">Joined</span>
                                    @endif
                                </div>
                                <span class="text-muted d-block mb-2" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($activity->date)->format('n/j/Y') }} • {{$activity->location ?? 'TBD' }}</span>

                                <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm rounded-pill py-1 px-3 custom-btn-outline fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-eye me-1"></i> View Details
                                </a>
                            </div>
                        @empty
                            <div class="text-muted text-center py-3 small">No upcoming activities found.</div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap JS Bundle & Click Handler Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const authUserId = {{ auth()->id() }};

        // Expand / Collapse Mobile Week View Toggle Script
        const toggleBtn = document.getElementById('toggleCalendarBtn');
        const gridWrapper = document.getElementById('calendarGridWrapper');
        const toggleIcon = document.getElementById('toggleIcon');
        const toggleText = document.getElementById('toggleText');
        const calendarTitleLabel = document.getElementById('calendarTitleLabel');
        const fullMonthName = "{{ $currentMonth->format('F Y') }}";

        if (toggleBtn && gridWrapper) {
            toggleBtn.addEventListener('click', function() {
                gridWrapper.classList.toggle('expanded');
                const isExpanded = gridWrapper.classList.contains('expanded');

                if (isExpanded) {
                    toggleIcon.className = 'fa-solid fa-chevron-up fa-xs ms-1';
                    toggleText.innerText = 'Collapse';
                    calendarTitleLabel.innerText = fullMonthName;
                } else {
                    toggleIcon.className = 'fa-solid fa-chevron-down fa-xs ms-1';
                    toggleText.innerText = 'Expand';
                    calendarTitleLabel.innerText = 'This week';
                }
            });
        }

        // Calendar Date Click & Event Details Handler
        const monthEvents = @json($activities);

        document.querySelectorAll('.cal-day-cell').forEach(cell => {
            cell.addEventListener('click', function() {
                document.querySelectorAll('.cal-day-cell').forEach(c => c.classList.remove('selected-cell'));
                this.classList.add('selected-cell');

                const dateStr = this.getAttribute('data-date');
                const events = monthEvents[dateStr] || [];

                const dateObj = new Date(dateStr + 'T00:00:00');
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                document.getElementById('selectedDateTitle').innerText = dateObj.toLocaleDateString('en-US', options);

                const container = document.getElementById('selectedDateEventsContainer');
                container.innerHTML = '';

                if (events.length > 0) {
                    events.forEach(event => {
                        let badgeHtml = '';
                        const isJoined = event.participants && event.participants.some(p => p.user_id === authUserId);

                        if (isJoined) {
                            badgeHtml = `<span class="badge rounded-pill text-white fw-normal" style="font-size: 0.6rem; background-color: #198754;">Joined</span>`;
                        } else if (event.status === 'completed') {
                            badgeHtml = `<span class="badge rounded-pill text-white fw-normal bg-secondary" style="font-size: 0.6rem;">Completed</span>`;
                        }

                        container.innerHTML += `
                            <div class="p-3 rounded-3 border bg-light bg-opacity-50">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <span class="fw-bold text-dark" style="font-size: 0.85rem;">${event.title || 'Activity'}</span>
                                    ${badgeHtml}
                                </div>
                                <span class="text-muted small d-block mb-2" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> ${dateStr} • ${event.location || 'TBD'}</span>
                                <p class="text-muted small mb-2" style="font-size: 0.75rem;">${event.description || 'No description provided.'}</p>

                                <a href="/activities/${event.id}" class="btn btn-sm rounded-pill py-1 px-3 custom-btn-outline fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-eye me-1"></i> View Details
                                </a>
                            </div>
                        `;
                    });
                } else {
                    container.innerHTML = `
                        <div class="p-3 rounded-3 border bg-light bg-opacity-50 text-center text-muted small">
                            No activities scheduled for this date.
                        </div>
                    `;
                }
            });
        });
    </script>
</body>
</html>
