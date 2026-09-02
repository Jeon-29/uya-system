<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * All six form sections live on one page. Each gets its own validation
     * error bag so a failure in one form never bleeds into another form's
     * same-named field (e.g. "email" appears on 3 different forms here).
     */
    private const BAG_LOGIN = 'login';
    private const BAG_REGISTER = 'register';
    private const BAG_REGISTER_OTP = 'registerOtp';
    private const BAG_FORGOT_EMAIL = 'forgotEmail';
    private const BAG_FORGOT_OTP = 'forgotOtp';
    private const BAG_FORGOT_PASSWORD = 'forgotPassword';

    /**
     * Show the combined login / register / forgot-password page.
     */
    public function show(Request $request)
    {
        return view('auth.login', [
            'activeForm' => $request->session()->get('active_form', 'form-login'),
            'registerEmail' => $request->session()->get('register_email'),
            'resetEmail' => $request->session()->get('reset_email'),
        ]);
    }

    /**
     * Handle a login attempt.
     */
    public function login(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, self::BAG_LOGIN)
                ->withInput($request->only('email'))
                ->with('active_form', 'form-login');
        }

        $credentials = $validator->validated();
        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['email' => 'These credentials do not match our records.'], self::BAG_LOGIN)
                ->withInput($request->only('email'))
                ->with('active_form', 'form-login');
        }

        if (! $user->email_verified_at) {
            $otp = $user->generateOtp();
            Mail::to($user->email)->send(new OtpMail($otp, 'verification'));

            // register_email must survive more than one redirect (it's read
            // again when the OTP form itself is submitted), so it goes in
            // persistent session storage rather than one-shot flash data.
            $request->session()->put('register_email', $user->email);

            return redirect()->route('login')
                ->with('active_form', 'form-register-otp')
                ->with('status', 'Please verify your email first. We just sent a new code to '.$user->email.'.');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Handle a new account registration and kick off email verification.
     */
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
        Mail::to($user->email)->send(new OtpMail($otp, 'verification'));

        $request->session()->put('register_email', $user->email);

        return redirect()->route('login')
            ->with('active_form', 'form-register-otp')
            ->with('status', 'We sent a 6-digit code to '.$user->email.'.');
    }

    /**
     * Verify the OTP sent during registration and log the new user in.
     */
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

    /**
     * Resend the registration OTP.
     */
    public function resendRegistrationOtp(Request $request): RedirectResponse
    {
        $email = $request->session()->get('register_email');
        $user = $email ? User::where('email', $email)->first() : null;

        if (! $user) {
            return redirect()->route('login')->with('active_form', 'form-register');
        }

        $otp = $user->generateOtp();
        Mail::to($user->email)->send(new OtpMail($otp, 'verification'));

        return back()
            ->with('active_form', 'form-register-otp')
            ->with('status', 'A new code was sent to '.$user->email.'.');
    }

    /**
     * Start the forgot-password flow by emailing an OTP.
     */
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
        Mail::to($user->email)->send(new OtpMail($otp, 'password reset'));

        $request->session()->put('reset_email', $user->email);

        return redirect()->route('login')
            ->with('active_form', 'form-forgot-otp')
            ->with('status', 'We sent a 6-digit code to '.$user->email.'.');
    }

    /**
     * Verify the forgot-password OTP before letting the user set a new password.
     */
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

    /**
     * Resend the forgot-password OTP.
     */
    public function resendPasswordOtp(Request $request): RedirectResponse
    {
        $email = $request->session()->get('reset_email');
        $user = $email ? User::where('email', $email)->first() : null;

        if (! $user) {
            return redirect()->route('login')->with('active_form', 'form-forgot-step1');
        }

        $otp = $user->generateOtp();
        Mail::to($user->email)->send(new OtpMail($otp, 'password reset'));

        return back()
            ->with('active_form', 'form-forgot-otp')
            ->with('status', 'A new code was sent to '.$user->email.'.');
    }

    /**
     * Set the new password once the OTP has been verified.
     */
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

    /**
     * Log the current user out.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
