<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - UYA Connect</title>

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

        .profile-container {
            width: 100%;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
            margin: 0 auto;
        }
        @media (min-width: 768px) {
            .profile-container {
                padding-left: 2.5rem;
                padding-right: 2.5rem;
            }
        }

        .pastel-card {
            background-color: #ffffff;
            border: 1px solid #dce5e8 !important;
            border-radius: 16px;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.03);
        }

        /* Slimmer Information Fields for Mobile */
        .info-box {
            background-color: #f3f7f9;
            border: 1px solid #dce5e8;
            border-radius: 10px;
            padding: 0.55rem 1rem; /* Reduced top/bottom padding to decrease height */
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 54px;
        }

        .info-box-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #6c757d;
            margin-bottom: 2px;
            line-height: 1;
        }

        .info-box-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: #212529;
            line-height: 1.2;
            word-break: break-word;
        }

        .stat-card {
            background-color: #ffffff;
            border: 1px solid #dce5e8 !important;
            border-radius: 14px;
            padding: 1rem 1.15rem;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.03);
            height: 100%;
        }

        .avatar-circle {
            width: 80px;
            height: 80px;
            background-color: var(--uya-dark-teal);
            color: white;
            font-size: 2rem;
            font-weight: bold;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .avatar-camera-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            background: white;
            color: var(--uya-dark-teal);
            border: 1px solid #dce5e8;
            border-radius: 50%;
            width: 26px;
            height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
        }

        .custom-btn-outline {
            border-color: var(--uya-dark-teal);
            color: var(--uya-dark-teal);
            background-color: #ffffff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .custom-btn-outline:hover {
            background-color: var(--uya-dark-teal);
            color: #fff;
        }

        .custom-btn-filled {
            background-color: var(--uya-dark-teal);
            color: #fff;
            border: none;
            transition: all 0.2s ease;
        }
        .custom-btn-filled:hover {
            background-color: #193a44;
            color: #fff;
        }

        .table-custom th {
            background-color: #f3f7f9;
            color: var(--uya-dark-teal);
            font-weight: 600;
            font-size: 0.8rem;
            border-bottom: 1px solid #dce5e8;
            padding: 0.75rem 1rem;
        }
        .table-custom td {
            font-size: 0.85rem;
            padding: 0.85rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f3f7f9;
        }

        @media (max-width: 991.98px) {
            .border-end-lg {
                border-right: none !important;
                border-bottom: 1px solid #dce5e8;
                padding-bottom: 1.25rem;
                margin-bottom: 0.5rem;
            }
        }
        @media (min-width: 992px) {
            .border-end-lg {
                border-right: 1px solid #dce5e8 !important;
            }
        }
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    @php
        $userInitial = strtoupper(substr($user->name ?? 'U', 0, 1));
        $userRole = strtoupper($user->role ?? 'MEMBER');
    @endphp

    <div class="profile-container py-3 py-md-4">

        <!-- Header Section -->
        <div class="mb-3 mb-md-4 text-center text-sm-start">
            <h2 class="fw-bold mb-1 text-brand" style="font-size: 1.6rem;">Profile</h2>
            <p class="text-muted small mb-0">Manage your personal information and account settings.</p>
        </div>

        <!-- Personal Information Section Card -->
        <div class="card p-3 p-md-4 pastel-card mb-4">

            <!-- Card Header with Edit Button -->
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                <h5 class="fw-bold text-brand mb-0" style="font-size: 1rem;">Personal Information</h5>
                <button onclick="openEditProfileModal()" class="btn btn-sm rounded-pill px-3 py-1.5 fw-semibold custom-btn-filled d-inline-flex align-items-center gap-1.5 shadow-sm" style="font-size: 0.75rem;">
                    <i class="fa-regular fa-pen-to-square"></i> <span class="d-none d-sm-inline">Edit Info</span><span class="d-sm-none">Edit</span>
                </button>
            </div>

            <div class="row align-items-center g-3 g-lg-4">
                <!-- Avatar Column -->
                <div class="col-lg-3 text-center text-lg-start border-end-lg">
                    <div class="d-flex flex-column align-items-center align-items-lg-start gap-2">
                        <div class="avatar-circle shadow-sm">
                            {{ $userInitial }}
                            <div class="avatar-camera-badge shadow-sm">
                                <i class="fa-solid fa-camera"></i>
                            </div>
                        </div>
                        <div class="text-center text-lg-start">
                            <h5 class="fw-bold text-dark mb-1">{{ $user->name ?? 'User' }}</h5>
                            <span class="badge rounded-pill bg-success bg-opacity-15 text-success px-2.5 py-1 fw-semibold mb-2" style="font-size: 0.65rem;">
                                {{ $userRole }}
                            </span>
                            <div class="d-flex align-items-center justify-content-center justify-content-lg-start gap-1.5 text-muted small" style="font-size: 0.75rem;">
                                <span class="rounded-circle bg-success d-inline-block" style="width: 8px; height: 8px;"></span> Active
                            </div>
                        </div>
                        <button onclick="openChangePasswordModal()" class="btn btn-sm rounded-pill px-3 py-1.5 fw-semibold custom-btn-outline gap-1.5 mt-1" style="font-size: 0.75rem;">
                            <i class="fa-solid fa-lock"></i> Change Password
                        </button>
                    </div>
                </div>

                <!-- Fields Grid Column -->
                <div class="col-lg-9">
                    <div class="row g-2 g-md-3">
                        <div class="col-12 col-md-6">
                            <div class="info-box">
                                <span class="info-box-label">NAME</span>
                                <div class="info-box-value">{{ $user->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="info-box">
                                <span class="info-box-label">AGE</span>
                                <div class="info-box-value">{{ $user->age ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="info-box">
                                <span class="info-box-label">EMAIL ADDRESS</span>
                                <div class="info-box-value">{{ $user->email ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="info-box">
                                <span class="info-box-label">GENDER</span>
                                <div class="info-box-value">{{ ucfirst($user->gender ?? 'N/A') }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="info-box">
                                <span class="info-box-label">CONTACT NUMBER</span>
                                <div class="info-box-value">{{ $user->contact_number ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="info-box">
                                <span class="info-box-label">ADDRESS</span>
                                <div class="info-box-value">{{ $user->address ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Stats Cards -->
        <h5 class="fw-bold text-brand mb-3" style="font-size: 1rem;">My Attendance</h5>
        <div class="row g-2 g-md-3 mb-4">
            <div class="col-6 col-md-4 col-xl">
                <div class="stat-card">
                    <span class="text-muted d-block mb-1" style="font-size: 0.65rem; font-weight: 700;">TOTAL RECORDS</span>
                    <h3 class="fw-bold mb-1 text-brand" style="font-size: 1.4rem;">{{ $attendanceStats['total'] ?? 0 }}</h3>
                    <span class="text-muted" style="font-size: 0.7rem;">All entries</span>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl">
                <div class="stat-card">
                    <span class="text-muted d-block mb-1" style="font-size: 0.65rem; font-weight: 700;">PRESENT</span>
                    <h3 class="fw-bold mb-1 text-success" style="font-size: 1.4rem;">{{ $attendanceStats['present'] ?? 0 }}</h3>
                    <span class="text-muted" style="font-size: 0.7rem;">On-time &amp; late</span>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl">
                <div class="stat-card">
                    <span class="text-muted d-block mb-1" style="font-size: 0.65rem; font-weight: 700;">LATE</span>
                    <h3 class="fw-bold mb-1 text-warning" style="font-size: 1.4rem;">{{ $attendanceStats['late'] ?? 0 }}</h3>
                    <span class="text-muted" style="font-size: 0.7rem;">Present but late</span>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl">
                <div class="stat-card">
                    <span class="text-muted d-block mb-1" style="font-size: 0.65rem; font-weight: 700;">ABSENT</span>
                    <h3 class="fw-bold mb-1 text-danger" style="font-size: 1.4rem;">{{ $attendanceStats['absent'] ?? 0 }}</h3>
                    <span class="text-muted" style="font-size: 0.7rem;">No valid QR scan</span>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl">
                <div class="stat-card">
                    <span class="text-muted d-block mb-1" style="font-size: 0.65rem; font-weight: 700;">ATTENDANCE RATE</span>
                    <h3 class="fw-bold mb-1 text-brand" style="font-size: 1.4rem;">{{ $attendanceStats['rate'] ?? '0%' }}</h3>
                    <span class="text-muted" style="font-size: 0.7rem;">Success rate</span>
                </div>
            </div>
        </div>

        <!-- Attendance Records Table Card -->
        <div class="card p-3 p-md-4 pastel-card">
            <h5 class="fw-bold text-brand mb-3" style="font-size: 1rem;">Attendance Records</h5>
            <div class="table-responsive rounded-3 border">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>ACTIVITY</th>
                            <th>DATE</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendanceRecords ?? [] as $activity)
                            @php
                                $attended = $activity->pivot->attended ?? false;
                            @endphp
                            <tr>
                                <td class="fw-semibold text-dark">{{ $activity->title }}</td>
                                <td class="text-muted">{{ $activity->pivot->created_at ? \Carbon\Carbon::parse($activity->pivot->created_at)->format('n/j/Y') : 'N/A' }}</td>
                                <td>
                                    @if($attended)
                                        <span class="badge rounded-pill text-success px-2.5 py-1 fw-semibold" style="background-color: rgba(25, 135, 84, 0.12); font-size: 0.7rem;">PRESENT</span>
                                    @else
                                        <span class="badge rounded-pill text-danger px-2.5 py-1 fw-semibold" style="background-color: rgba(220, 53, 69, 0.12); font-size: 0.7rem;">ABSENT</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4 small">No attendance records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Edit Personal Info Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 550px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.1rem;">Edit Personal Information</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-2.5 g-md-3 mb-3">
                        <div class="col-8 col-md-8">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Name *</label>
                            <input type="text" class="form-control rounded-pill py-2 shadow-none border @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required style="font-size: 0.85rem;">
                            @error('name')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-4 col-md-4">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Age *</label>
                            <input type="number" class="form-control rounded-pill py-2 shadow-none border @error('age') is-invalid @enderror" name="age" value="{{ old('age', $user->age) }}" required style="font-size: 0.85rem;">
                            @error('age')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Email Address *</label>
                            <input type="email" class="form-control rounded-pill py-2 shadow-none border @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required style="font-size: 0.85rem;">
                            @error('email')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Gender *</label>
                            @php $currentGender = strtolower($user->gender ?? 'female'); @endphp
                            <select class="form-select rounded-pill py-2 shadow-none border @error('gender') is-invalid @enderror" name="gender" style="font-size: 0.85rem;">
                                <option value="Female" {{ $currentGender === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="Male" {{ $currentGender === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="Other" {{ $currentGender === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Contact Number *</label>
                            <input type="text" class="form-control rounded-pill py-2 shadow-none border @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number', $user->contact_number) }}" required style="font-size: 0.85rem;">
                            @error('contact_number')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Address *</label>
                            <input type="text" class="form-control rounded-pill py-2 shadow-none border @error('address') is-invalid @enderror" name="address" value="{{ old('address', $user->address) }}" required style="font-size: 0.85rem;">
                            @error('address')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light border rounded-pill py-2 w-50 fw-semibold text-secondary" style="font-size: 0.85rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill py-2 w-50 fw-semibold text-white shadow-sm" style="background-color: var(--uya-dark-teal); font-size: 0.85rem;">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.1rem;">Change Password</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="changePasswordForm" method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Current Password *</label>
                        <input type="password" class="form-control rounded-pill py-2 shadow-none border @error('current_password') is-invalid @enderror" name="current_password" placeholder="Enter current password" required style="font-size: 0.85rem;">
                        @error('current_password')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">New Password *</label>
                        <input type="password" class="form-control rounded-pill py-2 shadow-none border @error('password') is-invalid @enderror" name="password" placeholder="Enter new password" required style="font-size: 0.85rem;">
                        @error('password')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold mb-1" style="font-size: 0.8rem;">Confirm New Password *</label>
                        <input type="password" class="form-control rounded-pill py-2 shadow-none border" name="password_confirmation" placeholder="Confirm new password" required style="font-size: 0.85rem;">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light border rounded-pill py-2 w-50 fw-semibold text-secondary" style="font-size: 0.85rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill py-2 w-50 fw-semibold text-white shadow-sm" style="background-color: var(--uya-dark-teal); font-size: 0.85rem;">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openEditProfileModal() {
            const modal = new bootstrap.Modal(document.getElementById('editProfileModal'));
            modal.show();
        }

        function openChangePasswordModal() {
            const modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
            modal.show();
        }

        // Re-open modals automatically if backend validation fails
        @if ($errors->has('name') || $errors->has('age') || $errors->has('email') || $errors->has('gender') || $errors->has('contact_number') || $errors->has('address'))
            document.addEventListener('DOMContentLoaded', function () {
                openEditProfileModal();
            });
        @endif

        @if ($errors->has('current_password') || $errors->has('password'))
            document.addEventListener('DOMContentLoaded', function () {
                openChangePasswordModal();
            });
        @endif
    </script>
</body>
</html>
