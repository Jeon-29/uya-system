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

        /* Calendar Grid styling */
        .cal-day-cell {
            background-color: #f8fafb;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            min-height: 85px;
            padding: 8px;
            position: relative;
            transition: all 0.2s ease;
        }
        .cal-day-cell.other-month {
            opacity: 0.4;
            background-color: #f1f5f9;
        }
        .cal-day-cell.active-today {
            border: 2px solid var(--uya-dark-teal);
            background-color: #f0f7f9;
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
        }
    </style>
</head>
<body>

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

            <!-- Left Column: August 2026 Grid Calendar -->
            <div class="col-lg-8">
                <div class="card shadow-sm rounded-4 p-4 pastel-card-primary">

                    <!-- Month Header Navigation -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-2 text-brand fw-bold" style="font-size: 1.1rem;">
                            <i class="fa-regular fa-calendar-days"></i>
                            <span>August 2026</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-light border px-3 py-1 rounded-pill fw-semibold" style="font-size: 0.8rem;">Today</button>
                            <div class="btn-group border rounded-pill overflow-hidden shadow-sm">
                                <button class="btn btn-sm btn-light px-2 border-0"><i class="fa-solid fa-chevron-left fa-xs"></i></button>
                                <button class="btn btn-sm btn-light px-2 border-0"><i class="fa-solid fa-chevron-right fa-xs"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Weekdays Header -->
                    <div class="row text-center text-muted fw-bold mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <div class="col">SUN</div>
                        <div class="col">MON</div>
                        <div class="col">TUE</div>
                        <div class="col">WED</div>
                        <div class="col">THU</div>
                        <div class="col">FRI</div>
                        <div class="col">SAT</div>
                    </div>

                    <!-- Days Grid (August 2026) -->
                    <div class="d-flex flex-column gap-2 text-secondary" style="font-size: 0.85rem;">

                        <!-- Row 1 -->
                        <div class="row g-2">
                            <div class="col cal-day-cell other-month"><span class="fw-semibold">26</span></div>
                            <div class="col cal-day-cell other-month"><span class="fw-semibold">27</span></div>
                            <div class="col cal-day-cell other-month"><span class="fw-semibold">28</span></div>
                            <div class="col cal-day-cell other-month"><span class="fw-semibold">29</span></div>
                            <div class="col cal-day-cell other-month"><span class="fw-semibold">30</span></div>
                            <div class="col cal-day-cell other-month"><span class="fw-semibold">31</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">1</span></div>
                        </div>

                        <!-- Row 2 -->
                        <div class="row g-2">
                            <div class="col cal-day-cell"><span class="fw-semibold">2</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">3</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">4</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">5</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">6</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">7</span></div>
                            <div class="col cal-day-cell">
                                <span class="fw-semibold">8</span>
                                <span class="event-pill text-dark" style="background-color: var(--uya-gold);">Service Day</span>
                            </div>
                        </div>

                        <!-- Row 3 -->
                        <div class="row g-2">
                            <div class="col cal-day-cell"><span class="fw-semibold">9</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">10</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">11</span></div>
                            <div class="col cal-day-cell active-today">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">12</span>
                                    <span class="badge bg-primary text-white px-1" style="font-size: 0.55rem;">Today</span>
                                </div>
                                <span class="event-pill bg-primary text-white">Web Dev Workshop</span>
                            </div>
                            <div class="col cal-day-cell"><span class="fw-semibold">13</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">14</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">15</span></div>
                        </div>

                        <!-- Row 4 -->
                        <div class="row g-2">
                            <div class="col cal-day-cell"><span class="fw-semibold">16</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">17</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">18</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">19</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">20</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">21</span></div>
                            <div class="col cal-day-cell">
                                <span class="fw-semibold">22</span>
                                <span class="event-pill text-white" style="background-color: #198754;">Leadership</span>
                            </div>
                        </div>

                        <!-- Row 5 -->
                        <div class="row g-2">
                            <div class="col cal-day-cell"><span class="fw-semibold">23</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">24</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">25</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">26</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">27</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">28</span></div>
                            <div class="col cal-day-cell">
                                <span class="fw-semibold">29</span>
                                <span class="event-pill bg-secondary text-white">Campaign</span>
                            </div>
                        </div>

                        <!-- Row 6 -->
                        <div class="row g-2">
                            <div class="col cal-day-cell"><span class="fw-semibold">30</span></div>
                            <div class="col cal-day-cell"><span class="fw-semibold">31</span></div>
                            <div class="col cal-day-cell other-month"><span class="fw-semibold">1</span></div>
                            <div class="col cal-day-cell other-month"><span class="fw-semibold">2</span></div>
                            <div class="col cal-day-cell other-month"><span class="fw-semibold">3</span></div>
                            <div class="col cal-day-cell other-month"><span class="fw-semibold">4</span></div>
                            <div class="col cal-day-cell other-month"><span class="fw-semibold">5</span></div>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Right Column: Date Info & Upcoming Activities List -->
            <div class="col-lg-4 d-flex flex-column gap-4">

                <!-- Selected Date Info Card (Showing Today's Scheduled Activity) -->
                <div class="card shadow-sm rounded-4 p-4 pastel-card-primary">
                    <h6 class="fw-bold mb-3 text-brand" style="font-size: 0.95rem;">Wednesday, August 12, 2026</h6>

                    <div class="p-3 rounded-3 border bg-light bg-opacity-50">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="fw-bold text-dark" style="font-size: 0.85rem;">Tech Workshop: Web Development</span>
                            <span class="badge rounded-pill text-white fw-normal" style="font-size: 0.6rem; background-color: #198754;">Joined</span>
                        </div>
                        <span class="text-muted small d-block mb-2" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> 8/12/2026 • SM Aura</span>
                        <p class="text-muted small mb-0" style="font-size: 0.75rem;">Learn the basics of modern web development with React and TypeScript.</p>
                    </div>
                </div>

                <!-- Upcoming Activities List Card (With Green Joined Pills) -->
                <div class="card shadow-sm rounded-4 p-4 pastel-card-primary">
                    <h6 class="fw-bold mb-3 text-brand" style="font-size: 0.95rem;">Upcoming Activities</h6>

                    <div class="d-flex flex-column gap-3">

                        <!-- Item 1 -->
                        <div class="p-3 rounded-3 border bg-light bg-opacity-25">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="fw-bold text-dark" style="font-size: 0.85rem;">Community Service Day</span>
                                <span class="badge rounded-pill text-white fw-normal" style="font-size: 0.6rem; background-color: #198754;">Joined</span>
                            </div>
                            <span class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> 8/8/2026 • Carmona City Park</span>
                        </div>

                        <!-- Item 2 -->
                        <div class="p-3 rounded-3 border bg-light bg-opacity-25">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="fw-bold text-dark" style="font-size: 0.85rem;">Tech Workshop: Web Development</span>
                                <span class="badge rounded-pill text-white fw-normal" style="font-size: 0.6rem; background-color: #198754;">Joined</span>
                            </div>
                            <span class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> 8/12/2026 • SM Aura</span>
                        </div>

                        <!-- Item 3 -->
                        <div class="p-3 rounded-3 border bg-light bg-opacity-25">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="fw-bold text-dark" style="font-size: 0.85rem;">Leadership Training</span>
                                <span class="badge rounded-pill text-white fw-normal" style="font-size: 0.6rem; background-color: #198754;">Joined</span>
                            </div>
                            <span class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> 8/22/2026 • Conference Room A</span>
                        </div>

                        <!-- Item 4 -->
                        <div class="p-3 rounded-3 border bg-light bg-opacity-25">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="fw-bold text-dark" style="font-size: 0.85rem;">Environmental Awareness Campaign</span>
                                <span class="badge rounded-pill text-white fw-normal" style="font-size: 0.6rem; background-color: #198754;">Joined</span>
                            </div>
                            <span class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar me-1"></i> 8/29/2026 • CvSU Carmona</span>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
