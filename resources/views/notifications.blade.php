<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notifications - UYA</title>

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

        .notifications-container {
            max-width: 800px;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        @media (min-width: 576px) {
            .notifications-container {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }

        .notif-header-actions {
            width: 100%;
        }
        @media (min-width: 576px) {
            .notif-header-actions {
                width: auto;
            }
        }

        .btn-mark-read {
            width: 100%;
            white-space: nowrap;
        }
        @media (min-width: 576px) {
            .btn-mark-read {
                width: auto;
            }
        }

        /* Apple Liquid Glass Notification Card */
        .notification-card {
            background: rgba(255, 255, 255, 0.46);
            -webkit-backdrop-filter: blur(22px) saturate(180%);
            backdrop-filter: blur(22px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.85) !important;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(34, 77, 91, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.9);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .notification-card:hover {
            border-color: var(--uya-light-blue) !important;
            box-shadow: 0 14px 35px rgba(34, 77, 91, 0.12), inset 0 1px 0 rgba(255, 255, 255, 1);
            transform: translateY(-1px);
        }

        .notif-icon-box {
            width: 40px;
            height: 40px;
            background-color: rgba(131, 182, 190, 0.2);
            color: var(--uya-dark-teal);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        @media (min-width: 576px) {
            .notif-icon-box {
                width: 44px;
                height: 44px;
            }
        }

        .notif-dismiss-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .notif-dismiss-btn:hover {
            background-color: rgba(34, 77, 91, 0.08);
        }

        .notif-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: transparent;
            border: none;
            padding: 0;
            color: var(--uya-dark-teal);
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }
        .notif-action-btn:hover {
            color: #193a44;
        }
        .notif-action-btn:hover .fa-arrow-right {
            transform: translateX(2px);
        }
        .notif-action-btn .fa-arrow-right {
            transition: transform 0.15s ease;
        }
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <div class="container notifications-container py-3 py-md-4">

        <!-- Header Section -->
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-brand" style="font-size: 1.4rem;">Notifications</h2>
                <p class="text-muted small mb-0">Stay updated with activity posts, announcements, and updates.</p>
            </div>
            @if(isset($notifications) && $notifications->total() > 0)
                <div class="notif-header-actions" id="markAllBtnWrap">
                    <form method="POST" action="{{ route('notifications.read-all') }}" id="markAllForm">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary rounded-pill btn-sm px-3 py-2 fw-semibold btn-mark-read shadow-sm">
                            <i class="fa-solid fa-check me-1"></i> Mark all as read
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Notification List -->
        <div class="d-flex flex-column gap-3" id="notificationList">
            @forelse($notifications as $notif)
                @php
                    $data = $notif->data ?? [];
                    $title =$data['title'] ?? 'System Notification';
                    $message =$data['message'] ?? '';
                    $icon =$data['icon'] ?? 'fa-regular fa-bell';

                    // Support both 'action_url' and 'url'
                    $rawUrl = $data['action_url'] ?? $data['url'] ?? '#';

                    // Dynamic fallback route resolver if rawUrl is '#' or empty
                    if ($rawUrl === '#' || empty($rawUrl)) {
                        if (isset($data['activity_id'])) {
                            $rawUrl = Route::has('activities.show') ? route('activities.show', $data['activity_id']) : route('activities');
                        } elseif (isset($data['proposal_id'])) {
                            $rawUrl = Route::has('proposals.show') ? route('proposals.show', $data['proposal_id']) : route('proposals');
                        } elseif (str_contains(strtolower($title), 'completed') || str_contains(strtolower($title), 'certificate') || str_contains(strtolower($message), 'certificate')) {$rawUrl = route('certificates');
                        } elseif (str_contains(strtolower($title), 'activity') || str_contains(strtolower($title), 'registration')) {$rawUrl = route('activities');
                        } elseif (str_contains(strtolower($title), 'announcement')) {$rawUrl = route('announcements');
                        } else {
                            $rawUrl = Route::has('notifications') ? route('notifications') : '#';
                        }
                    }

                    $actionUrl =$rawUrl;
                    $actionText =$data['action_text'] ?? 'View Details';
                @endphp
                <div class="card p-3 notification-card border-start border-4 border-warning" data-notif-card>
                    <div class="d-flex align-items-start gap-2 gap-sm-3">
                        <div class="notif-icon-box">
                            <i class="{{ $icon }}"></i>
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <!-- Title row -->
                            <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.92rem;">{{ $title }}</h6>
                            </div>

                            <!-- Meta row -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-clock me-1"></i>{{ $notif->created_at->diffForHumans() }}
                                </span>
                                <form method="POST" action="{{ route('notifications.read', $notif->id) }}" class="notif-read-form">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-muted p-0 shadow-none notif-dismiss-btn" title="Mark as read">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </form>
                            </div>

                            <p class="text-secondary mb-3" style="font-size: 0.88rem; line-height: 1.4;">
                                {{ $message }}
                            </p>

                            <!-- Guaranteed Functional View Link -->
                            <a href="{{ $actionUrl }}"
                               onclick="handleNotificationClick(event, '{{ route('notifications.read', $notif->id) }}', '{{ $actionUrl }}')"
                               class="notif-action-btn" style="font-size: 0.82rem;">
                                {{ $actionText }} <i class="fa-solid fa-arrow-right fa-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card p-5 notification-card text-center text-muted">
                    <i class="fa-regular fa-bell-slash fa-3x mb-3 text-secondary"></i>
                    <h5 class="fw-semibold">No notifications found</h5>
                    <p class="small mb-0">You're all caught up!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(isset($notifications) && $notifications->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $notifications->links() }}
            </div>
        @endif

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function handleNotificationClick(event, readUrl, targetUrl) {
            if (!targetUrl || targetUrl === '#') return;
            event.preventDefault();

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

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

            setTimeout(function () {
                window.location.assign(targetUrl);
            }, 50);
        }

        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const list = document.getElementById('notificationList');

            function showEmptyState() {
                document.getElementById('markAllBtnWrap')?.remove();
                if (list) {
                    list.innerHTML = `
                        <div class="card p-5 notification-card text-center text-muted">
                            <i class="fa-regular fa-bell-slash fa-3x mb-3 text-secondary"></i>
                            <h5 class="fw-semibold">No notifications found</h5>
                            <p class="small mb-0">You're all caught up!</p>
                        </div>`;
                }
            }

            function removeCard(card) {
                if (!card) return;
                card.style.overflow = 'hidden';
                card.style.maxHeight = card.scrollHeight + 'px';
                card.style.transition = 'opacity 0.2s ease, transform 0.2s ease, max-height 0.25s ease, margin 0.25s ease';
                requestAnimationFrame(function () {
                    card.style.opacity = '0';
                    card.style.transform = 'translateX(12px)';
                    card.style.maxHeight = '0px';
                    card.style.marginBottom = '0px';
                });
                setTimeout(function () {
                    card.remove();
                    if (list && !list.querySelector('[data-notif-card]')) {
                        showEmptyState();
                    }
                }, 260);
            }

            function sendMarkRead(url) {
                return fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: new URLSearchParams({ _token: csrfToken }),
                });
            }

            if (list) {
                // Individual "x" mark-as-read
                list.addEventListener('submit', function (e) {
                    const form = e.target.closest('.notif-read-form');
                    if (!form) return;
                    e.preventDefault();
                    const card = form.closest('[data-notif-card]');
                    sendMarkRead(form.getAttribute('action')).then(function (res) {
                        if (res.ok) {
                            removeCard(card);
                        } else {
                            form.submit();
                        }
                    }).catch(function () {
                        form.submit();
                    });
                });
            }

            // "Mark all as read"
            const markAllForm = document.getElementById('markAllForm');
            if (markAllForm) {
                markAllForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    sendMarkRead(markAllForm.getAttribute('action')).then(function (res) {
                        if (res.ok) {
                            if (list) {
                                list.querySelectorAll('[data-notif-card]').forEach(removeCard);
                            }
                        } else {
                            markAllForm.submit();
                        }
                    }).catch(function () {
                        markAllForm.submit();
                    });
                });
            }
        });
    </script>
</body>
</html>
