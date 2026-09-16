@extends('layouts.admin')

@section('title', 'Calendar Management - UYA Connect')

@push('styles')
<style>
    .admin-card { background-color: var(--admin-card-bg); border: 1px solid var(--admin-border); border-radius: 16px; padding: 20px; }
    .cal-weekday-header { color: var(--admin-text-subtle) !important; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }

    .cal-week-row { display: flex; gap: 4px; width: 100%; }
    .cal-day-cell { flex: 1; min-width: 0; background-color: rgba(255, 255, 255, 0.02); border: 1px solid var(--admin-border); border-radius: 10px; min-height: 80px; padding: 6px 8px; position: relative; cursor: pointer; transition: all 0.2s ease; }
    .cal-day-cell:hover { background-color: rgba(255, 255, 255, 0.06); border-color: rgba(255, 255, 255, 0.2); }
    .cal-day-cell .day-num { color: #ffffff !important; font-size: 0.88rem; font-weight: 700; }
    .cal-day-cell.other-month { background-color: rgba(0, 0, 0, 0.25); border-color: rgba(255, 255, 255, 0.03); }
    .cal-day-cell.other-month .day-num { color: #64748b !important; }
    .cal-day-cell.today-cell { border: 2px solid var(--admin-accent-purple) !important; background-color: rgba(99, 102, 241, 0.12) !important; }

    .event-pill { font-size: 0.68rem; padding: 3px 6px; border-radius: 4px; font-weight: 600; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 4px; background-color: var(--admin-accent-purple); color: #ffffff; transition: transform 0.15s ease; }
    .event-pill:hover { transform: translateY(-1px); }

    .icon-cyan { color: #38bdf8 !important; }
    .btn-purple { background-color: var(--admin-accent-purple); color: #ffffff; border: none; border-radius: 50rem; font-weight: 600; font-size: 0.85rem; padding: 9px 18px; transition: background-color 0.2s ease; }
    .btn-purple:hover { background-color: var(--admin-accent-purple-hover); color: #ffffff; }

    .btn-outline-pill { border: 1px solid rgba(255, 255, 255, 0.3); color: #ffffff; border-radius: 50rem; font-weight: 600; font-size: 0.85rem; padding: 9px 18px; background: transparent; transition: all 0.2s ease; }
    .btn-outline-pill:hover { background: rgba(255, 255, 255, 0.08); border-color: #ffffff; color: #ffffff; }

    @media (max-width: 991.98px) {
        .cal-day-cell { min-height: 55px; padding: 4px; }
        .event-pill { font-size: 0.6rem; padding: 2px 4px; }
    }
</style>
@endpush

@section('content')
    @php
        $authUser = auth()->user();
        $authName = $authUser->name ?? 'User';
        $authRole = ucfirst($authUser->role ?? 'Officer');

        $calendarDays = [];
        $dayIter = $startOfCalendar->copy();
        while ($dayIter->lte($endOfCalendar)) {
            $calendarDays[] = $dayIter->copy();
            $dayIter->addDay();
        }
        $weeks = array_chunk($calendarDays, 7);
        $initialActivity = $upcomingActivities->first();
    @endphp

    <div class="mb-4">
        <h4 class="fw-bold mb-1 text-white">Calendar</h4>
    </div>

    <div class="row g-3 g-md-4">
        <div class="col-12 col-lg-8">
            <div class="admin-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0 text-white" style="font-size: 1.1rem;">
                        <i class="fa-regular fa-calendar-days me-2" style="color: var(--admin-accent-purple);"></i>
                        <span>{{ $currentMonth->format('F Y') }}</span>
                    </h6>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('admin.calendar') }}" class="btn btn-sm btn-outline-light px-3 py-1 rounded-pill fw-semibold text-decoration-none" style="font-size: 0.78rem;">Today</a>
                        <div class="btn-group border border-secondary rounded-pill overflow-hidden shadow-sm" style="background-color: rgba(255,255,255,0.05);">
                            <a href="{{ route('admin.calendar', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}" class="btn btn-sm btn-dark px-2.5 border-0 text-white"><i class="fa-solid fa-chevron-left fa-xs"></i></a>
                            <a href="{{ route('admin.calendar', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}" class="btn btn-sm btn-dark px-2.5 border-0 text-white"><i class="fa-solid fa-chevron-right fa-xs"></i></a>
                        </div>
                    </div>
                </div>

                <div class="row text-center mb-2 g-0">
                    <div class="col cal-weekday-header">Sun</div>
                    <div class="col cal-weekday-header">Mon</div>
                    <div class="col cal-weekday-header">Tue</div>
                    <div class="col cal-weekday-header">Wed</div>
                    <div class="col cal-weekday-header">Thu</div>
                    <div class="col cal-weekday-header">Fri</div>
                    <div class="col cal-weekday-header">Sat</div>
                </div>

                <div class="d-flex flex-column gap-2" style="font-size: 0.85rem;">
                    @foreach($weeks as $week)
                        <div class="cal-week-row">
                            @foreach($week as $date)
                                @php
                                    $dateKey = $date->format('Y-m-d');
                                    $isOtherMonth = $date->month !== $currentMonth->month;
                                    $isToday = $date->isToday();
                                    $dayActivities = $activities->get($dateKey, collect());
                                @endphp
                                <div class="cal-day-cell {{ $isOtherMonth ? 'other-month' : '' }} {{ $isToday ? 'today-cell' : '' }}"
                                     onclick="selectDay('{{ $date->format('l, F j, Y') }}', {{ json_encode($dayActivities) }})">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="day-num">{{ $date->day }}</span>
                                    </div>
                                    <div class="mt-1">
                                        @foreach($dayActivities as $act)
                                            <span class="event-pill" title="{{ $act->title ?? $act->name }}"
                                                  onclick="event.stopPropagation(); displayActivityDetails({{ json_encode($act) }}, '{{ $date->format('l, F j, Y') }}')">
                                                {{ $act->title ?? $act->name }}
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

        <div class="col-12 col-lg-4 d-flex flex-column gap-3 gap-md-4">
            <div class="admin-card">
                <div id="sideCardDate" class="text-subtle mb-2 fw-semibold" style="font-size: 0.85rem;">
                    {{ $initialActivity ? \Carbon\Carbon::parse($initialActivity->date)->format('l, F j, Y') : now()->format('l, F j, Y') }}
                </div>

                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 id="sideCardTitle" class="fw-bold mb-0 text-white" style="font-size: 1.1rem;">
                        {{ $initialActivity->title ?? 'No Activities Scheduled' }}
                    </h5>
                    <span id="sideCardBadge" class="badge bg-warning bg-opacity-20 text-warning px-2 py-1 {{ $initialActivity ? '' : 'd-none' }}" style="font-size: 0.65rem;">
                        Scheduled
                    </span>
                </div>

                <div id="sideCardMeta" class="text-subtle small d-flex flex-column gap-1.5 mb-3" style="font-size: 0.85rem;">
                    <div>
                        <i class="fa-solid fa-location-dot icon-cyan me-2"></i>
                        <span id="sideCardLocation">{{ $initialActivity->location ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <i class="fa-solid fa-users icon-cyan me-2"></i>
                        <span id="sideCardParticipants">{{ isset($initialActivity->participants) ? $initialActivity->participants . ' participants' : '0 participants' }}</span>
                    </div>
                </div>

                <p id="sideCardDesc" class="text-subtle small mb-4" style="font-size: 0.85rem; line-height: 1.5;">
                    {{ $initialActivity->description ?? 'There are no activities or events scheduled for this day.' }}
                </p>

                <div class="d-flex flex-column gap-2">
                    <a id="btnViewDetails" href="{{ isset($initialActivity->id) ? route('activities.show', $initialActivity->id) : '#' }}"
                       class="btn btn-outline-pill w-100 text-center text-decoration-none d-flex align-items-center justify-content-center gap-2 {{ $initialActivity ? '' : 'disabled opacity-50' }}">
                        <i class="fa-regular fa-eye"></i>
                        <span>View Details</span>
                    </a>
                    <button type="button" id="btnViewQR" class="btn btn-purple w-100 d-flex align-items-center justify-content-center gap-2 {{ $initialActivity ? '' : 'disabled opacity-50' }}">
                        <i class="fa-solid fa-qrcode"></i>
                        <span>View QR / Attendance</span>
                    </button>
                </div>
            </div>

            <div class="admin-card">
                <h6 class="fw-bold mb-3 text-white" style="font-size: 0.95rem;">Upcoming Activities</h6>
                <div class="d-flex flex-column gap-3">
                    @forelse($upcomingActivities as $upcoming)
                        <div class="pb-2 border-bottom border-white border-opacity-10" role="button"
                             onclick="displayActivityDetails({{ json_encode($upcoming) }}, '{{ \Carbon\Carbon::parse($upcoming->date)->format('l, F j, Y') }}')">
                            <span class="fw-bold text-white d-block mb-1" style="font-size: 0.88rem;">{{ $upcoming->title ?? $upcoming->name }}</span>
                            <span class="text-subtle" style="font-size: 0.78rem;">
                                <i class="fa-regular fa-calendar icon-cyan me-1"></i> {{ \Carbon\Carbon::parse($upcoming->date)->format('n/j/Y') }} • {{ $upcoming->location ?? 'TBD' }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center text-subtle py-3 small">No upcoming activities scheduled.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function displayActivityDetails(activity, dateFormatted) {
        if (!activity) return;

        document.getElementById('sideCardDate').innerText = dateFormatted;
        document.getElementById('sideCardTitle').innerText = activity.title || activity.name || 'Activity';
        document.getElementById('sideCardLocation').innerText = activity.location || 'N/A';
        document.getElementById('sideCardParticipants').innerText = activity.participants ? activity.participants + ' participants' : '0 participants';
        document.getElementById('sideCardDesc').innerText = activity.description || 'No detailed description available.';

        document.getElementById('sideCardBadge').classList.remove('d-none');

        const viewBtn = document.getElementById('btnViewDetails');
        viewBtn.classList.remove('disabled', 'opacity-50');
        viewBtn.href = '/activities/' + (activity.id || '');

        const qrBtn = document.getElementById('btnViewQR');
        qrBtn.classList.remove('disabled', 'opacity-50');
    }

    function selectDay(dateFormatted, dayActivities) {
        document.getElementById('sideCardDate').innerText = dateFormatted;

        if (dayActivities && dayActivities.length > 0) {
            displayActivityDetails(dayActivities[0], dateFormatted);
        } else {
            document.getElementById('sideCardTitle').innerText = 'No Activities Scheduled';
            document.getElementById('sideCardLocation').innerText = 'N/A';
            document.getElementById('sideCardParticipants').innerText = '0 participants';
            document.getElementById('sideCardDesc').innerText = 'There are no activities or events scheduled for this day.';
            document.getElementById('sideCardBadge').classList.add('d-none');

            const viewBtn = document.getElementById('btnViewDetails');
            viewBtn.classList.add('disabled', 'opacity-50');
            viewBtn.href = '#';

            const qrBtn = document.getElementById('btnViewQR');
            qrBtn.classList.add('disabled', 'opacity-50');
        }
    }
</script>
@endpush