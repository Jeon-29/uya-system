@php
    $activeForm = $activeForm ?? 'form-login';
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UYA</title>
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
            padding: 0;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 8px;
            border: 1px solid #ced4da;
        }

        /* Status toast */
        .status-toast {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            margin: 1rem 0 0;
            z-index: 10;
            max-width: 90%;
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        .status-toast.hide-toast {
            opacity: 0;
            transform: translate(-50%, -12px);
            pointer-events: none;
        }

        /* Liquid Glass Bottom Privacy Banner */
        .privacy-banner-glass {
            position: fixed;
            bottom: 1rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            width: calc(100% - 2rem);
            max-width: 560px;
            background: rgba(255, 255, 255, 0.88) !important;
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.95) !important;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(34, 77, 91, 0.2);
            padding: 0.9rem 1.2rem;
            display: none;
        }

        /* Glass Modal Custom Styling */
        .glass-modal-content {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 20px 50px rgba(34, 77, 91, 0.25) !important;
        }

        .privacy-scroll-box {
            max-height: 280px;
            overflow-y: auto;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 1rem;
            font-size: 0.82rem;
            color: #334155;
            line-height: 1.5;
        }

        @media (max-width: 991px) {
            .status-toast {
                position: fixed;
                top: calc(env(safe-area-inset-top, 0px) + 12px);
                margin: 0;
                z-index: 1080;
                width: max-content;
                max-width: calc(100vw - 32px);
            }
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
                <div style="width: 120px; height: 120px; background-color: #83b6be; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; border: 3px solid var(--uya-gold); box-shadow: 0 4px 10px rgba(0,0,0,0.3); overflow: hidden;">
                    <img src="{{ asset('images/logo.jpg') }}" alt="UYA Logo" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
            <h2 class="fw-bold mb-1">Union of Youth Alliance</h2>
            <p class="text-white-50 small px-4">Unite Lead Serve</p>
        </div>

        <!-- Right Forms Panel -->
        <div class="col-lg-7 right-panel">

            @if (session('status'))
                <div id="statusToast" class="alert alert-success status-toast shadow-sm mb-0" role="alert">
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
                            class="form-control @error('email', 'login') is-invalid @enderror" placeholder="Enter email" required>
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
                    <p class="text-muted small">Join UYA today</p>
                </div>
                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf
                    <div class="row g-2 mb-2">
                        <div class="col-12 col-sm-5">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}"
                                class="form-control @error('first_name', 'register') is-invalid @enderror"
                                placeholder="First name" required>
                            @error('first_name', 'register')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-4 col-sm-2">
                            <label class="form-label">M.I. <span class="text-muted fw-normal">(Opt.)</span></label>
                            <input type="text" name="middle_initial" id="register-mi" value="{{ old('middle_initial') }}"
                                maxlength="2"
                                class="form-control text-center text-uppercase @error('middle_initial', 'register') is-invalid @enderror"
                                placeholder="M.I.">
                            @error('middle_initial', 'register')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-8 col-sm-5">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}"
                                class="form-control @error('last_name', 'register') is-invalid @enderror"
                                placeholder="Last name" required>
                            @error('last_name', 'register')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-12 col-md-4">
                            <label class="form-label">Age</label>
                            <input type="number" name="age" value="{{ old('age') }}" min="1" max="120"
                                class="form-control @error('age', 'register') is-invalid @enderror"
                                placeholder="Enter age">
                            @error('age', 'register')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email', 'register') is-invalid @enderror"
                                placeholder="Enter email address" id="register-email">
                            <span id="register-email-status" class="small mt-1 d-block"></span>
                            @error('email', 'register')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
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
                        <div class="col-12 col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" id="register-contact"
                                value="{{ old('contact_number') }}"
                                class="form-control @error('contact_number', 'register') is-invalid @enderror"
                                placeholder="Enter contact number" inputmode="numeric" pattern="[0-9]*" maxlength="15">
                            @error('contact_number', 'register')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" value="{{ old('address') }}"
                            class="form-control @error('address', 'register') is-invalid @enderror"
                            placeholder="Enter Address">
                        @error('address', 'register')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-6">
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
                        <div class="col-12 col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <div class="password-wrapper">
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Re-enter Password">
                                <i class="fa-regular fa-eye password-toggle"></i>
                            </div>
                        </div>
                    </div>

                    <!-- DATA PRIVACY ACT CONSENT CHECKBOX -->
                    <div class="form-check mb-3 text-start">
                        <input class="form-check-input @error('privacy_policy', 'register') is-invalid @enderror" type="checkbox" name="privacy_policy" id="privacyPolicyCheck" value="1" required>
                        <label class="form-check-label small text-muted" for="privacyPolicyCheck" style="font-size: 0.78rem;">
                            I agree to the <a href="javascript:void(0)" id="triggerPrivacyModal" class="link-brand">Privacy Policy</a> and consent to the processing of my personal data under the <strong>Data Privacy Act of 2012</strong>.
                        </label>
                        @error('privacy_policy', 'register')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" id="registerSubmitBtn" class="btn btn-primary w-100 mb-2 shadow-sm" disabled>Register</button>
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
                    <button type="submit" id="resend-reg-btn" class="btn btn-link link-brand p-0 text-decoration-none">Resend code</button>
                </form>
                <div class="text-center small">
                    <span class="link-brand" onclick="switchForm('form-register')"><i class="fa-solid fa-arrow-left me-1"></i> Back to registration</span>
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
                        <span class="link-brand" onclick="switchForm('form-login')"><i class="fa-solid fa-arrow-left me-1"></i> Back to login</span>
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
                    <button type="submit" id="resend-pwd-btn" class="btn btn-link link-brand p-0 text-decoration-none">Resend code</button>
                </form>
                <div class="text-center small">
                    <span class="link-brand" onclick="switchForm('form-forgot-step1')"><i class="fa-solid fa-arrow-left me-1"></i> Back to email step</span>
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
                        <span class="link-brand" onclick="switchForm('form-forgot-otp')"><i class="fa-solid fa-arrow-left me-1"></i> Back to OTP step</span>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- FIRST-TIME VISIT PRIVACY & COOKIE BANNER -->
    <div id="privacyBanner" class="privacy-banner-glass">
        <div class="d-flex align-items-center justify-content-between gap-3">
            <p class="small text-dark mb-0 fw-medium" style="font-size: 0.8rem; line-height: 1.35;">
                <i class="fa-solid fa-shield-halved text-brand me-1"></i> We protect your personal information under the <strong>Data Privacy Act of 2012</strong>. Read our <a href="{{ route('privacy.policy') }}" target="_blank" class="link-brand">Privacy Policy</a>.
            </p>
            <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 flex-shrink-0" id="acceptPrivacyBtn" style="font-size: 0.75rem;">
                Acknowledge
            </button>
        </div>
    </div>

    <!-- DATA PRIVACY ACT AGREEMENT MODAL -->
    <div class="modal fade" id="dataPrivacyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 p-3 glass-modal-content">
                <div class="modal-header border-0 pb-2">
                    <h5 class="modal-title fw-bold text-brand d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user-shield text-brand fs-4"></i>
                        Data Privacy Agreement (RA 10173)
                    </h5>
                </div>
                <div class="modal-body py-2">
                    <p class="small text-muted mb-2">
                        In compliance with the <strong>Data Privacy Act of 2012 (Republic Act No. 10173)</strong>, please review how the Union of Youth Alliance collects, uses, and protects your personal information:
                    </p>
                    <div class="privacy-scroll-box shadow-inner mb-3">
                        <h6 class="fw-bold text-dark mb-1">1. Information We Collect</h6>
                        <p class="mb-2">We collect your full name, age, email address, gender, contact number, complete address, profile photo, and activity logs when you register and interact with our platform.</p>

                        <h6 class="fw-bold text-dark mb-1">2. Purpose of Collection</h6>
                        <p class="mb-2">Your information is strictly processed to verify identity, track activity attendance via QR codes, issue verifiable digital certificates, process community proposals, and deliver official organizational notices.</p>

                        <h6 class="fw-bold text-dark mb-1">3. Security & Protection</h6>
                        <p class="mb-2">All personal data is encrypted, secured via strict authentication controls, and stored in protected databases. Password hashes and verification tokens are managed with multi-tier fail-safes.</p>

                        <h6 class="fw-bold text-dark mb-1">4. Your Rights as a Data Subject</h6>
                        <p class="mb-0">Under Republic Act No. 10173, you retain the right to access, request corrections, or ask for the removal of your personal information at any time by contacting our Data Protection Officer.</p>
                    </div>
                    <p class="small text-dark fw-bold mb-0 text-center">
                        By clicking "I Agree", you give consent to the Union of Youth Alliance to collect and process your personal information.
                    </p>
                </div>
                <div class="modal-footer border-0 pt-2 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold" id="declinePrivacyBtn">Decline</button>
                    <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" id="agreePrivacyBtn">I Agree</button>
                </div>
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
            // ==========================================
            // DATA PRIVACY MODAL & CHECKBOX LOGIC
            // ==========================================
            const privacyCheck = document.getElementById('privacyPolicyCheck');
            const registerSubmitBtn = document.getElementById('registerSubmitBtn');
            const triggerPrivacyModal = document.getElementById('triggerPrivacyModal');
            const dataPrivacyModalEl = document.getElementById('dataPrivacyModal');
            const dataPrivacyModal = new bootstrap.Modal(dataPrivacyModalEl);
            const agreePrivacyBtn = document.getElementById('agreePrivacyBtn');
            const declinePrivacyBtn = document.getElementById('declinePrivacyBtn');

            if (privacyCheck) {
                privacyCheck.addEventListener('click', function(e) {
                    if (privacyCheck.checked) {
                        e.preventDefault();
                        privacyCheck.checked = false;
                        dataPrivacyModal.show();
                    } else {
                        registerSubmitBtn.disabled = true;
                    }
                });
            }

            if (triggerPrivacyModal) {
                triggerPrivacyModal.addEventListener('click', function(e) {
                    e.preventDefault();
                    dataPrivacyModal.show();
                });
            }

            if (agreePrivacyBtn) {
                agreePrivacyBtn.addEventListener('click', function() {
                    privacyCheck.checked = true;
                    registerSubmitBtn.disabled = false;
                    dataPrivacyModal.hide();
                });
            }

            if (declinePrivacyBtn) {
                declinePrivacyBtn.addEventListener('click', function() {
                    privacyCheck.checked = false;
                    registerSubmitBtn.disabled = true;
                    dataPrivacyModal.hide();
                });
            }

            if (!localStorage.getItem('privacy_acknowledged')) {
                document.getElementById('privacyBanner').style.display = 'block';
            }
            document.getElementById('acceptPrivacyBtn').addEventListener('click', function() {
                localStorage.setItem('privacy_acknowledged', '1');
                document.getElementById('privacyBanner').style.display = 'none';
            });

            const statusToast = document.getElementById('statusToast');
            if (statusToast) {
                setTimeout(() => {
                    statusToast.classList.add('hide-toast');
                    setTimeout(() => statusToast.remove(), 500);
                }, 3000);
            }

            // Middle initial: letters only, uppercase
            const miInput = document.getElementById('register-mi');
            if (miInput) {
                miInput.addEventListener('input', () => {
                    miInput.value = miInput.value.replace(/[^a-zA-Z]/g, '').toUpperCase().slice(0, 2);
                });
            }

            // Contact number: digits only
            const contactInput = document.getElementById('register-contact');
            if (contactInput) {
                const keepDigits = () => {
                    const cleaned = contactInput.value.replace(/\D/g, '');
                    if (cleaned !== contactInput.value) {
                        contactInput.value = cleaned;
                    }
                };
                contactInput.addEventListener('keydown', (e) => {
                    if (e.key.length === 1 && !/\d/.test(e.key) && !e.ctrlKey && !e.metaKey) {
                        e.preventDefault();
                    }
                });
                contactInput.addEventListener('input', keepDigits);
                keepDigits();
            }

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

            // OTP boxes
            document.querySelectorAll('.otp-form').forEach(form => {
                const digits = form.querySelectorAll('.otp-digit');
                const hidden = form.querySelector('input[name="otp"]');

                digits.forEach((digit, index) => {
                    digit.addEventListener('focus', () => digit.select());

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

            // Password strength meters
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
                        registerStrengthMeter.innerHTML = `<span style="color: ${strengthColors[Math.min(strength - 1, 3)]}">${strengthLabels[Math.min(strength - 1, 3)]}</span>`;
                        registerStrengthMeter.style.background = strengthBgColors[Math.min(strength - 1, 3)];
                        registerStrengthMeter.style.padding = '4px 8px';
                        registerStrengthMeter.style.borderRadius = '4px';
                        registerStrengthMeter.style.marginTop = '4px';
                        registerStrengthMeter.style.display = 'inline-block';
                    }
                });
            }

            // Real-time email check
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

            // OTP Cooldown Logic
            const sessionStatus = {!! json_encode(session('status') ?: '') !!};
            const activeFormId = {!! json_encode($activeForm) !!};

            function initCooldown(formId, btnId, storageKey) {
                const btn = document.getElementById(btnId);
                if (!btn) return;

                if (sessionStatus && (sessionStatus.includes('sent') || sessionStatus.includes('code')) && activeFormId === formId) {
                    const existing = parseInt(localStorage.getItem(storageKey)) || 0;
                    if (existing <= Date.now()) {
                        localStorage.setItem(storageKey, Date.now() + 60000);
                    }
                }

                const expiry = parseInt(localStorage.getItem(storageKey)) || 0;
                if (expiry > Date.now()) {
                    startTick(btn, expiry, storageKey);
                } else {
                    localStorage.removeItem(storageKey);
                }
            }

            function startTick(btn, expiry, storageKey) {
                btn.disabled = true;
                btn.style.pointerEvents = 'none';
                btn.style.color = '#6c757d';
                btn.classList.remove('link-brand');

                const interval = setInterval(() => {
                    const now = Date.now();
                    const remaining = Math.ceil((expiry - now) / 1000);

                    if (remaining <= 0) {
                        clearInterval(interval);
                        btn.disabled = false;
                        btn.style.pointerEvents = 'auto';
                        btn.style.color = '';
                        btn.classList.add('link-brand');
                        btn.textContent = 'Resend code';
                        localStorage.removeItem(storageKey);
                    } else {
                        btn.textContent = `Resend in ${remaining}s`;
                    }
                }, 1000);
            }

            initCooldown('form-register-otp', 'resend-reg-btn', 'reg_otp_cooldown');
            initCooldown('form-forgot-otp', 'resend-pwd-btn', 'pwd_otp_cooldown');

            // Double click prevention
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const btn = this.querySelector('button[type="submit"].btn-primary');
                    if (btn) {
                        setTimeout(() => {
                            btn.disabled = true;
                            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-2"></i> Verifying...';
                        }, 50);
                    }
                });
            });
        });
    </script>
</body>

</html>
