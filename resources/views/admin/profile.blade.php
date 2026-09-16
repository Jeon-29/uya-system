@extends('layouts.admin')

@section('title', 'Admin Profile - UYA Connect')

@push('styles')
<style>
    .admin-card {
        background-color: var(--admin-card-bg);
        border: 1px solid var(--admin-border);
        border-radius: 16px;
        padding: 24px;
    }

    .profile-avatar-box {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: var(--admin-accent-purple);
        color: #ffffff;
        font-size: 2.2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
    }

    .form-label {
        font-size: 0.82rem;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 6px;
    }

    .admin-input {
        background-color: var(--admin-input-bg);
        border: 1px solid var(--admin-border);
        color: #ffffff;
        border-radius: 10px;
        font-size: 0.88rem;
        padding: 10px 14px;
    }

    .admin-input:focus {
        background-color: var(--admin-input-bg);
        color: #ffffff;
        border-color: var(--admin-accent-purple);
        box-shadow: none;
    }

    .admin-input[readonly], .admin-input[disabled] {
        background-color: rgba(255, 255, 255, 0.03);
        border-color: rgba(255, 255, 255, 0.05);
        color: var(--admin-text-muted);
    }

    .btn-purple {
        background-color: var(--admin-accent-purple);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 10px 22px;
        transition: background-color 0.2s ease;
    }

    .btn-purple:hover {
        background-color: var(--admin-accent-purple-hover);
        color: #ffffff;
    }

    .badge-role-admin {
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #ffffff;
        background: transparent;
        font-weight: 500;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.72rem;
    }

    /* Minimal Log Row Styling */
    .log-row {
        background-color: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        padding: 10px 14px;
        transition: background-color 0.15s ease;
    }
    .log-row:hover {
        background-color: rgba(255, 255, 255, 0.04);
    }
    .log-icon-box {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background-color: rgba(99, 102, 241, 0.15);
        color: #818cf8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')
    @php
        $user = auth()->user();
        $userName = $user->name ?? 'User';
        $userEmail = $user->email ?? 'N/A';
        $userRole = ucfirst($user->role ?? 'Officer');
    @endphp

    <!-- Profile Header Banner -->
    <div class="admin-card mb-4">
        <div class="d-flex align-items-center gap-4 flex-wrap">
            <div class="profile-avatar-box">
                {{ strtoupper(substr($userName, 0, 1)) }}
            </div>
            <div>
                <h4 class="fw-bold text-white mb-1">{{ $userName }}</h4>
                <p class="text-subtle mb-2 small">{{ $userEmail }}</p>
                <span class="badge badge-role-admin">{{ $userRole }}</span>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Account Details Form -->
        <div class="col-12 col-lg-6">
            <div class="admin-card h-100">
                <h5 class="fw-bold text-white mb-1" style="font-size: 1.05rem;">Account Information</h5>
                <p class="text-subtle small mb-4">Update your account detail profile preferences.</p>

                <form method="POST" action="{{ route('admin.profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control admin-input" value="{{ old('name', $userName) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control admin-input" value="{{ old('email', $userEmail) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control admin-input" value="{{ $userRole }}" readonly disabled>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-purple">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security / Password Update Form -->
        <div class="col-12 col-lg-6">
            <div class="admin-card h-100">
                <h5 class="fw-bold text-white mb-1" style="font-size: 1.05rem;">Security Settings</h5>
                <p class="text-subtle small mb-4">Ensure your account is using a long, secure password.</p>

                <form method="POST" action="{{ route('admin.password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control admin-input" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control admin-input" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control admin-input" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-purple">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Minimal Admin Activity Log Section -->
    <div class="admin-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold text-white mb-1" style="font-size: 1.05rem;">
                    <i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Recent Activity Log
                </h5>
                <p class="text-subtle small mb-0">Audit trail of actions performed by your admin account.</p>
            </div>
        </div>

        <div class="d-flex flex-column gap-2">
            @forelse($activityLogs as $log)
                <div class="log-row d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2.5 overflow-hidden">
                        <div class="log-icon-box">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <div class="text-truncate">
                            <span class="fw-semibold text-white me-2" style="font-size: 0.85rem;">{{ $log->action }}</span>
                            @if($log->description)
                                <span class="text-subtle small text-truncate d-none d-md-inline">• {{ $log->description }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 ms-auto text-muted" style="font-size: 0.75rem;">
                        <span><i class="fa-regular fa-clock me-1 opacity-75"></i>{{ $log->created_at->diffForHumans() }}</span>
                        @if($log->ip_address)
                            <span class="opacity-50">|</span>
                            <span><i class="fa-solid fa-network-wired me-1 opacity-75"></i>{{ $log->ip_address }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-4 small">
                    <i class="fa-solid fa-file-shield fa-2x mb-2 d-block opacity-50"></i>
                    No activity logs recorded yet. Action history will appear here.
                </div>
            @endforelse
        </div>
    </div>
@endsection