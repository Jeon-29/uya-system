<!-- Floating Modern Navbar -->
<nav class="navbar navbar-expand-lg fixed-top my-2 mx-3 rounded-4 shadow-sm px-4 py-2"
    style="background-color: var(--uya-dark-teal); border: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="container-fluid px-0">

        <!-- Brand / Logo Section -->
        <a class="navbar-brand d-flex align-items-center text-white fw-bold gap-2 text-decoration-none flex-shrink-0"
            href="{{ route('dashboard') }}">
            <div
                style="width: 43px; height: 48px; background-color: #83b6be; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; border: 3px solid var(--uya-gold); box-shadow: 0 4px 10px rgba(0,0,0,0.3); overflow: hidden;">
                <img src="{{ asset('images/logo.jpg') }}" alt="UYA Logo"
                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
            </div>
            <span style="letter-spacing: 0.5px; font-size: 1.05rem;">UYA Connect</span>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler border-0 text-white shadow-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Navbar Contents -->
        <div class="collapse navbar-collapse justify-content-between align-items-center" id="navbarNav">

            <!-- Center Navigation Items (Dynamic Route Checking) -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 flex-row gap-3 justify-content-center">

                <!-- Dashboard Tab -->
                <li class="nav-item">
                    <a class="nav-link text-center px-3.5 py-1.5 rounded-3 {{ request()->routeIs('dashboard') ? '' : 'hover-glass text-white' }}"
                        @if (request()->routeIs('dashboard')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important;" @endif
                        href="{{ route('dashboard') }}">
                        <span
                            class="d-block {{ request()->routeIs('dashboard') ? 'fw-semibold text-dark' : 'fw-normal text-white-50' }}"
                            style="font-size: 0.7rem;">Dashboard</span>
                        <i class="fa-solid fa-border-all fa-xs mt-1"></i>
                    </a>
                </li>

                <!-- Activities Tab -->
                <li class="nav-item">
                    <a class="nav-link text-center px-3.5 py-1.5 rounded-3 {{ request()->routeIs('activities') ? '' : 'hover-glass text-white' }}"
                        @if (request()->routeIs('activities')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important;" @endif
                        href="{{ route('activities') }}">
                        <span
                            class="d-block {{ request()->routeIs('activities') ? 'fw-semibold text-dark' : 'fw-normal text-white-50' }}"
                            style="font-size: 0.7rem;">Activities</span>
                        <i class="fa-regular fa-calendar fa-xs mt-1"></i>
                    </a>
                </li>

                <!-- Calendar Tab -->
                <li class="nav-item">
                    <a class="nav-link text-center px-3.5 py-1.5 rounded-3 {{ request()->routeIs('calendar*') ? '' : 'hover-glass text-white' }}"
                        @if (request()->routeIs('calendar*')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important;" @endif
                        href="{{ route('calendar') }}">
                        <span
                            class="d-block {{ request()->routeIs('calendar*') ? 'fw-semibold text-dark' : 'fw-normal text-white-50' }}"
                            style="font-size: 0.7rem;">Calendar</span>
                        <i class="fa-solid fa-lightbulb fa-xs mt-1"></i>
                    </a>
                </li>

                <!-- Proposals Tab -->
                <li class="nav-item">
                    <a class="nav-link text-center px-3.5 py-1.5 rounded-3 {{ request()->routeIs('proposals*') ? '' : 'hover-glass text-white' }}"
                        @if (request()->routeIs('proposals*')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important;" @endif
                        href="{{ route('proposals') }}">
                        <span
                            class="d-block {{ request()->routeIs('proposals*') ? 'fw-semibold text-dark' : 'fw-normal text-white-50' }}"
                            style="font-size: 0.7rem;">Proposals</span>
                        <i class="fa-regular fa-clipboard fa-xs mt-1"></i>
                    </a>
                </li>

                <!-- Certificates Tab -->
                <li class="nav-item">
                    <a class="nav-link text-center px-3.5 py-1.5 rounded-3 {{ request()->routeIs('certificates*') ? '' : 'hover-glass text-white' }}"
                        @if (request()->routeIs('certificates*')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important;" @endif
                        href="{{ route('certificates') }}">
                        <span
                            class="d-block {{ request()->routeIs('certificates*') ? 'fw-semibold text-dark' : 'fw-normal text-white-50' }}"
                            style="font-size: 0.7rem;">Certificates</span>
                        <i class="fa-solid fa-ribbon fa-xs mt-1"></i>
                    </a>
                </li>

                <!-- Announcements Tab -->
                <li class="nav-item">
                    <a class="nav-link text-center px-3.5 py-1.5 rounded-3 {{ request()->routeIs('announcements*') ? '' : 'hover-glass text-white' }}"
                        @if (request()->routeIs('announcements*')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important;" @endif
                        href="{{ route('announcements') }}">
                        <span
                            class="d-block {{ request()->routeIs('announcements*') ? 'fw-semibold text-dark' : 'fw-normal text-white-50' }}"
                            style="font-size: 0.7rem;">Announcements</span>
                        <i class="fa-solid fa-bullhorn fa-xs mt-1"></i>
                    </a>
                </li>

            </ul>

            <!-- Right-Side Actions with Notification Pop-up -->
            <div
                class="d-flex align-items-center justify-content-center gap-4 mt-3 mt-lg-0 position-relative flex-shrink-0">

                <!-- Notification Bell Button -->
                <div class="position-relative">
                    <button id="notifBtn" onclick="toggleNotifications()"
                        class="btn position-relative text-white p-2 rounded-circle border-0 hover-icon"
                        style="background: transparent;">
                        <i class="fa-regular fa-bell fa-lg"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark fw-bold"
                            style="font-size: 0.55rem;">
                            3
                        </span>
                    </button>

                    <!-- Notification Pop-up Card -->
                    <div id="notifPopup"
                        class="card shadow-lg border-0 rounded-4 position-absolute end-0 mt-2 p-3 d-none text-start"
                        style="width: 380px; z-index: 1050; background-color: #ffffff;">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 1rem;">Notifications</h6>
                                <span class="text-muted" style="font-size: 0.75rem;">3 unread notifications</span>
                            </div>
                            <a href="#" class="text-decoration-none text-muted small fw-semibold"
                                style="font-size: 0.75rem;"><i class="fa-solid fa-check me-1"></i>Mark all read</a>
                        </div>

                        <!-- Notification Scrollable Wrapper -->
                        <div style="max-height: 380px; overflow-y: auto;" class="pe-1">

                            <!-- Notification Item 1 -->
                            <div
                                class="p-2.5 mb-2 rounded-3 ref-notif-item position-relative bg-white border-bottom pb-3">
                                <div class="d-flex gap-3 align-start">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                                        style="width: 40px; height: 40px; background-color: #e4edf0; color: #224d5b; border: 1px solid #d0dce0;">
                                        <i class="fa-regular fa-calendar-days"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <span class="fw-bold text-dark" style="font-size: 0.85rem;">New Activity
                                                Posted</span>
                                            <button class="btn-close shadow-none" style="font-size: 0.55rem;"></button>
                                        </div>
                                        <p class="text-secondary mb-2 mt-1"
                                            style="font-size: 0.75rem; line-height: 1.25;">Community Service Day has
                                            been added to the activity list for May 2026.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    class="badge rounded-pill bg-secondary bg-opacity-2 text-dark px-2 py-1 fw-normal"
                                                    style="font-size: 0.6rem; background-color: #e2e8f0 !important;">Unread</span>
                                                <a href="#" class="text-decoration-none fw-semibold"
                                                    style="font-size: 0.7rem; color: #224d5b;">View activity</a>
                                            </div>
                                            <span class="text-muted" style="font-size: 0.65rem;">May 22</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notification Item 2 -->
                            <div
                                class="p-2.5 mb-2 rounded-3 ref-notif-item position-relative bg-white border-bottom pb-3">
                                <div class="d-flex gap-3 align-start">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                                        style="width: 40px; height: 40px; background-color: #e4edf0; color: #224d5b; border: 1px solid #d0dce0;">
                                        <i class="fa-regular fa-clipboard-check"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <span class="fw-bold text-dark" style="font-size: 0.85rem;">Attendance QR
                                                Open</span>
                                            <button class="btn-close shadow-none"
                                                style="font-size: 0.55rem;"></button>
                                        </div>
                                        <p class="text-secondary mb-2 mt-1"
                                            style="font-size: 0.75rem; line-height: 1.25;">Attendance validation is
                                            open for Tech Workshop: Web Development.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge rounded-pill text-dark px-2 py-1 fw-normal"
                                                    style="font-size: 0.6rem; background-color: #e2e8f0 !important;">Unread</span>
                                                <a href="#" class="text-decoration-none fw-semibold"
                                                    style="font-size: 0.7rem; color: #224d5b;">Scan QR</a>
                                            </div>
                                            <span class="text-muted" style="font-size: 0.65rem;">May 22</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notification Item 3 -->
                            <div class="p-2.5 rounded-3 ref-notif-item position-relative bg-white">
                                <div class="d-flex gap-3 align-start">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                                        style="width: 40px; height: 40px; background-color: #e4edf0; color: #224d5b; border: 1px solid #d0dce0;">
                                        <i class="fa-regular fa-square-check"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <span class="fw-bold text-dark" style="font-size: 0.85rem;">Anonymous Vote
                                                Received</span>
                                            <button class="btn-close shadow-none"
                                                style="font-size: 0.55rem;"></button>
                                        </div>
                                        <p class="text-secondary mb-2 mt-1"
                                            style="font-size: 0.75rem; line-height: 1.25;">A member voted on your
                                            proposal "CleanUp Drive in Carmona City."</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge rounded-pill text-dark px-2 py-1 fw-normal"
                                                    style="font-size: 0.6rem; background-color: #e2e8f0 !important;">Unread</span>
                                                <a href="#" class="text-decoration-none fw-semibold"
                                                    style="font-size: 0.7rem; color: #224d5b;">View my proposal</a>
                                            </div>
                                            <span class="text-muted" style="font-size: 0.65rem;">May 22</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Profile Link -->
                <a href="{{ route('profile') }}"
                    class="text-white text-decoration-none d-flex align-items-center justify-content-center rounded-circle fw-bold shadow-sm"
                    style="width: 34px; height: 34px; background-color: var(--uya-light-blue); border: 2px solid var(--uya-gold);"
                    title="Profile">
                    <i class="fa-regular fa-user fa-xs text-white"></i>
                </a>

                <!-- Logout -->
                <button type="button"
                    class="btn text-white-50 text-decoration-none p-2 rounded-circle hover-danger border-0 bg-transparent"
                    title="Logout" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-md"></i>
                </button>
                <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="d-none">
                    @csrf
                </form>

            </div>

        </div>
    </div>
</nav>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-labelledby="logoutConfirmModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-body text-center p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                    style="width: 56px; height: 56px; background-color: rgba(220, 53, 69, 0.1);">
                    <i class="fa-solid fa-arrow-right-from-bracket text-danger fa-lg"></i>
                </div>
                <h5 class="fw-bold mb-2" id="logoutConfirmModalLabel">Log out of UYA Connect?</h5>
                <p class="text-muted small mb-4">You'll need to sign in again to access your account.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="logoutForm" class="btn btn-danger rounded-pill px-4 fw-semibold">
                        Yes, Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --uya-dark-teal: #224d5b;
        --uya-light-blue: #83b6be;
        --uya-gold: #D8B257;
    }

    .hover-glass:hover {
        background-color: rgba(255, 255, 255, 0.08);
    }

    .hover-glass:hover span {
        color: #ffffff !important;
    }

    .hover-icon:hover,
    .hover-danger:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: var(--uya-gold) !important;
    }

    .inner-popup-item {
        background-color: #f3f7f9;
        border: 1px solid #dce5e8;
        transition: background-color 0.15s ease;
    }

    .inner-popup-item:hover {
        background-color: #eaf1f4;
    }

    body {
        padding-top: 85px;
    }
</style>

<script>
    function toggleNotifications() {
        const popup = document.getElementById('notifPopup');
        popup.classList.toggle('d-none');
    }
    window.addEventListener('click', function(e) {
        const popup = document.getElementById('notifPopup');
        const btn = document.getElementById('notifBtn');
        if (!popup.contains(e.target) && !btn.contains(e.target)) {
            popup.classList.add('d-none');
        }
    });
</script>
