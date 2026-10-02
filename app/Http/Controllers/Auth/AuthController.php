<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private const BAG_LOGIN = 'login';
    private const BAG_REGISTER = 'register';
    private const BAG_REGISTER_OTP = 'registerOtp';
    private const BAG_FORGOT_EMAIL = 'forgotEmail';
    private const BAG_FORGOT_OTP = 'forgotOtp';
    private const BAG_FORGOT_PASSWORD = 'forgotPassword';

    public function show(Request $request)
    {
        return view('auth.login', [
            'activeForm' => $request->session()->get('active_form', 'form-login'),
            'registerEmail' => $request->session()->get('register_email'),
            'resetEmail' => $request->session()->get('reset_email'),
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, self::BAG_LOGIN)
                ->withInput($request->only('email'))
                ->with('active_form', 'form-login');
        }

        $email = filter_var(trim($request->input('email')), FILTER_SANITIZE_EMAIL);

        $user = User::where('email', $email)->first();

        if (! $user) {
            Hash::check($request->input('password'), '$2y$10$0123456789012345678901AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');
            return back()
                ->withErrors(['email' => 'Invalid email or password.'], self::BAG_LOGIN)
                ->withInput($request->only('email'))
                ->with('active_form', 'form-login');
        }

        if ($user->locked_until && Carbon::now()->lt($user->locked_until)) {
            $remaining = Carbon::now()->diffInSeconds($user->locked_until);
            $minutes = ceil($remaining / 60);

            return back()
                ->withErrors(['email' => 'Invalid email or password.'], self::BAG_LOGIN)
                ->withInput($request->only('email'))
                ->with('active_form', 'form-login')
                ->with('lockout_remaining', $minutes);
        }

        if (! Hash::check($request->input('password'), $user->password)) {
            $user->increment('failed_attempts');

            if ($user->failed_attempts >= 5) {
                $user->update([
                    'locked_until' => Carbon::now()->addMinute(),
                ]);
            }

            return back()
                ->withErrors(['email' => 'Invalid email or password.'], self::BAG_LOGIN)
                ->withInput($request->only('email'))
                ->with('active_form', 'form-login');
        }

        if ($user->failed_attempts > 0 || $user->locked_until) {
            $user->update([
                'failed_attempts' => 0,
                'locked_until' => null,
            ]);
        }

        if (! $user->email_verified_at) {
            $otp = $user->generateOtp();

            try {
                Mail::to($user->email)->send(new OtpMail($otp, 'verification'));
                $statusMsg = 'Please verify your email first. We just sent a new code to '.$user->email.'.';
            } catch (\Throwable $e) {
                Log::error('Login OTP email failed: '.$e->getMessage());
                $statusMsg = 'Code generated, but email delivery failed. Please check your connection or resend.';
            }

            $request->session()->put('register_email', $user->email);

            return redirect()->route('login')
                ->with('active_form', 'form-register-otp')
                ->with('status', $statusMsg);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        if (in_array($user->role, ['admin', 'officer'])) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('dashboard'));
    }

    public function register(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'email' => ['required', 'email', 'unique:users,email'],
            'gender' => ['required', 'string', 'in:Male,Female,Prefer not to say'],
            'contact_number' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, self::BAG_REGISTER)
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('active_form', 'form-register');
        }

        $user = User::create($validator->validated());

        $otp = $user->generateOtp();

        try {
            Mail::to($user->email)->send(new OtpMail($otp, 'verification'));
            $statusMsg = 'We sent a 6-digit code to '.$user->email.'.';
        } catch (\Throwable $e) {
            Log::error('Registration OTP email failed: '.$e->getMessage());
            $statusMsg = 'Account created! Email delivery failed, but you can request a new code.';
        }

        $request->session()->put('register_email', $user->email);

        return redirect()->route('login')
            ->with('active_form', 'form-register-otp')
            ->with('status', $statusMsg);
    }

    public function verifyRegistrationOtp(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'otp' => ['required', 'digits:6'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, self::BAG_REGISTER_OTP)
                ->with('active_form', 'form-register-otp');
        }

        $email = $request->session()->get('register_email');
        $user = $email ? User::where('email', $email)->first() : null;

        if (! $user) {
            return redirect()->route('login')
                ->with('active_form', 'form-register')
                ->withErrors(['name' => 'Your verification session expired. Please register again.'], self::BAG_REGISTER);
        }

        if (! $user->otpMatches($request->input('otp'))) {
            return back()
                ->withErrors(['otp' => 'That code is invalid or has expired.'], self::BAG_REGISTER_OTP)
                ->with('active_form', 'form-register-otp');
        }

        $user->forceFill(['email_verified_at' => now()])->save();
        $user->clearOtp();

        $request->session()->forget('register_email');

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('status', 'Your email has been verified!');
    }

    public function resendRegistrationOtp(Request $request): RedirectResponse
    {
        $email = $request->session()->get('register_email');
        $user = $email ? User::where('email', $email)->first() : null;

        if (! $user) {
            return redirect()->route('login')->with('active_form', 'form-register');
        }

        $otp = $user->generateOtp();

        try {
            Mail::to($user->email)->send(new OtpMail($otp, 'verification'));
            $statusMsg = 'A new code was sent to '.$user->email.'.';
        } catch (\Throwable $e) {
            Log::error('Resend Registration OTP failed: '.$e->getMessage());
            $statusMsg = 'Failed to send new code. Please try again shortly.';
        }

        return back()
            ->with('active_form', 'form-register-otp')
            ->with('status', $statusMsg);
    }

    public function sendPasswordOtp(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, self::BAG_FORGOT_EMAIL)
                ->withInput($request->only('email'))
                ->with('active_form', 'form-forgot-step1');
        }

        $user = User::where('email', $request->input('email'))->first();

        $otp = $user->generateOtp();

        try {
            Mail::to($user->email)->send(new OtpMail($otp, 'password reset'));
            $statusMsg = 'We sent a 6-digit code to '.$user->email.'.';
        } catch (\Throwable $e) {
            Log::error('Forgot Password OTP email failed: '.$e->getMessage());
            $statusMsg = 'Code generated, but email delivery failed. Please check your connection or resend.';
        }

        $request->session()->put('reset_email', $user->email);

        return redirect()->route('login')
            ->with('active_form', 'form-forgot-otp')
            ->with('status', $statusMsg);
    }

    public function verifyPasswordOtp(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'otp' => ['required', 'digits:6'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, self::BAG_FORGOT_OTP)
                ->with('active_form', 'form-forgot-otp');
        }

        $email = $request->session()->get('reset_email');
        $user = $email ? User::where('email', $email)->first() : null;

        if (! $user) {
            return redirect()->route('login')
                ->with('active_form', 'form-forgot-step1')
                ->withErrors(['email' => 'Your session expired. Please request a new code.'], self::BAG_FORGOT_EMAIL);
        }

        if (! $user->otpMatches($request->input('otp'))) {
            return back()
                ->withErrors(['otp' => 'That code is invalid or has expired.'], self::BAG_FORGOT_OTP)
                ->with('active_form', 'form-forgot-otp');
        }

        $user->clearOtp();
        $request->session()->put('reset_verified', true);

        return redirect()->route('login')->with('active_form', 'form-forgot-new');
    }

    public function resendPasswordOtp(Request $request): RedirectResponse
    {
        $email = $request->session()->get('reset_email');
        $user = $email ? User::where('email', $email)->first() : null;

        if (! $user) {
            return redirect()->route('login')->with('active_form', 'form-forgot-step1');
        }

        $otp = $user->generateOtp();

        try {
            Mail::to($user->email)->send(new OtpMail($otp, 'password reset'));
            $statusMsg = 'A new code was sent to '.$user->email.'.';
        } catch (\Throwable $e) {
            Log::error('Resend Password OTP failed: '.$e->getMessage());
            $statusMsg = 'Failed to send new code. Please try again shortly.';
        }

        return back()
            ->with('active_form', 'form-forgot-otp')
            ->with('status', $statusMsg);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $email = $request->session()->get('reset_email');
        $verified = $request->session()->get('reset_verified', false);

        if (! $email || ! $verified) {
            return redirect()->route('login')
                ->with('active_form', 'form-forgot-step1')
                ->withErrors(['email' => 'Please verify your code again before setting a new password.'], self::BAG_FORGOT_EMAIL);
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, self::BAG_FORGOT_PASSWORD)
                ->with('active_form', 'form-forgot-new');
        }

        $user = User::where('email', $email)->firstOrFail();
        $user->forceFill(['password' => $validator->validated()['password']])->save();

        $request->session()->forget(['reset_email', 'reset_verified']);

        return redirect()->route('login')
            ->with('active_form', 'form-login')
            ->with('status', 'Your password has been updated. Please sign in.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function checkEmailAvailability(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'available' => false,
                'message' => 'Invalid email format.',
            ]);
        }

        $email = filter_var(trim($request->input('email')), FILTER_SANITIZE_EMAIL);
        $exists = User::where('email', $email)->exists();

        return response()->json([
            'available' => ! $exists,
            'message' => $exists ? 'This email is already registered.' : 'Email is available.',
        ]);
    }
}
