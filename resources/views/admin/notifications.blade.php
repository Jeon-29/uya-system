@extends('layouts.admin')

@section('title', 'Notifications - UYA Connect')

@push('styles')
<style>
    .notifications-container {
        max-width: 850px;
    }

    .notification-card {
        background-color: var(--admin-card-bg);
        border: 1px solid var(--admin-border);
        border-radius: 16px;
        transition: all 0.2s ease;
    }
    .notification-card:hover {
        border-color: rgba(99, 102, 241, 0.4);
    }

    .notif-icon-box {
        width: 44px;
        height: 44px;
        background-color: rgba(99, 102, 241, 0.15);
        color: #818cf8;
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .notif-dismiss-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: var(--admin-text-muted);
        transition: all 0.15s ease;
    }
    .notif-dismiss-btn:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }

    .notif-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #818cf8;
        font-weight: 600;
        text-decoration: none;
        font-size: 0.82rem;
        transition: color 0.15s ease;
    }
    .notif-action-btn:hover {
        color: #a5b4fc;
    }
    .notif-action-btn:hover .fa-arrow-right {
        transform: translateX(2px);
    }
    .notif-action-btn .fa-arrow-right {
        transition: transform 0.15s ease;
    }
</style>
@endpush

@section('content')
    <div class="container notifications-container p-0">
        <!-- Header Section -->
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1 text-white">Notifications</h4>
                <p class="text-subtle small mb-0">System alerts, proposal updates, and activity notifications.</p>
            </div>
            @if($notifications->total() > 0)
                <div id="markAllBtnWrap">
                    <form method="POST" action="{{ route('admin.notifications.read-all') }}" id="markAllForm">
                        @csrf
                        <button type="submit" class="btn btn-outline-light rounded-pill btn-sm px-3 py-2 fw-semibold" style="font-size: 0.8rem;">
                            <i class="fa-solid fa-check me-1"></i> Mark all as read
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Notification List Feed -->
        <div class="d-flex flex-column gap-3" id="notificationList">
            @forelse($notifications as $notif)
                @php
                    $data = $notif->data ?? [];
                    $icon = $data['icon'] ?? 'fa-regular fa-bell';
                    $title = $data['title'] ?? 'System Notification';
                    $message = $data['message'] ?? '';
                    $actionUrl = $data['action_url'] ?? '#';
                    $actionText = $data['action_text'] ?? 'View Details';
                @endphp
                <div class="notification-card p-3 p-md-4 border-start border-4 border-primary" data-notif-card>
                    <div class="d-flex align-items-start gap-3">
                        <div class="notif-icon-box">
                            <i class="{{ $icon }}"></i>
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <!-- Title & Dismiss Row -->
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="fw-bold mb-0 text-white" style="font-size: 0.95rem;">{{ $title }}</h6>
                                <form method="POST" action="{{ route('admin.notifications.read', $notif->id) }}" class="notif-read-form">
                                    @csrf
                                    <button type="submit" class="btn btn-link shadow-none p-0 notif-dismiss-btn" title="Mark as read">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="text-subtle mb-2" style="font-size: 0.75rem;">
                                <i class="fa-regular fa-clock me-1 opacity-75"></i>{{ $notif->created_at->diffForHumans() }}
                            </div>

                            <p class="text-subtle mb-3" style="font-size: 0.88rem; line-height: 1.5;">
                                {{ $message }}
                            </p>

                            <a href="{{ $actionUrl }}" class="notif-action-btn">
                                {{ $actionText }} <i class="fa-solid fa-arrow-right fa-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="notification-card p-5 text-center text-muted">
                    <i class="fa-regular fa-bell-slash fa-3x mb-3 opacity-50"></i>
                    <h5 class="fw-semibold text-white">No notifications found</h5>
                    <p class="small mb-0">You're all caught up!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
        const list = document.getElementById('notificationList');

        function showEmptyState() {
            document.getElementById('markAllBtnWrap')?.remove();
            list.innerHTML = `
                <div class="notification-card p-5 text-center text-muted">
                    <i class="fa-regular fa-bell-slash fa-3x mb-3 opacity-50"></i>
                    <h5 class="fw-semibold text-white">No notifications found</h5>
                    <p class="small mb-0">You're all caught up!</p>
                </div>`;
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
                if (!list.querySelector('[data-notif-card]')) {
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
                },
                body: new URLSearchParams({ _token: csrfToken }),
            });
        }

        // Individual mark-as-read
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

        // Mark all as read
        const markAllForm = document.getElementById('markAllForm');
        if (markAllForm) {
            markAllForm.addEventListener('submit', function (e) {
                e.preventDefault();
                sendMarkRead(markAllForm.getAttribute('action')).then(function (res) {
                    if (res.ok) {
                        list.querySelectorAll('[data-notif-card]').forEach(removeCard);
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
@endpush
