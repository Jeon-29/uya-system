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
            min-height: 100vh;
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

        /* Primary Outer Liquid Glass Panels */
        .pastel-card,
        .stat-card {
            background: rgba(255, 255, 255, 0.22) !important;
            border-radius: 20px !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08) !important;
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            border: 1px solid rgba(255, 255, 255, 0.45) !important;
            transition: all 0.25s ease;
        }

        /* Inner Liquid Glass Info Box */
        .info-box {
            background: rgba(255, 255, 255, 0.45) !important;
            backdrop-filter: blur(6px) !important;
            -webkit-backdrop-filter: blur(6px) !important;
            border: 1px solid rgba(255, 255, 255, 0.75) !important;
            border-radius: 12px;
            padding: 0.55rem 1rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 54px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .info-box-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #475569;
            margin-bottom: 2px;
            line-height: 1;
        }

        .info-box-value {
            font-size: 0.9rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
            word-break: break-word;
        }

        .stat-card {
            border-radius: 14px !important;
            padding: 1rem 1.15rem;
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
            box-shadow: 0 4px 12px rgba(34, 77, 91, 0.2);
            cursor: pointer;
            overflow: visible;
        }

        .avatar-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .avatar-camera-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(4px);
            color: var(--uya-dark-teal);
            border: 1px solid rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            transition: all 0.2s ease;
        }

        .avatar-circle:hover .avatar-camera-badge {
            background: var(--uya-dark-teal);
            color: white;
        }

        /* Refined Custom Buttons */
        .custom-btn-outline {
            border: 2px solid var(--uya-dark-teal);
            color: var(--uya-dark-teal);
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .custom-btn-outline:hover {
            background-color: var(--uya-dark-teal);
            color: #fff;
            box-shadow: 0 4px 12px rgba(34, 77, 91, 0.2);
        }

        .custom-btn-filled {
            background-color: var(--uya-dark-teal);
            color: #fff;
            border: none;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(34, 77, 91, 0.2);
            transition: all 0.2s ease;
        }
        .custom-btn-filled:hover {
            background-color: #193a44;
            color: #fff;
        }

        /* Glass Table Styling */
        .table-custom-container {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.75);
            border-radius: 12px;
            overflow: hidden;
        }

        .table-custom th {
            background: rgba(243, 247, 249, 0.8);
            color: var(--uya-dark-teal);
            font-weight: 700;
            font-size: 0.8rem;
            border-bottom: 1px solid rgba(220, 229, 232, 0.8);
            padding: 0.75rem 1rem;
        }
        .table-custom td {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.85rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(243, 247, 249, 0.8);
        }

        /* Glass Modal Styles */
        .glass-modal-content {
            background: rgba(255, 255, 255, 0.88) !important;
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 20px 50px rgba(34, 77, 91, 0.2), inset 0 1px 0 rgba(255, 255, 255, 1) !important;
        }

        /* MOBILE PROFILE HERO STYLES (< 768px) */
        @media (max-width: 767.98px) {
            .mobile-profile-hero {
                text-align: center;
                padding: 1.75rem 1.25rem !important;
            }
            .mobile-avatar-circle {
                width: 80px;
                height: 80px;
                font-size: 2rem;
                margin: 0 auto 1.25rem auto !important;
                border: 3px solid #ffffff;
                box-shadow: 0 4px 12px rgba(34, 77, 91, 0.12);
            }
            .mobile-hero-title {
                margin-bottom: 1rem !important;
            }
            .mobile-badges-row {
                margin-bottom: 1.5rem !important;
            }
            .mobile-buttons-row {
                gap: 0.85rem !important;
                margin-top: 0.5rem;
            }
            .mobile-hero-btn {
                font-size: 0.78rem !important;
                padding: 0.5rem 0.85rem !important;
            }
            .stat-card-mobile {
                padding: 0.65rem 0.5rem !important;
                text-align: center;
            }
            .stat-card-mobile h3 {
                font-size: 1.15rem !important;
            }
            .stat-card-mobile span {
                font-size: 0.62rem !important;
            }
        }

        @media (max-width: 991.98px) {
            .border-end-lg {
                border-right: none !important;
                border-bottom: 1px solid rgba(220, 229, 232, 0.8);
                padding-bottom: 1.25rem;
                margin-bottom: 0.5rem;
            }
        }
        @media (min-width: 992px) {
            .border-end-lg {
                border-right: 1px solid rgba(220, 229, 232, 0.8) !important;
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
        $hasPhoto = !empty($user->profile_photo_path);
    @endphp

    <div class="profile-container py-3 py-md-4">

        <!-- MOBILE HERO CARD WITH FULL DISTINCT SPACING (< 768px) -->
        <div class="card pastel-card mb-3 d-md-none mobile-profile-hero">
            <!-- 1. Avatar (Clickable to change photo) -->
            <div class="avatar-circle mobile-avatar-circle" onclick="openPhotoModal()" title="Change Profile Photo">
                @if($hasPhoto)
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}">
                @else
                    {{ $userInitial }}
                @endif
                <div class="avatar-camera-badge shadow-sm">
                    <i class="fa-solid fa-camera"></i>
                </div>
            </div>

            <!-- 2. User Name -->
            <h5 class="fw-bold text-dark fs-5 mobile-hero-title" style="letter-spacing: -0.2px;">{{ $user->name ?? 'User' }}</h5>

            <!-- 3. Badges Row -->
            <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap mobile-badges-row">
                <span class="badge rounded-pill text-success border border-success border-opacity-25 px-2.5 py-1.5 fw-bold" style="background-color: rgba(232, 248, 240, 0.85); font-size: 0.68rem;">
                    <i class="fa-solid fa-circle-check me-1.5"></i> {{ $userRole }}
                </span>
                <span class="badge rounded-pill text-dark border px-2.5 py-1.5 fw-semibold" style="background-color: rgba(248, 250, 252, 0.85); font-size: 0.68rem;">
                    <i class="fa-solid fa-location-dot me-1.5 text-danger"></i> {{ $user->address ?? 'Silang, Cavite' }}
                </span>
            </div>

            <!-- 4. Action Buttons -->
            <div class="d-flex justify-content-center mobile-buttons-row">
                <button onclick="openEditProfileModal()" class="btn btn-sm rounded-pill mobile-hero-btn flex-fill fw-semibold custom-btn-filled gap-2 shadow-sm" style="max-width: 140px;">
                    <i class="fa-regular fa-pen-to-square me-1"></i> Edit Profile
                </button>
                <button onclick="openChangePasswordModal()" class="btn btn-sm rounded-pill mobile-hero-btn flex-fill fw-semibold custom-btn-outline gap-2" style="max-width: 140px;">
                    <i class="fa-solid fa-lock me-1"></i> Password
                </button>
            </div>
        </div>

        <!-- Personal Information Section Card (Desktop & Details Grid) -->
        <div class="card p-3 p-md-4 pastel-card mb-4 shadow-sm">

            <!-- Card Header with Edit Button -->
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3 border-secondary border-opacity-10">
                <h5 class="fw-bold text-brand mb-0" style="font-size: 1rem;">Personal Information</h5>
                <button onclick="openEditProfileModal()" class="btn btn-sm rounded-pill px-3 py-1.5 fw-semibold custom-btn-filled d-none d-md-inline-flex align-items-center gap-2 shadow-sm" style="font-size: 0.75rem;">
                    <i class="fa-regular fa-pen-to-square me-1"></i> Edit Info
                </button>
            </div>

            <div class="row align-items-center g-3 g-lg-4">
                <!-- Avatar Column (Desktop View) -->
                <div class="col-lg-3 text-center text-lg-start border-end-lg d-none d-md-block">
                    <div class="d-flex flex-column align-items-center align-items-lg-start gap-2">
                        <!-- Avatar (Clickable to change photo) -->
                        <div class="avatar-circle shadow-sm" onclick="openPhotoModal()" title="Change Profile Photo">
                            @if($hasPhoto)
                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}">
                            @else
                                {{ $userInitial }}
                            @endif
                            <div class="avatar-camera-badge shadow-sm">
                                <i class="fa-solid fa-camera"></i>
                            </div>
                        </div>

                        <div class="text-center text-lg-start">
                            <h5 class="fw-bold text-dark mb-1">{{ $user->name ?? 'User' }}</h5>
                            <span class="badge rounded-pill text-success border border-success border-opacity-25 px-2.5 py-1 fw-bold mb-2" style="background-color: rgba(232, 248, 240, 0.85); font-size: 0.65rem;">
                                {{ $userRole }}
                            </span>
                            <div class="d-flex align-items-center justify-content-center justify-content-lg-start gap-2 text-secondary fw-semibold small" style="font-size: 0.75rem;">
                                <span class="rounded-circle bg-success d-inline-block me-1" style="width: 8px; height: 8px;"></span> Active
                            </div>
                        </div>

                        <button onclick="openChangePasswordModal()" class="btn btn-sm rounded-pill px-3 py-1.5 fw-semibold custom-btn-outline gap-2 mt-1" style="font-size: 0.75rem;">
                            <i class="fa-solid fa-lock me-1"></i> Change Password
                        </button>
                    </div>
                </div>

                <!-- Fields Grid Column -->
                <div class="col-12 col-lg-9">
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
        <h5 class="fw-bold text-brand mb-3" style="font-size: 1rem;">My Attendance Overview</h5>
        <div class="row g-2 g-md-3 mb-4">
            <div class="col-6 col-md-4 col-xl">
                <div class="stat-card stat-card-mobile shadow-sm">
                    <span class="text-secondary fw-bold d-block mb-1" style="font-size: 0.65rem;">TOTAL RECORDS</span>
                    <h3 class="fw-bold mb-1 text-brand" style="font-size: 1.4rem;">{{ $attendanceStats['total'] ?? 0 }}</h3>
                    <span class="text-secondary fw-semibold" style="font-size: 0.7rem;">All entries</span>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl">
                <div class="stat-card stat-card-mobile shadow-sm">
                    <span class="text-secondary fw-bold d-block mb-1" style="font-size: 0.65rem;">PRESENT</span>
                    <h3 class="fw-bold mb-1 text-success" style="font-size: 1.4rem;">{{ $attendanceStats['present'] ?? 0 }}</h3>
                    <span class="text-secondary fw-semibold" style="font-size: 0.7rem;">Attended</span>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl">
                <div class="stat-card stat-card-mobile shadow-sm">
                    <span class="text-secondary fw-bold d-block mb-1" style="font-size: 0.65rem;">LATE</span>
                    <h3 class="fw-bold mb-1 text-warning" style="font-size: 1.4rem;">{{ $attendanceStats['late'] ?? 0 }}</h3>
                    <span class="text-secondary fw-semibold" style="font-size: 0.7rem;">Late check-ins</span>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl">
                <div class="stat-card stat-card-mobile shadow-sm">
                    <span class="text-secondary fw-bold d-block mb-1" style="font-size: 0.65rem;">ABSENT</span>
                    <h3 class="fw-bold mb-1 text-danger" style="font-size: 1.4rem;">{{ $attendanceStats['absent'] ?? 0 }}</h3>
                    <span class="text-secondary fw-semibold" style="font-size: 0.7rem;">Registered only</span>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl">
                <div class="stat-card stat-card-mobile shadow-sm">
                    <span class="text-secondary fw-bold d-block mb-1" style="font-size: 0.65rem;">ATTENDANCE RATE</span>
                    <h3 class="fw-bold mb-1 text-brand" style="font-size: 1.4rem;">{{ $attendanceStats['rate'] ?? '0%' }}</h3>
                    <span class="text-secondary fw-semibold" style="font-size: 0.7rem;">Success rate</span>
                </div>
            </div>
        </div>

        <!-- Attendance Records Table Card -->
        <div class="card p-3 p-md-4 pastel-card shadow-sm">
            <h5 class="fw-bold text-brand mb-3" style="font-size: 1rem;">Attendance Records</h5>
            <div class="table-responsive table-custom-container">
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
                                $status = $activity->pivot->status ?? 'registered';
                            @endphp
                            <tr>
                                <td class="fw-semibold text-dark">{{ $activity->title }}</td>
                                <td class="text-secondary fw-semibold">{{ $activity->pivot->created_at ? \Carbon\Carbon::parse($activity->pivot->created_at)->format('n/j/Y') : 'N/A' }}</td>
                                <td>
                                    @if($status === 'attended')
                                        <span class="badge rounded-pill text-white px-2.5 py-1 fw-bold" style="background-color: #15803d; font-size: 0.7rem;">PRESENT</span>
                                    @elseif($status === 'late')
                                        <span class="badge rounded-pill text-dark px-2.5 py-1 fw-bold" style="background-color: #eab308; font-size: 0.7rem;">LATE</span>
                                    @else
                                        <span class="badge rounded-pill text-white px-2.5 py-1 fw-bold" style="background-color: #dc2626; font-size: 0.7rem;">ABSENT</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-dark fw-medium py-4 small">No attendance records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- UPLOAD PROFILE PHOTO MODAL -->
    <div class="modal fade" id="uploadPhotoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content rounded-4 border-0 p-3 p-md-4 glass-modal-content">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 border-secondary border-opacity-10">
                    <h5 class="fw-bold text-brand mb-0" style="font-size: 1.1rem;">Update Profile Picture</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="uploadPhotoForm" method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="text-center mb-3">
                        <div id="photoPreviewContainer" class="avatar-circle mx-auto mb-2" style="width: 100px; height: 100px; font-size: 2.5rem; cursor: default;">
                            @if($hasPhoto)
                                <img id="photoPreview" src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}">
                            @else
                                <span id="photoInitial">{{ $userInitial }}</span>
                                <img id="photoPreview" src="" alt="Preview" style="display: none;">
                            @endif
                        </div>
                        <small class="text-secondary fw-semibold d-block" style="font-size: 0.75rem;">Supported formats: JPG, PNG, WEBP (Max: 2MB)</small>
                    </div>

                    <div class="mb-3">
                        <input type="file" name="profile_photo" id="profilePhotoInput" class="form-control rounded-pill py-2 px-3 shadow-none border bg-light @error('profile_photo') is-invalid @enderror" accept="image/*" required onchange="previewSelectedPhoto(this)">
                        @error('profile_photo')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary rounded-pill py-2 w-50 fw-bold" style="font-size: 0.85rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill py-2 w-50 fw-bold text-white shadow-sm custom-btn-filled" style="font-size: 0.85rem;">Upload Photo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Personal Info Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 550px;">
            <div class="modal-content rounded-4 border-0 p-3 p-md-4 glass-modal-content">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 border-secondary border-opacity-10">
                    <h5 class="fw-bold text-brand mb-0" style="font-size: 1.1rem;">Edit Personal Information</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-2.5 g-md-3 mb-3">
                        <div class="col-8 col-md-8">
                            <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Name *</label>
                            <input type="text" class="form-control rounded-pill py-2 px-3 shadow-none border bg-light @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required style="font-size: 0.85rem;">
                            @error('name')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-4 col-md-4">
                            <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Age *</label>
                            <input type="number" class="form-control rounded-pill py-2 px-3 shadow-none border bg-light @error('age') is-invalid @enderror" name="age" value="{{ old('age', $user->age) }}" required style="font-size: 0.85rem;">
                            @error('age')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Email Address *</label>
                            <input type="email" class="form-control rounded-pill py-2 px-3 shadow-none border bg-light @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required style="font-size: 0.85rem;">
                            @error('email')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Gender *</label>
                            @php $currentGender = strtolower($user->gender ?? 'female'); @endphp
                            <select class="form-select rounded-pill py-2 px-3 shadow-none border bg-light @error('gender') is-invalid @enderror" name="gender" style="font-size: 0.85rem;">
                                <option value="Female" {{ $currentGender === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="Male" {{ $currentGender === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="Other" {{ $currentGender === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Contact Number *</label>
                            <input type="text" class="form-control rounded-pill py-2 px-3 shadow-none border bg-light @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number', $user->contact_number) }}" required style="font-size: 0.85rem;">
                            @error('contact_number')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Address *</label>
                            <input type="text" class="form-control rounded-pill py-2 px-3 shadow-none border bg-light @error('address') is-invalid @enderror" name="address" value="{{ old('address', $user->address) }}" required style="font-size: 0.85rem;">
                            @error('address')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary rounded-pill py-2 w-50 fw-bold" style="font-size: 0.85rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill py-2 w-50 fw-bold text-white shadow-sm custom-btn-filled" style="font-size: 0.85rem;">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content rounded-4 border-0 p-3 p-md-4 glass-modal-content">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 border-secondary border-opacity-10">
                    <h5 class="fw-bold text-brand mb-0" style="font-size: 1.1rem;">Change Password</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="changePasswordForm" method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Current Password *</label>
                        <input type="password" class="form-control rounded-pill py-2 px-3 shadow-none border bg-light @error('current_password') is-invalid @enderror" name="current_password" placeholder="Enter current password" required style="font-size: 0.85rem;">
                        @error('current_password')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">New Password *</label>
                        <input type="password" class="form-control rounded-pill py-2 px-3 shadow-none border bg-light @error('password') is-invalid @enderror" name="password" placeholder="Enter new password" required style="font-size: 0.85rem;">
                        @error('password')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-dark fw-bold mb-1" style="font-size: 0.8rem;">Confirm New Password *</label>
                        <input type="password" class="form-control rounded-pill py-2 px-3 shadow-none border bg-light" name="password_confirmation" placeholder="Confirm new password" required style="font-size: 0.85rem;">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary rounded-pill py-2 w-50 fw-bold" style="font-size: 0.85rem;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill py-2 w-50 fw-bold text-white shadow-sm custom-btn-filled" style="font-size: 0.85rem;">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openPhotoModal() {
            const modal = new bootstrap.Modal(document.getElementById('uploadPhotoModal'));
            modal.show();
        }

        function openEditProfileModal() {
            const modal = new bootstrap.Modal(document.getElementById('editProfileModal'));
            modal.show();
        }

        function openChangePasswordModal() {
            const modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
            modal.show();
        }

        function previewSelectedPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('photoPreview');
                    const initial = document.getElementById('photoInitial');
                    img.src = e.target.result;
                    img.style.display = 'block';
                    if (initial) initial.style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Re-open modals automatically if backend validation fails
        @if ($errors->has('profile_photo'))
            document.addEventListener('DOMContentLoaded', function () {
                openPhotoModal();
            });
        @endif

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
