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

        .container-fluid {
            width: 100% !important;
            padding-left: 2rem !important;
            padding-right: 2rem !important;
        }

        .pastel-card {
            background-color: #ffffff;
            border: 1px solid #dce5e8 !important;
            border-radius: 16px;
            box-shadow: 0 0.25rem 0.75rem rgba(34, 77, 91, 0.03);
        }

        .info-box {
            background-color: #f3f7f9;
            border: 1px solid #dce5e8;
            border-radius: 12px;
            padding: 1rem 1.25rem;
        }

        .stat-card {
            background-color: #ffffff;
            border: 1px solid #dce5e8 !important;
            border-radius: 16px;
            padding: 1.25rem;
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
            display: inline-block;
            text-align: center;
        }
        .custom-btn-outline:hover {
            background-color: var(--uya-dark-teal);
            color: #fff;
        }

        .custom-btn-filled {
            background-color: var(--uya-dark-teal);
            color: #fff;
            border: none;
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
    </style>
</head>
<body>

    <!-- Include Navbar Component -->
    @include('layouts.navbar')

    <div class="container-fluid py-4" style="max-width: 1200px;">

        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h2 class="fw-bold mb-1 text-brand">Profile</h2>
                <p class="text-muted small mb-0">Manage your personal information and account settings.</p>
            </div>
            <button onclick="openEditProfileModal()" class="btn rounded-pill px-4 py-2 fw-semibold custom-btn-filled d-flex align-items-center gap-2 shadow-sm" style="font-size: 0.85rem;">
                <i class="fa-regular fa-pen-to-square"></i> Edit Personal Info
            </button>
        </div>

        <!-- Personal Information Section Card -->
        <div class="card p-4 pastel-card mb-4">
            <h5 class="fw-bold text-brand mb-3" style="font-size: 1rem;">Personal Information</h5>

            <div class="row align-items-center g-4">
                <!-- Avatar & Status Column -->
                <div class="col-lg-3 text-center text-lg-start border-end-lg">
                    <div class="d-flex flex-column align-items-center align-items-lg-start gap-2">
                        <div class="avatar-circle shadow-sm">
                            M
                            <div class="avatar-camera-badge shadow-sm">
                                <i class="fa-solid fa-camera"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Momo</h5>
                            <span class="badge rounded-pill bg-success bg-opacity-15 text-success px-2.5 py-1 fw-semibold mb-2" style="font-size: 0.65rem;">MEMBER</span>
                            <div class="d-flex align-items-center gap-1.5 text-muted small" style="font-size: 0.75rem;">
                                <span class="rounded-circle bg-success d-inline-block" style="width: 8px; height: 8px;"></i></span> Active
                            </div>
                        </div>
                        <button onclick="openChangePasswordModal()" class="btn btn-sm rounded-pill px-3 py-1.5 fw-semibold custom-btn-outline d-flex align-items-center gap-1.5 mt-1" style="font-size: 0.75rem;">
                            <i class="fa-solid fa-lock"></i> Change Password
                        </button>
                    </div>
                </div>

                <!-- Fields Grid Column -->
                <div class="col-lg-9">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="text-muted d-block mb-1" style="font-size: 0.7rem; font-weight: 600; letter-spacing: 0.5px;">NAME</span>
                                <div class="fw-semibold text-dark" id="profile-name" style="font-size: 0.9rem;">Momo</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="text-muted d-block mb-1" style="font-size: 0.7rem; font-weight: 600; letter-spacing: 0.5px;">AGE</span>
                                <div class="fw-semibold text-dark" id="profile-age" style="font-size: 0.9rem;">21</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="text-muted d-block mb-1" style="font-size: 0.7rem; font-weight: 600; letter-spacing: 0.5px;">EMAIL ADDRESS</span>
                                <div class="fw-semibold text-dark" id="profile-email" style="font-size: 0.9rem;">momo@gmail.com</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="text-muted d-block mb-1" style="font-size: 0.7rem; font-weight: 600; letter-spacing: 0.5px;">GENDER</span>
                                <div class="fw-semibold text-dark" id="profile-gender" style="font-size: 0.9rem;">Female</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="text-muted d-block mb-1" style="font-size: 0.7rem; font-weight: 600; letter-spacing: 0.5px;">CONTACT NUMBER</span>
                                <div class="fw-semibold text-dark" id="profile-contact" style="font-size: 0.9rem;">0917 333 3333</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="text-muted d-block mb-1" style="font-size: 0.7rem; font-weight: 600; letter-spacing: 0.5px;">ADDRESS</span>
                                <div class="fw-semibold text-dark" id="profile-address" style="font-size: 0.9rem;">General Mariano Alvarez, Cavite</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Stats Cards -->
        <h5 class="fw-bold text-brand mb-3" style="font-size: 1rem;">My Attendance</h5>
        <div class="row g-3 mb-4">
            <div class="col-xl col-md-4 col-sm-6">
                <div class="stat-card">
                    <span class="text-muted d-block mb-1" style="font-size: 0.7rem; font-weight: 600;">TOTAL RECORDS</span>
                    <h3 class="fw-bold mb-1 text-brand">4</h3>
                    <span class="text-muted" style="font-size: 0.75rem;">All entries</span>
                </div>
            </div>
            <div class="col-xl col-md-4 col-sm-6">
                <div class="stat-card">
                    <span class="text-muted d-block mb-1" style="font-size: 0.7rem; font-weight: 600;">PRESENT</span>
                    <h3 class="fw-bold mb-1 text-success">2</h3>
                    <span class="text-muted" style="font-size: 0.75rem;">On-time &amp; late</span>
                </div>
            </div>
            <div class="col-xl col-md-4 col-sm-6">
                <div class="stat-card">
                    <span class="text-muted d-block mb-1" style="font-size: 0.7rem; font-weight: 600;">LATE</span>
                    <h3 class="fw-bold mb-1 text-warning">1</h3>
                    <span class="text-muted" style="font-size: 0.75rem;">Present but late</span>
                </div>
            </div>
            <div class="col-xl col-md-4 col-sm-6">
                <div class="stat-card">
                    <span class="text-muted d-block mb-1" style="font-size: 0.7rem; font-weight: 600;">ABSENT</span>
                    <h3 class="fw-bold mb-1 text-danger">2</h3>
                    <span class="text-muted" style="font-size: 0.75rem;">No valid QR scan</span>
                </div>
            </div>
            <div class="col-xl col-md-8 col-sm-12">
                <div class="stat-card">
                    <span class="text-muted d-block mb-1" style="font-size: 0.7rem; font-weight: 600;">ATTENDANCE RATE</span>
                    <h3 class="fw-bold mb-1 text-brand">50%</h3>
                    <span class="text-muted" style="font-size: 0.75rem;">Success rate</span>
                </div>
            </div>
        </div>

        <!-- Attendance Records Table Card -->
        <div class="card p-4 pastel-card">
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
                        <tr>
                            <td class="fw-semibold text-dark">Annual Sports Festival</td>
                            <td class="text-muted">7/11/2026</td>
                            <td><span class="badge rounded-pill text-success px-2.5 py-1 fw-semibold" style="background-color: rgba(25, 135, 84, 0.12); font-size: 0.7rem;">PRESENT</span></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-dark">Cultural Night</td>
                            <td class="text-muted">7/14/2026</td>
                            <td><span class="badge rounded-pill text-warning px-2.5 py-1 fw-semibold" style="background-color: rgba(255, 193, 7, 0.15); color: #856404 !important; font-size: 0.7rem;">PRESENT BUT LATE</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Edit Personal Info Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 550px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">Edit Personal Information</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="editProfileForm" onsubmit="saveProfile(event)">
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Name</label>
                            <input type="text" class="form-control rounded-pill py-2 shadow-none border" id="input-name" value="Momo" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Age</label>
                            <input type="number" class="form-control rounded-pill py-2 shadow-none border" id="input-age" value="21" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Email Address</label>
                            <input type="email" class="form-control rounded-pill py-2 shadow-none border" id="input-email" value="momo@gmail.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Gender</label>
                            <select class="form-select rounded-pill py-2 shadow-none border" id="input-gender">
                                <option value="Female" selected>Female</option>
                                <option value="Male">Male</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Contact Number</label>
                            <input type="text" class="form-control rounded-pill py-2 shadow-none border" id="input-contact" value="0917 333 3333" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Address</label>
                            <input type="text" class="form-control rounded-pill py-2 shadow-none border" id="input-address" value="General Mariano Alvarez, Cavite" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light border rounded-pill py-2 w-50 fw-semibold text-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill py-2 w-50 fw-semibold text-white shadow-sm" style="background-color: var(--uya-dark-teal);">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content rounded-4 shadow-lg border-0 p-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;">Change Password</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="changePasswordForm" onsubmit="savePassword(event)">
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Current Password</label>
                        <input type="password" class="form-control rounded-pill py-2 shadow-none border" placeholder="Enter current password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">New Password</label>
                        <input type="password" class="form-control rounded-pill py-2 shadow-none border" placeholder="Enter new password" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold" style="font-size: 0.85rem;">Confirm New Password</label>
                        <input type="password" class="form-control rounded-pill py-2 shadow-none border" placeholder="Confirm new password" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light border rounded-pill py-2 w-50 fw-semibold text-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn rounded-pill py-2 w-50 fw-semibold text-white shadow-sm" style="background-color: var(--uya-dark-teal);">Update Password</button>
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

        function saveProfile(event) {
            event.preventDefault();

            // Grab values from inputs and update profile card view dynamically
            document.getElementById('profile-name').innerText = document.getElementById('input-name').value;
            document.getElementById('profile-age').innerText = document.getElementById('input-age').value;
            document.getElementById('profile-email').innerText = document.getElementById('input-email').value;
            document.getElementById('profile-gender').innerText = document.getElementById('input-gender').value;
            document.getElementById('profile-contact').innerText = document.getElementById('input-contact').value;
            document.getElementById('profile-address').innerText = document.getElementById('input-address').value;

            // Close modal
            const modalEl = document.getElementById('editProfileModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();

            alert('Personal information updated successfully!');
        }

        function savePassword(event) {
            event.preventDefault();

            // Close modal & reset form
            const modalEl = document.getElementById('changePasswordModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
            document.getElementById('changePasswordForm').reset();

            alert('Password changed successfully!');
        }
    </script>
</body>
</html>
