@include('layouts.background')

<!-- Floating Modern Navbar with Liquid Glass Effect -->
@php
    $user = auth()->user();
    $unreadNotifs = auth()->check() ? $user->unreadNotifications : collect();
    $unreadCount = $unreadNotifs->count();
    $hasPhoto = $user && !empty($user->profile_photo_path);
@endphp

<!-- Global Floating Toast Notification -->
@if (session('success') || session('error'))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1090; margin-top: 85px;">
        <div id="globalToast" class="toast align-items-center text-white {{ session('success') ? 'bg-success' : 'bg-danger' }} border-0 show shadow-lg rounded-4" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-semibold py-3 px-3" style="font-size: 0.88rem;">
                    <i class="{{ session('success') ? 'fa-solid fa-circle-check me-2' : 'fa-solid fa-circle-exclamation me-2' }}"></i>
                    {{ session('success') ?? session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-3 m-auto shadow-none" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

<nav class="navbar navbar-expand-lg fixed-top my-2 mx-2 mx-md-3 rounded-4 px-3 px-md-4 py-2 navbar-glass"
    style="border: 1px solid rgba(255, 255, 255, 0.35);">
    <div class="container-fluid" style="padding-left: 0 !important; padding-right: 0 !important; margin-left: 0 !important; margin-right: 0 !important;">

        <!-- Brand / Logo Section -->
        <a class="navbar-brand d-flex align-items-center text-white fw-bold gap-2 text-decoration-none flex-shrink-0"
            href="{{ route('dashboard') }}">
            <div
                style="width: 43px; height: 43px; background-color: #83b6be; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; border: 2px solid var(--uya-gold); box-shadow: 0 4px 10px rgba(0,0,0,0.15); overflow: hidden; flex-shrink: 0;">
                <img src="{{ asset('images/logo.jpg') }}" alt="UYA Logo"
                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
            </div>
            <span style="letter-spacing: 0.5px; font-size: 1.05rem; text-shadow: 0 1px 2px rgba(0,0,0,0.2);">Union of Youth Alliance</span>
        </a>

        <!-- Mobile Toggle -->
        <button id="hamburgerBtn" class="navbar-toggler hamburger-btn border-0 text-white shadow-none" type="button"
            aria-label="Toggle navigation" aria-expanded="false" aria-controls="mobileMenu"
            onclick="toggleMobileMenu()">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>

        <!-- Navbar Contents -->
        <div class="collapse navbar-collapse justify-content-between align-items-center" id="navbarNav">

            <!-- Center Navigation Items -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 flex-row gap-2 justify-content-center">
                <li class="nav-item">
                    <a class="nav-link text-center px-3 py-1.5 rounded-3 {{ request()->routeIs('dashboard') ? '' : 'hover-glass text-white' }}"
                        @if (request()->routeIs('dashboard')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important; box-shadow: 0 2px 8px rgba(216,178,87,0.4);" @endif
                        href="{{ route('dashboard') }}">
                        <span class="d-block {{ request()->routeIs('dashboard') ? 'fw-bold text-dark' : 'fw-normal text-white-50' }}" style="font-size: 0.7rem;">Dashboard</span>
                        <i class="fa-solid fa-border-all fa-xs mt-1"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center px-3 py-1.5 rounded-3 {{ request()->routeIs('activities') ? '' : 'hover-glass text-white' }}"
                        @if (request()->routeIs('activities')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important; box-shadow: 0 2px 8px rgba(216,178,87,0.4);" @endif
                        href="{{ route('activities') }}">
                        <span class="d-block {{ request()->routeIs('activities') ? 'fw-bold text-dark' : 'fw-normal text-white-50' }}" style="font-size: 0.7rem;">Activities</span>
                        <i class="fa-regular fa-calendar fa-xs mt-1"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center px-3 py-1.5 rounded-3 {{ request()->routeIs('calendar*') ? '' : 'hover-glass text-white' }}"
                        @if (request()->routeIs('calendar*')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important; box-shadow: 0 2px 8px rgba(216,178,87,0.4);" @endif
                        href="{{ route('calendar') }}">
                        <span class="d-block {{ request()->routeIs('calendar*') ? 'fw-bold text-dark' : 'fw-normal text-white-50' }}" style="font-size: 0.7rem;">Calendar</span>
                        <i class="fa-solid fa-lightbulb fa-xs mt-1"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center px-3 py-1.5 rounded-3 {{ request()->routeIs('proposals*') ? '' : 'hover-glass text-white' }}"
                        @if (request()->routeIs('proposals*')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important; box-shadow: 0 2px 8px rgba(216,178,87,0.4);" @endif
                        href="{{ route('proposals') }}">
                        <span class="d-block {{ request()->routeIs('proposals*') ? 'fw-bold text-dark' : 'fw-normal text-white-50' }}" style="font-size: 0.7rem;">Proposals</span>
                        <i class="fa-regular fa-clipboard fa-xs mt-1"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center px-3 py-1.5 rounded-3 {{ request()->routeIs('certificates*') ? '' : 'hover-glass text-white' }}"
                        @if (request()->routeIs('certificates*')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important; box-shadow: 0 2px 8px rgba(216,178,87,0.4);" @endif
                        href="{{ route('certificates') }}">
                        <span class="d-block {{ request()->routeIs('certificates*') ? 'fw-bold text-dark' : 'fw-normal text-white-50' }}" style="font-size: 0.7rem;">Certificates</span>
                        <i class="fa-solid fa-ribbon fa-xs mt-1"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center px-3 py-1.5 rounded-3 {{ request()->routeIs('announcements*') ? '' : 'hover-glass text-white' }}"
                        @if (request()->routeIs('announcements*')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important; box-shadow: 0 2px 8px rgba(216,178,87,0.4);" @endif
                        href="{{ route('announcements') }}">
                        <span class="d-block {{ request()->routeIs('announcements*') ? 'fw-bold text-dark' : 'fw-normal text-white-50' }}" style="font-size: 0.7rem;">Announcements</span>
                        <i class="fa-solid fa-bullhorn fa-xs mt-1"></i>
                    </a>
                </li>
            </ul>

            <!-- Right-Side Actions -->
            <div class="d-flex align-items-center justify-content-center gap-3 mt-3 mt-lg-0 position-relative flex-shrink-0">

                <!-- Notification Bell Button -->
                <div class="position-relative">
                    <button id="notifBtn" onclick="toggleNotifications()"
                        class="btn position-relative text-white rounded-circle border-0 d-flex align-items-center justify-content-center hover-icon"
                        style="width: 36px; height: 36px; background: rgba(255, 255, 255, 0.12);">
                        <i class="fa-regular fa-bell fa-sm"></i>
                        @if($unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark fw-bold" style="font-size: 0.55rem;">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </button>

                    <!-- Liquid Glass Notification Pop-up Card -->
                    <div id="notifPopup"
                        class="card shadow-lg border-0 rounded-4 position-absolute end-0 mt-2 p-3 d-none text-start glass-popup-card"
                        style="width: 380px; z-index: 1050;">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2 border-secondary border-opacity-10">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 1rem;">Notifications</h6>
                                <span class="text-muted" style="font-size: 0.75rem;">{{ $unreadCount }} unread notifications</span>
                            </div>
                            @if($unreadCount > 0)
                                @if(Route::has('notifications.read-all'))
                                    <form method="POST" action="{{ route('notifications.read-all') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-link text-decoration-none text-muted p-0 small fw-semibold" style="font-size: 0.75rem;">
                                            <i class="fa-solid fa-check me-1"></i>Mark all read
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>

                        <!-- Notification Scrollable Wrapper -->
                        <div style="max-height: 380px; overflow-y: auto;" class="pe-1">
                            @forelse($unreadNotifs as $notif)
                                @php
                                    $data = $notif->data ?? [];
                                    $title = $data['title'] ?? 'Notification';
                                    $message = $data['message'] ?? '';
                                    $icon = $data['icon'] ?? 'fa-regular fa-bell';

                                    // Support both 'action_url' and 'url'
                                    $rawUrl = $data['action_url'] ?? $data['url'] ?? '#';

                                    // Dynamic fallback route resolver if rawUrl is '#' or empty
                                    if ($rawUrl === '#' || empty($rawUrl)) {
                                        if (isset($data['activity_id'])) {
                                            $rawUrl = Route::has('activities.show') ? route('activities.show', $data['activity_id']) : route('activities');
                                        } elseif (isset($data['proposal_id'])) {
                                            $rawUrl = Route::has('proposals.show') ? route('proposals.show', $data['proposal_id']) : route('proposals');
                                        } elseif (str_contains(strtolower($title), 'completed') || str_contains(strtolower($title), 'certificate') || str_contains(strtolower($message), 'certificate')) {
                                            $rawUrl = route('certificates');
                                        } elseif (str_contains(strtolower($title), 'activity') || str_contains(strtolower($title), 'registration')) {
                                            $rawUrl = route('activities');
                                        } elseif (str_contains(strtolower($title), 'announcement')) {
                                            $rawUrl = route('announcements');
                                        } else {
                                            $rawUrl = Route::has('notifications') ? route('notifications') : '#';
                                        }
                                    }

                                    $actionUrl = $rawUrl;
                                    $actionText = $data['action_text'] ?? 'View';
                                @endphp
                                <div class="p-2.5 mb-2 rounded-3 ref-notif-item position-relative glass-subcard shadow-sm pb-3">
                                    <div class="d-flex gap-3 align-start">
                                        <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width: 36px; height: 36px; background-color: rgba(131, 182, 190, 0.25); color: #224d5b; border: 1px solid rgba(255,255,255,0.6);">
                                            <i class="{{ $icon }} fa-sm"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $title }}</span>
                                                @if(Route::has('notifications.read'))
                                                    <form method="POST" action="{{ route('notifications.read', $notif->id) }}">
                                                        @csrf
                                                        <button type="submit" class="btn-close shadow-none" style="font-size: 0.55rem;"></button>
                                                    </form>
                                                @endif
                                            </div>
                                            <p class="text-secondary mb-2 mt-1" style="font-size: 0.75rem; line-height: 1.25;">
                                                {{ $message }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge rounded-pill text-dark px-2 py-1 fw-normal" style="font-size: 0.6rem; background-color: rgba(255,255,255,0.6) !important;">Unread</span>
                                                    <a href="{{ $actionUrl }}"
                                                       data-read-url="{{ Route::has('notifications.read') ? route('notifications.read', $notif->id) : '' }}"
                                                       class="text-decoration-none fw-semibold navbar-notif-view-link" style="font-size: 0.7rem; color: #224d5b;">
                                                        {{ $actionText }}
                                                    </a>
                                                </div>
                                                <span class="text-muted" style="font-size: 0.65rem;">{{ $notif->created_at ? $notif->created_at->diffForHumans() : '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted small">
                                    <i class="fa-regular fa-bell-slash fa-lg mb-2 d-block text-secondary"></i>
                                    No new unread notifications.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Profile Link -->
                <a href="{{ route('profile') }}"
                    class="text-white text-decoration-none d-flex align-items-center justify-content-center rounded-circle fw-bold shadow-sm flex-shrink-0 hover-icon overflow-hidden"
                    style="width: 36px; height: 36px; background-color: var(--uya-light-blue); border: 2px solid var(--uya-gold);"
                    title="Profile">
                    @if($hasPhoto)
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fa-regular fa-user fa-sm text-white"></i>
                    @endif
                </a>

                <!-- Logout Button -->
                <button type="button"
                    class="btn text-white-50 text-decoration-none rounded-circle border-0 d-flex align-items-center justify-content-center hover-danger flex-shrink-0"
                    style="width: 36px; height: 36px; background: rgba(255, 255, 255, 0.12);"
                    title="Logout" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-sm"></i>
                </button>
                <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="d-none">
                    @csrf
                </form>

            </div>

        </div>
    </div>
</nav>

<!-- Mobile Slide-In Menu -->
<div id="mobileMenu" class="mobile-menu" aria-hidden="true">
    <div class="mobile-menu-inner glass-mobile-menu">
        <div class="mobile-menu-header">
            <span class="mobile-menu-title">Menu</span>
            <button class="mobile-menu-close" type="button" aria-label="Close menu" onclick="closeMobileMenu()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <ul class="mobile-nav-list">
            <li style="--i: 0;">
                <a class="mobile-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" @if (request()->routeIs('dashboard')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important;" @endif onclick="closeMobileMenu()">
                    <i class="fa-solid fa-border-all fa-fw"></i><span>Dashboard</span>
                </a>
            </li>
            <li style="--i: 1;">
                <a class="mobile-nav-link {{ request()->routeIs('activities') ? 'active' : '' }}" href="{{ route('activities') }}" @if (request()->routeIs('activities')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important;" @endif onclick="closeMobileMenu()">
                    <i class="fa-regular fa-calendar fa-fw"></i><span>Activities</span>
                </a>
            </li>
            <li style="--i: 2;">
                <a class="mobile-nav-link {{ request()->routeIs('calendar*') ? 'active' : '' }}" href="{{ route('calendar') }}" @if (request()->routeIs('calendar*')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important;" @endif onclick="closeMobileMenu()">
                    <i class="fa-solid fa-lightbulb fa-fw"></i><span>Calendar</span>
                </a>
            </li>
            <li style="--i: 3;">
                <a class="mobile-nav-link {{ request()->routeIs('proposals*') ? 'active' : '' }}" href="{{ route('proposals') }}" @if (request()->routeIs('proposals*')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important;" @endif onclick="closeMobileMenu()">
                    <i class="fa-regular fa-clipboard fa-fw"></i><span>Proposals</span>
                </a>
            </li>
            <li style="--i: 4;">
                <a class="mobile-nav-link {{ request()->routeIs('certificates*') ? 'active' : '' }}" href="{{ route('certificates') }}" @if (request()->routeIs('certificates*')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important;" @endif onclick="closeMobileMenu()">
                    <i class="fa-solid fa-ribbon fa-fw"></i><span>Certificates</span>
                </a>
            </li>
            <li style="--i: 5;">
                <a class="mobile-nav-link {{ request()->routeIs('announcements*') ? 'active' : '' }}" href="{{ route('announcements') }}" @if (request()->routeIs('announcements*')) style="background-color: var(--uya-gold); color: var(--uya-dark-teal) !important;" @endif onclick="closeMobileMenu()">
                    <i class="fa-solid fa-bullhorn fa-fw"></i><span>Announcements</span>
                </a>
            </li>
        </ul>

        <div class="mobile-menu-divider"></div>

        <div class="mobile-menu-actions">
            <a href="{{ Route::has('notifications') ? route('notifications') : '#' }}" class="mobile-action-link" onclick="closeMobileMenu()">
                <div class="mobile-action-icon">
                    <i class="fa-regular fa-bell fa-fw"></i>
                    @if($unreadCount > 0)
                        <span class="mobile-badge">{{ $unreadCount }}</span>
                    @endif
                </div>
                <span>Notifications</span>
            </a>
            <a href="{{ route('profile') }}" class="mobile-action-link" onclick="closeMobileMenu()">
                <div class="mobile-action-icon d-flex align-items-center justify-content-center">
                    @if($hasPhoto)
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover; margin-top: -2px;">
                    @else
                        <i class="fa-regular fa-user fa-fw"></i>
                    @endif
                </div>
                <span>Profile</span>
            </a>
            <a href="#" class="mobile-action-link text-danger" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal" onclick="closeMobileMenu()">
                <div class="mobile-action-icon"><i class="fa-solid fa-arrow-right-from-bracket fa-fw"></i></div>
                <span>Logout</span>
            </a>
        </div>
    </div>
</div>

<div id="mobileBackdrop" class="mobile-backdrop" onclick="closeMobileMenu()"></div>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-labelledby="logoutConfirmModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 glass-modal-content border-0 shadow-lg">
            <div class="modal-body text-center p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                    style="width: 56px; height: 56px; background-color: rgba(220, 53, 69, 0.12); border: 1px solid rgba(220, 53, 69, 0.2);">
                    <i class="fa-solid fa-arrow-right-from-bracket text-danger fa-sm"></i>
                </div>
                <h5 class="fw-bold mb-2 text-dark" id="logoutConfirmModalLabel">Log out of UYA Connect?</h5>
                <p class="text-muted small mb-4">You'll need to sign in again to access your account.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold border shadow-sm"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="logoutForm" class="btn btn-danger rounded-pill px-4 fw-semibold shadow-sm">
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

    .navbar-glass {
        background: rgba(34, 77, 91, 0.82) !important;
        backdrop-filter: blur(16px) saturate(160%);
        -webkit-backdrop-filter: blur(16px) saturate(160%);
        box-shadow: 0 8px 32px 0 rgba(34, 77, 91, 0.25), inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .glass-popup-card,
    .glass-modal-content {
        background: rgba(255, 255, 255, 0.85) !important;
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.9) !important;
        box-shadow: 0 16px 40px rgba(34, 77, 91, 0.18), inset 0 1px 0 rgba(255, 255, 255, 1) !important;
    }

    .glass-subcard {
        background: rgba(255, 255, 255, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.9) !important;
    }

    .hover-glass:hover {
        background-color: rgba(255, 255, 255, 0.12);
    }

    .hover-glass:hover span {
        color: #ffffff !important;
    }

    .hover-icon:hover,
    .hover-danger:hover {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: var(--uya-gold) !important;
    }

    .navbar-brand { padding-left: 0 !important; }
    .navbar-toggler { padding-right: 0 !important; }

    .hamburger-line {
        display: block;
        width: 20px;
        height: 2px;
        background-color: #ffffff;
        border-radius: 2px;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
        transform-origin: center;
    }

    .hamburger-line:nth-child(2) { margin: 5px 0; }

    .hamburger-btn[aria-expanded="true"] .hamburger-line:nth-child(1) { transform: translateY(7px) rotate(45deg); }
    .hamburger-btn[aria-expanded="true"] .hamburger-line:nth-child(2) { opacity: 0; transform: scaleX(0); }
    .hamburger-btn[aria-expanded="true"] .hamburger-line:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

    body { padding-top: 85px; }

    .mobile-menu, .mobile-backdrop { display: none; }

    @media (max-width: 991.98px) {
        body { padding-top: 75px; }
        .navbar-brand { padding-left: 0 !important; }
        .navbar-toggler { padding-right: 0 !important; }
        .navbar-collapse { display: none !important; }

        .mobile-menu {
            display: block !important;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: 1050;
            pointer-events: none;
            overflow: hidden;
        }

        .mobile-menu-inner.glass-mobile-menu {
            position: absolute;
            top: 0; right: 0;
            width: min(320px, 85vw);
            height: 100%;
            background: rgba(34, 77, 91, 0.92) !important;
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border-left: 1px solid rgba(255, 255, 255, 0.25);
            transform: translateX(100%);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0 16px 24px;
        }

        .mobile-menu.is-open { pointer-events: auto; }
        .mobile-menu.is-open .mobile-menu-inner { transform: translateX(0); }

        .mobile-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 4px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            margin-bottom: 12px;
            position: sticky;
            top: 0;
            background: transparent;
            z-index: 1;
        }

        .mobile-menu-title { color: #ffffff; font-weight: 700; font-size: 1rem; letter-spacing: 0.5px; }

        .mobile-menu-close {
            width: 36px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            border: none; border-radius: 8px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem; cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }
        .mobile-menu-close:hover { background-color: rgba(255, 255, 255, 0.2); color: #ffffff; transform: rotate(90deg); }

        .mobile-nav-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px; }
        .mobile-nav-list li {
            opacity: 0; transform: translateX(20px);
            transition: opacity 0.3s ease, transform 0.3s ease, background-color 0.15s ease;
            transition-delay: calc(var(--i) * 40ms + 0.1s);
        }
        .mobile-menu.is-open .mobile-nav-list li { opacity: 1; transform: translateX(0); }

        .mobile-nav-link {
            display: flex; align-items: center; gap: 14px;
            padding: 13px 16px; border-radius: 12px;
            color: rgba(255, 255, 255, 0.85); text-decoration: none;
            font-size: 0.95rem; font-weight: 500;
            transition: background-color 0.15s ease, color 0.15s ease;
        }
        .mobile-nav-link:hover { background-color: rgba(255, 255, 255, 0.15); color: #ffffff; }
        .mobile-nav-link.active { background-color: var(--uya-gold); color: var(--uya-dark-teal) !important; }
        .mobile-nav-link i { font-size: 1.1rem; width: 20px; text-align: center; flex-shrink: 0; }

        .mobile-menu-divider { height: 1px; background: rgba(255, 255, 255, 0.15); margin: 16px 0; }
        .mobile-menu-actions { display: flex; flex-direction: column; gap: 4px; }

        .mobile-action-link {
            display: flex; align-items: center; gap: 14px;
            padding: 13px 16px; border-radius: 12px;
            color: rgba(255, 255, 255, 0.85); text-decoration: none;
            font-size: 0.95rem; font-weight: 500;
            transition: background-color 0.15s ease, color 0.15s ease;
        }
        .mobile-action-link:hover { background-color: rgba(255, 255, 255, 0.15); color: #ffffff; }
        .mobile-action-link.text-danger:hover { background-color: rgba(220, 53, 69, 0.2); color: #ff6b7a !important; }

        .mobile-action-icon { position: relative; width: 20px; text-align: center; font-size: 1.1rem; flex-shrink: 0; }

        .mobile-badge {
            position: absolute; top: -6px; right: -8px;
            background-color: var(--uya-gold); color: var(--uya-dark-teal);
            font-size: 0.6rem; font-weight: 700;
            min-width: 16px; height: 16px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center; padding: 0 4px;
        }

        .mobile-backdrop {
            display: block !important; position: fixed; inset: 0;
            background-color: rgba(34, 77, 91, 0.5); backdrop-filter: blur(4px);
            z-index: 1049; opacity: 0; pointer-events: none; transition: opacity 0.3s ease;
        }
        .mobile-backdrop.is-open { opacity: 1; pointer-events: auto; }
    }
</style>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const backdrop = document.getElementById('mobileBackdrop');
        const btn = document.getElementById('hamburgerBtn');
        const isOpen = menu.classList.contains('is-open');

        if (isOpen) {
            closeMobileMenu();
        } else {
            menu.classList.add('is-open');
            backdrop.classList.add('is-open');
            btn.setAttribute('aria-expanded', 'true');
            menu.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const backdrop = document.getElementById('mobileBackdrop');
        const btn = document.getElementById('hamburgerBtn');

        menu.classList.remove('is-open');
        backdrop.classList.remove('is-open');
        btn.setAttribute('aria-expanded', 'false');
        menu.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeMobileMenu();
            document.getElementById('notifPopup').classList.add('d-none');
        }
    });

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

    // Reliable navigation handler for notification links
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
        const notifPopup = document.getElementById('notifPopup');

        if (notifPopup) {
            notifPopup.addEventListener('click', function (e) {
                const viewLink = e.target.closest('.navbar-notif-view-link');
                if (!viewLink) return;

                const targetUrl = viewLink.getAttribute('href');
                const readUrl = viewLink.getAttribute('data-read-url');

                if (targetUrl && targetUrl !== '#') {
                    e.preventDefault();

                    // Send mark-as-read in background
                    if (readUrl) {
                        fetch(readUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                            body: new URLSearchParams({ _token: csrfToken }),
                        }).catch(() => {});
                    }

                    // Navigate smoothly after 50ms
                    setTimeout(function () {
                        window.location.assign(targetUrl);
                    }, 50);
                }
            });
        }

        const toastEl = document.getElementById('globalToast');
        if (toastEl) {
            setTimeout(function () {
                const bsToast = bootstrap.Toast.getOrCreateInstance(toastEl);
                bsToast.hide();
            }, 3000);
        }
    });
</script>
