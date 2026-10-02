@php
    $activeForm = $activeForm ?? 'form-login';
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UYA Connect</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

        .btn-primary:disabled {
            opacity: 0.65;
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

        .invalid-feedback {
            display: block;
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
                height: auto;
                min-height: 100vh;
            }

            body,
            html {
                overflow-y: auto;
                overflow-x: hidden;
            }

            .left-panel {
                min-height: 25vh;
                padding: 1.5rem;
            }

            .right-panel {
                height: auto;
                min-height: 75vh;
                display: block;
                overflow: visible;
                padding: 1.5rem 0;
            }

            /* On mobile the two-pane absolute-centering trick clips tall
               forms (like Register) above the visible area with no way to
               scroll back up to them. Switch to normal document flow. */
            .form-section {
                position: static;
                top: auto;
                left: auto;
                max-width: 100%;
                padding: 0 1.25rem;
                transform: none;
                transition: none;
                display: none;
                opacity: 1;
                visibility: visible;
            }

            .form-section.active {
                display: block;
                transform: none;
            }

            .otp-inputs {
                flex-wrap: wrap;
            }

            .otp-inputs input {
                width: 42px;
                height: 42px;
                font-size: 1.1rem;
            }
        }

        @media (max-width: 360px) {
            .otp-inputs input {
                width: 36px;
                height: 36px;
            }
        }
    </style>
</head>

