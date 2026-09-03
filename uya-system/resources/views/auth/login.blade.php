<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UYA Connect</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --uya-dark-teal: #224d5b;
            --uya-light-blue: #8CBCC4;
            --uya-gold: #D8B257;
            --uya-gold-hover: #c49d46;
        }

        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--uya-dark-teal);
            overflow: hidden;
        }

        .auth-container {
            height: 100vh;
            width: 100vw;
            display: flex;
        }

        .left-panel {
            background-color: var(--uya-dark-teal);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            z-index: 2;
            border-right: 2px solid rgba(255, 255, 255, 0.05);
        }

        .right-panel {
            background-color: #ffffff;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
        }

        .form-section {
            width: 100%;
            max-width: 520px;
            padding: 2rem;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -45%);
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-section.active {
            transform: translate(-50%, -50%);
            opacity: 1;
            visibility: visible;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 0.7rem 1rem;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            font-size: 0.9rem;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(140, 188, 196, 0.25);
            border-color: var(--uya-light-blue);
            background-color: #ffffff;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--uya-dark-teal);
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #adb5bd;
        }

        .btn-primary {
            border-radius: 8px;
            padding: 0.75rem;
            background-color: var(--uya-dark-teal);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #193843;
        }

        .text-brand {
            color: var(--uya-dark-teal);
        }

        .link-brand {
            color: var(--uya-dark-teal);
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .link-brand:hover {
            text-decoration: underline;
        }

        /* OTP Input boxes layout */
        .otp-inputs input {
            width: 45px;
            height: 45px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 8px;
            border: 1px solid #ced4da;
        }

        @media (max-width: 991px) {
            .auth-container {
                flex-direction: column;
            }

            .left-panel {
                min-height: 30vh;
                padding: 1.5rem;
            }

            .right-panel {
                height: 70vh;
            }
        }
    </style>
</head>

<body>

    <div class="auth-container">

        <!-- Left Branding Panel -->
        <div class="col-lg-5 left-panel">
            <div class="mb-3">
                <!-- Actual Client Logo Graphic Container -->
                <div
                    style="width: 120px; height: 120px; background-color: #83b6be; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; border: 3px solid var(--uya-gold); box-shadow: 0 4px 10px rgba(0,0,0,0.3); overflow: hidden;">
                    <!-- Replace 'logo.png' with your actual image filename stored in public/images/ -->
                    <img src="{{ asset('images/logo.jpg') }}" alt="UYA Logo"
                        style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
            <h2 class="fw-bold mb-1">UYA Connect</h2>
            <p class="text-white-50 small px-4">Sub Heading Here</p>
        </div>

        <!-- Right Forms Panel -->
        <div class="col-lg-7 right-panel">

            <!-- 1. LOGIN FORM -->
            <div class="form-section active" id="form-login">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-brand mb-1">Welcome Back</h3>
                    <p class="text-muted small">Sign in to your account</p>
                </div>
                <form>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="Enter email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="password-wrapper">
                            <input type="password" class="form-control" placeholder="Enter your password" required>
                            <i class="fa-regular fa-eye password-toggle"></i>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-4">
                        <span class="small link-brand" onclick="switchForm('form-forgot-step1')">Forgot password?</span>
                    </div>
                    <button type="button" class="btn btn-primary w-100 mb-3 shadow-sm">Login</button>
                    <div class="text-center small">
                        <span class="text-muted">Don't have an account?</span>
                        <span class="link-brand ms-1" onclick="switchForm('form-register')">Register</span>
                    </div>
                </form>
            </div>

            <!-- 2. REGISTER FORM -->
            <div class="form-section" id="form-register">
                <div class="text-center mb-3">
                    <h3 class="fw-bold text-brand mb-1">Create Account</h3>
                    <p class="text-muted small">Join UYA Connect today</p>
                </div>
                <form>
                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" placeholder="Enter your full name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Age</label>
                            <input type="number" class="form-control" placeholder="Enter age">
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" placeholder="Enter email address">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select class="form-select">
                                <option selected>Prefer not to say</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" class="form-control" placeholder="Enter contact number">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <div class="password-wrapper">
                                <input type="password" class="form-control" placeholder="Enter Address">
                                <i class="fa-regular fa-eye password-toggle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="Min 8 characters">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Conffirm Password</label>
                        <input type="text" class="form-control" placeholder="Re-enter Password">
                    </div>
                    <button type="button" class="btn btn-primary w-100 mb-2 shadow-sm"
                        onclick="switchForm('form-register-otp')">Register</button>
                    <div class="text-center small">
                        <span class="text-muted">Already have an account?</span>
                        <span class="link-brand ms-1" onclick="switchForm('form-login')">Login</span>
                    </div>
                </form>
            </div>

            <!-- 3. REGISTER OTP VERIFICATION FLOW -->
            <div class="form-section" id="form-register-otp">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-brand mb-1">Verify Your Email</h3>
                    <p class="text-muted small">We've sent a 6-digit verification code to your email</p>
                </div>
                <div class="otp-inputs d-flex justify-content-center gap-2 mb-4">
                    <input type="text" maxlength="1" class="form-control">
                    <input type="text" maxlength="1" class="form-control">
                    <input type="text" maxlength="1" class="form-control">
                    <input type="text" maxlength="1" class="form-control">
                    <input type="text" maxlength="1" class="form-control">
                    <input type="text" maxlength="1" class="form-control">
                </div>
                <button type="button" class="btn btn-primary w-100 mb-3 shadow-sm"
                    onclick="switchForm('form-login')">Verify Email</button>
                <div class="text-center small">
                    <span class="link-brand" onclick="switchForm('form-register')"><i
                            class="fa-solid fa-arrow-left me-1"></i> Back to registration</span>
                </div>
            </div>

            <!-- 4. FORGOT PASSWORD - STEP 1: EMAIL -->
            <div class="form-section" id="form-forgot-step1">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-brand mb-1">Forgot Password</h3>
                    <p class="text-muted small">Enter the email linked to your account to receive an OTP</p>
                </div>
                <form>
                    <div class="mb-4">
                        <label class="form-label">Registered Email</label>
                        <input type="email" class="form-control" placeholder="Enter your registered email">
                    </div>
                    <button type="button" class="btn btn-primary w-100 mb-3 shadow-sm"
                        onclick="switchForm('form-forgot-otp')">Send OTP</button>
                    <div class="text-center small">
                        <span class="link-brand" onclick="switchForm('form-login')"><i
                                class="fa-solid fa-arrow-left me-1"></i> Back to login</span>
                    </div>
                </form>
            </div>

            <!-- 5. FORGOT PASSWORD - STEP 2: OTP CODE -->
            <div class="form-section" id="form-forgot-otp">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-brand mb-1">Enter Verification Code</h3>
                    <p class="text-muted small">Enter the 6-digit code sent to your email</p>
                </div>
                <div class="otp-inputs d-flex justify-content-center gap-2 mb-4">
                    <input type="text" maxlength="1" class="form-control">
                    <input type="text" maxlength="1" class="form-control">
                    <input type="text" maxlength="1" class="form-control">
                    <input type="text" maxlength="1" class="form-control">
                    <input type="text" maxlength="1" class="form-control">
                    <input type="text" maxlength="1" class="form-control">
                </div>
                <button type="button" class="btn btn-primary w-100 mb-3 shadow-sm"
                    onclick="switchForm('form-forgot-new')">Verify OTP</button>
                <div class="text-center small">
                    <span class="link-brand" onclick="switchForm('form-forgot-step1')"><i
                            class="fa-solid fa-arrow-left me-1"></i> Back to email step</span>
                </div>
            </div>

            <!-- 6. FORGOT PASSWORD - STEP 3: NEW PASSWORD -->
            <div class="form-section" id="form-forgot-new">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-brand mb-1">Create New Password</h3>
                    <p class="text-muted small">Set and confirm your new password</p>
                </div>
                <form>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <div class="password-wrapper">
                            <input type="password" class="form-control" placeholder="Enter new password">
                            <i class="fa-regular fa-eye password-toggle"></i>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Confirm Password</label>
                        <div class="password-wrapper">
                            <input type="password" class="form-control" placeholder="Re-enter new password">
                            <i class="fa-regular fa-eye password-toggle"></i>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary w-100 mb-3 shadow-sm"
                        onclick="switchForm('form-login')">Update Password</button>
                    <div class="text-center small">
                        <span class="link-brand" onclick="switchForm('form-forgot-otp')"><i
                                class="fa-solid fa-arrow-left me-1"></i> Back to OTP step</span>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Interactive Transition and Navigation Logic -->
    <script>
        function switchForm(targetId) {
            document.querySelectorAll('.form-section').forEach(form => {
                form.classList.remove('active');
            });
            document.getElementById(targetId).classList.add('active');
        }

        // Function to simulate successful authentication and route directly to dashboard
        function redirectToDashboard(event) {
            event.preventDefault(); // Prevents actual page reload for mock testing

            // In actual Laravel implementation, this would submit via POST to backend.
            // For our UI mock environment, we redirect straight to the dashboard view.
            window.location.href = "{{ route('dashboard') }}";
        }

        // Attach listener triggers to login and registration completion buttons
        document.addEventListener("DOMContentLoaded", function() {
            // Target Login submit button
            const loginBtn = document.querySelector("#form-login button[type='button']");
            if (loginBtn) {
                loginBtn.addEventListener('click', redirectToDashboard);
            }

            // Target Final Register verification submit button
            const verifyRegisterBtn = document.querySelector("#form-register-otp button[type='button']");
            if (verifyRegisterBtn) {
                verifyRegisterBtn.addEventListener('click', redirectToDashboard);
            }
        });
    </script>
</body>

</html>