<body>

    <div class="auth-container">

        <!-- Left Branding Panel -->
        <div class="col-lg-5 left-panel">
            <div class="mb-3">
                <div
                    style="width: 120px; height: 120px; background-color: #83b6be; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; border: 3px solid var(--uya-gold); box-shadow: 0 4px 10px rgba(0,0,0,0.3); overflow: hidden;">
                    <img src="{{ asset('images/logo.jpg') }}" alt="UYA Logo"
                        style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
            <h2 class="fw-bold mb-1">UYA Connect</h2>
            <p class="text-white-50 small px-4">Sub Heading Here</p>
        </div>

        <!-- Right Forms Panel -->
        <div class="col-lg-7 right-panel">

            @if (session('status'))
                <div class="alert alert-success position-absolute top-0 start-50 translate-middle-x mt-3 shadow-sm"
                    style="z-index: 10; max-width: 90%;">
                    {{ session('status') }}
                </div>
            @endif

            <!-- 1. LOGIN FORM -->
            <div class="form-section {{ $activeForm === 'form-login' ? 'active' : '' }}" id="form-login">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-brand mb-1">Welcome Back</h3>
                    <p class="text-muted small">Sign in to your account</p>
                </div>

                @if (session('lockout_remaining'))
                    <div class="alert alert-warning small text-center mb-3">
                        <i class="fa-solid fa-lock me-1"></i>
                        Account temporarily locked. Please wait <strong id="lockoutCountdown">{{ session('lockout_remaining') }}</strong> minute(s).
                    </div>
                @endif

                <form method="POST" action="{{ route('login.attempt') }}" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email', 'login') is-invalid @enderror"
                            placeholder="Enter email" required>
                        @error('email', 'login')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password"
                                class="form-control @error('password', 'login') is-invalid @enderror"
                                placeholder="Enter your password" required>
                            <i class="fa-regular fa-eye password-toggle"></i>
                        </div>
                        @error('password', 'login')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end mb-4">
                        <span class="small link-brand" onclick="switchForm('form-forgot-step1')">Forgot password?</span>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3 shadow-sm">Login</button>
                    <div class="text-center small">
                        <span class="text-muted">Don't have an account?</span>
                        <span class="link-brand ms-1" onclick="switchForm('form-register')">Register</span>
                    </div>
                </form>
            </div>

            <!-- 2. REGISTER FORM -->
            <div class="form-section {{ $activeForm === 'form-register' ? 'active' : '' }}" id="form-register">
                <div class="text-center mb-3">
                    <h3 class="fw-bold text-brand mb-1">Create Account</h3>
                    <p class="text-muted small">Join UYA Connect today</p>
                </div>
                <form method="POST" action="{{ url('register') }}" novalidate>
                    @csrf
                    <div class="row g-2 mb-2">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('name', 'register') is-invalid @enderror"
                                placeholder="Enter your full name">
                            @error('name', 'register')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Age</label>
                            <input type="number" name="age" value="{{ old('age') }}" min="1" max="120"
                                class="form-control @error('age', 'register') is-invalid @enderror" placeholder="Enter age">
                            @error('age', 'register')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email', 'register') is-invalid @enderror"
                                placeholder="Enter email address" id="register-email">
                            <span id="register-email-status" class="small mt-1 d-block"></span>
                            @error('email', 'register')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select @error('gender', 'register') is-invalid @enderror">
                                <option value="Prefer not to say" @selected(old('gender', 'Prefer not to say') === 'Prefer not to say')>Prefer not to say</option>
                                <option value="Male" @selected(old('gender') === 'Male')>Male</option>
                                <option value="Female" @selected(old('gender') === 'Female')>Female</option>
                            </select>
                            @error('gender', 'register')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" value="{{ old('contact_number') }}"
                                class="form-control @error('contact_number', 'register') is-invalid @enderror"
                                placeholder="Enter contact number">
                            @error('contact_number', 'register')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" value="{{ old('address') }}"
                                class="form-control @error('address', 'register') is-invalid @enderror"
                                placeholder="Enter Address">
                            @error('address', 'register')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password"
                                class="form-control @error('password', 'register') is-invalid @enderror"
                                placeholder="Min 8 characters" id="register-password">
                            <i class="fa-regular fa-eye password-toggle"></i>
                        </div>
                        <div id="register-strength-meter" class="mt-1 small"></div>
                        @error('password', 'register')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Re-enter Password">
                            <i class="fa-regular fa-eye password-toggle"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-2 shadow-sm">Register</button>
                    <div class="text-center small">
                        <span class="text-muted">Already have an account?</span>
                        <span class="link-brand ms-1" onclick="switchForm('form-login')">Login</span>
                    </div>
                </form>
            </div>

            <!-- 3. REGISTER OTP VERIFICATION FLOW -->
            <div class="form-section {{ $activeForm === 'form-register-otp' ? 'active' : '' }}" id="form-register-otp">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-brand mb-1">Verify Your Email</h3>
                    <p class="text-muted small">
                        We've sent a 6-digit verification code to
                        <strong>{{ $registerEmail ?? 'your email' }}</strong>
                    </p>
                </div>
                <form method="POST" action="{{ route('register.verify') }}" class="otp-form" novalidate>
                    @csrf
                    <input type="hidden" name="otp">
                    <div class="otp-inputs d-flex justify-content-center gap-2 mb-2">
                        <input type="text" inputmode="numeric" maxlength="1" class="form-control otp-digit">
                        <input type="text" inputmode="numeric" maxlength="1" class="form-control otp-digit">
                        <input type="text" inputmode="numeric" maxlength="1" class="form-control otp-digit">
                        <input type="text" inputmode="numeric" maxlength="1" class="form-control otp-digit">
                        <input type="text" inputmode="numeric" maxlength="1" class="form-control otp-digit">
                        <input type="text" inputmode="numeric" maxlength="1" class="form-control otp-digit">
                    </div>
                    @error('otp', 'registerOtp')
                        <div class="text-danger small text-center mb-2">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary w-100 mb-3 shadow-sm">Verify Email</button>
                </form>
                <form method="POST" action="{{ route('register.resend') }}" class="text-center small mb-2">
                    @csrf
                    <button type="submit" class="btn btn-link link-brand p-0">Resend code</button>
                </form>
                <div class="text-center small">
                    <span class="link-brand" onclick="switchForm('form-register')"><i
                            class="fa-solid fa-arrow-left me-1"></i> Back to registration</span>
                </div>
            </div>

            <!-- 4. FORGOT PASSWORD - STEP 1: EMAIL -->
            <div class="form-section {{ $activeForm === 'form-forgot-step1' ? 'active' : '' }}" id="form-forgot-step1">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-brand mb-1">Forgot Password</h3>
                    <p class="text-muted small">Enter the email linked to your account to receive an OTP</p>
                </div>
                <form method="POST" action="{{ route('password.email') }}" novalidate>
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Registered Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email', 'forgotEmail') is-invalid @enderror"
                            placeholder="Enter your registered email">
                        @error('email', 'forgotEmail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3 shadow-sm">Send OTP</button>
                    <div class="text-center small">
                        <span class="link-brand" onclick="switchForm('form-login')"><i
                                class="fa-solid fa-arrow-left me-1"></i> Back to login</span>
                    </div>
                </form>
            </div>

            <!-- 5. FORGOT PASSWORD - STEP 2: OTP CODE -->
            <div class="form-section {{ $activeForm === 'form-forgot-otp' ? 'active' : '' }}" id="form-forgot-otp">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-brand mb-1">Enter Verification Code</h3>
                    <p class="text-muted small">
                        Enter the 6-digit code sent to
                        <strong>{{ $resetEmail ?? 'your email' }}</strong>
                    </p>
                </div>
                <form method="POST" action="{{ route('password.verify') }}" class="otp-form" novalidate>
                    @csrf
                    <input type="hidden" name="otp">
                    <div class="otp-inputs d-flex justify-content-center gap-2 mb-2">
                        <input type="text" inputmode="numeric" maxlength="1" class="form-control otp-digit">
                        <input type="text" inputmode="numeric" maxlength="1" class="form-control otp-digit">
                        <input type="text" inputmode="numeric" maxlength="1" class="form-control otp-digit">
                        <input type="text" inputmode="numeric" maxlength="1" class="form-control otp-digit">
                        <input type="text" inputmode="numeric" maxlength="1" class="form-control otp-digit">
                        <input type="text" inputmode="numeric" maxlength="1" class="form-control otp-digit">
                    </div>
                    @error('otp', 'forgotOtp')
                        <div class="text-danger small text-center mb-2">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary w-100 mb-3 shadow-sm">Verify OTP</button>
                </form>
                <form method="POST" action="{{ route('password.resend') }}" class="text-center small mb-2">
                    @csrf
                    <button type="submit" class="btn btn-link link-brand p-0">Resend code</button>
                </form>
                <div class="text-center small">
                    <span class="link-brand" onclick="switchForm('form-forgot-step1')"><i
                            class="fa-solid fa-arrow-left me-1"></i> Back to email step</span>
                </div>
            </div>

            <!-- 6. FORGOT PASSWORD - STEP 3: NEW PASSWORD -->
            <div class="form-section {{ $activeForm === 'form-forgot-new' ? 'active' : '' }}" id="form-forgot-new">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-brand mb-1">Create New Password</h3>
                    <p class="text-muted small">Set and confirm your new password</p>
                </div>
                <form method="POST" action="{{ route('password.update') }}" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password"
                                class="form-control @error('password', 'forgotPassword') is-invalid @enderror"
                                placeholder="Enter new password" id="forgot-new-password">
                            <i class="fa-regular fa-eye password-toggle"></i>
                        </div>
                        <div id="forgot-new-strength-meter" class="mt-1 small"></div>
                        @error('password', 'forgotPassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Confirm Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Re-enter new password" id="forgot-confirm-password">
                            <i class="fa-regular fa-eye password-toggle"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3 shadow-sm">Update Password</button>
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

        document.addEventListener("DOMContentLoaded", function() {
            // Password show/hide toggles
            document.querySelectorAll('.password-toggle').forEach(icon => {
                icon.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    const showing = input.type === 'text';
                    input.type = showing ? 'password' : 'text';
                    this.classList.toggle('fa-eye', showing);
                    this.classList.toggle('fa-eye-slash', !showing);
                });
            });

            // OTP boxes: auto-advance, backspace support, and packing digits into hidden field
            document.querySelectorAll('.otp-form').forEach(form => {
                const digits = form.querySelectorAll('.otp-digit');
                const hidden = form.querySelector('input[name="otp"]');

                digits.forEach((digit, index) => {
                    digit.addEventListener('input', () => {
                        digit.value = digit.value.replace(/[^0-9]/g, '');
                        if (digit.value && index < digits.length - 1) {
                            digits[index + 1].focus();
                        }
                    });

                    digit.addEventListener('keydown', (e) => {
                        if (e.key === 'Backspace' && !digit.value && index > 0) {
                            digits[index - 1].focus();
                        }
                    });

                    digit.addEventListener('paste', (e) => {
                        const pasted = (e.clipboardData || window.clipboardData).getData('text').trim();
                        if (/^\d+$/.test(pasted)) {
                            e.preventDefault();
                            pasted.slice(0, digits.length).split('').forEach((char, i) => {
                                if (digits[i]) digits[i].value = char;
                            });
                            digits[Math.min(pasted.length, digits.length) - 1].focus();
                        }
                    });
                });

                form.addEventListener('submit', () => {
                    hidden.value = Array.from(digits).map(d => d.value).join('');
                });
            });

            // Register form password strength meter
            const registerStrengthMeter = document.getElementById('register-strength-meter');
            const registerPasswordInput = document.getElementById('register-password');

            if (registerStrengthMeter && registerPasswordInput) {
                registerPasswordInput.addEventListener('input', () => {
                    const value = registerPasswordInput.value;
                    let strength = 0;

                    if (value.length >= 8) strength++;
                    if (value.length >= 12) strength++;
                    if (/[a-z]/.test(value)) strength++;
                    if (/[A-Z]/.test(value)) strength++;
                    if (/[0-9]/.test(value)) strength++;
                    if (/[^a-zA-Z0-9]/.test(value)) strength++;

                    const strengthLabels = ['Too short', 'Weak', 'Medium', 'Strong'];
                    const strengthColors = ['#dc3545', '#fd7e14', '#ffc107', '#28a745'];
                    const strengthBgColors = ['rgba(220, 53, 69, 0.1)', 'rgba(253, 126, 20, 0.1)', 'rgba(255, 193, 7, 0.1)', 'rgba(40, 167, 69, 0.1)'];

                    if (value.length === 0) {
                        registerStrengthMeter.innerHTML = '';
                        registerStrengthMeter.style.display = 'none';
                    } else {
                        registerStrengthMeter.style.display = 'block';
                        registerStrengthMeter.innerHTML = `
                            <span style="color: ${strengthColors[Math.min(strength - 1, 3)]}">
                                ${strengthLabels[Math.min(strength - 1, 3)]}
                            </span>
                        `;
                        registerStrengthMeter.style.background = strengthBgColors[Math.min(strength - 1, 3)];
                        registerStrengthMeter.style.padding = '4px 8px';
                        registerStrengthMeter.style.borderRadius = '4px';
                        registerStrengthMeter.style.marginTop = '4px';
                        registerStrengthMeter.style.display = 'inline-block';
                    }
                });
            }

            // Forgot password new strength meter
            const forgotNewStrengthMeter = document.getElementById('forgot-new-strength-meter');
            const forgotNewPasswordInput = document.getElementById('forgot-new-password');

            if (forgotNewStrengthMeter && forgotNewPasswordInput) {
                forgotNewPasswordInput.addEventListener('input', () => {
                    const value = forgotNewPasswordInput.value;
                    let strength = 0;

                    if (value.length >= 8) strength++;
                    if (value.length >= 12) strength++;
                    if (/[a-z]/.test(value)) strength++;
                    if (/[A-Z]/.test(value)) strength++;
                    if (/[0-9]/.test(value)) strength++;
                    if (/[^a-zA-Z0-9]/.test(value)) strength++;

                    const strengthLabels = ['Too short', 'Weak', 'Medium', 'Strong'];
                    const strengthColors = ['#dc3545', '#fd7e14', '#ffc107', '#28a745'];
                    const strengthBgColors = ['rgba(220, 53, 69, 0.1)', 'rgba(253, 126, 20, 0.1)', 'rgba(255, 193, 7, 0.1)', 'rgba(40, 167, 69, 0.1)'];

                    if (value.length === 0) {
                        forgotNewStrengthMeter.innerHTML = '';
                        forgotNewStrengthMeter.style.display = 'none';
                    } else {
                        forgotNewStrengthMeter.style.display = 'block';
                        forgotNewStrengthMeter.innerHTML = `
                            <span style="color: ${strengthColors[Math.min(strength - 1, 3)]}">
                                ${strengthLabels[Math.min(strength - 1, 3)]}
                            </span>
                        `;
                        forgotNewStrengthMeter.style.background = strengthBgColors[Math.min(strength - 1, 3)];
                        forgotNewStrengthMeter.style.padding = '4px 8px';
                        forgotNewStrengthMeter.style.borderRadius = '4px';
                        forgotNewStrengthMeter.style.marginTop = '4px';
                        forgotNewStrengthMeter.style.display = 'inline-block';
                    }
                });
            }

            // Real-time inline email validation for Registration
            const registerEmailInput = document.getElementById('register-email');
            const registerEmailStatus = document.getElementById('register-email-status');

            if (registerEmailInput && registerEmailStatus) {
                registerEmailInput.addEventListener('blur', async function() {
                    const email = registerEmailInput.value.trim();
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    if (!email) {
                        registerEmailStatus.innerHTML = '';
                        registerEmailStatus.style.display = 'none';
                        return;
                    }

                    if (!emailRegex.test(email)) {
                        registerEmailStatus.innerHTML = '<span style="color: #dc3545;">Please enter a valid email address.</span>';
                        registerEmailStatus.style.display = 'block';
                        return;
                    }

                    try {
                        const response = await fetch('/api/check-email-availability', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ email: email })
                        });

                        const data = await response.json();

                        if (data.available) {
                            registerEmailStatus.innerHTML = '<span style="color: #28a745;">Email is available.</span>';
                            registerEmailStatus.style.display = 'block';
                        } else {
                            registerEmailStatus.innerHTML = '<span style="color: #dc3545;">This email is already registered.</span>';
                            registerEmailStatus.style.display = 'block';
                        }
                    } catch (error) {
                        console.error('Email check failed:', error);
                        registerEmailStatus.innerHTML = '<span style="color: #6c757d;">Unable to check availability.</span>';
                        registerEmailStatus.style.display = 'block';
                    }
                });
            }
        });
    </script>
</body>

</html>
