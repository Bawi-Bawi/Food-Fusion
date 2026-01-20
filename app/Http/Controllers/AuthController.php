<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\EmailOtp;
use App\Mail\EmailOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    //register
    public function register(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        $user = User::create([
            'first_name' => $request->fname,
            'last_name' => $request->lname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => null,
        ]);
        $this->sendOTP($user);
        return redirect()->route('verify#email#form')
        ->with('success', 'We sent a verification code to your email.');
    }

    //verify Email
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6'
        ]);

        $email = session('verify_email');

        $otp = EmailOtp::where('email', $email)->first();

        if (!$otp || now()->greaterThan($otp->expires_at)) {
            return back()->withErrors(['code' => 'Code expired']);
        }

        if (!Hash::check($request->code, $otp->code)) {
            return back()->withErrors(['code' => 'Invalid code']);
        }

        $user = User::where('email', $email)->firstOrFail();

        $user->email_verified_at = now();
        $user->save();

        // OTP is one-time use
        $otp->delete();

        // Login AFTER verification
        Auth::login($user);

        session()->forget('verify_email');

        return redirect()->route('home#page')
            ->with('success', 'Email verified successfully!');
    }
    //login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $key = 'login_attempts:' . $request->ip();
        $lockKey = 'login_lockout:' . $request->ip();

        if (Cache::has($lockKey)) {
            $secondsRemaining = Carbon::now()->diffInSeconds(Cache::get($lockKey));
            return back()->withErrors([
                'email' => "Too many attempts. Try again in $secondsRemaining seconds.",
            ]);
        }
        $user = User::where('email', $request->email)->firstOrFail();
        if($user->email_verified_at === null){
            $this->sendOTP($user);
            return redirect()->route('verify#email#form')
            ->with('success', 'We sent a verification code to your email.');
        }
        if (Auth::attempt($request->only('email', 'password'))) {
            Cache::forget($key); // clear attempts
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin#dashboard')->with('success', 'Logged in successfully.');
            }else {
                return redirect('/home')->with('success', 'Logged in successfully.');
            }
        }

        $attempts = Cache::get($key, 0) + 1;

        if ($attempts >= 3) {
            Cache::put($lockKey, Carbon::now()->addMinutes(3), now()->addMinutes(3));
            Cache::forget($key);
            return back()->withErrors([
                'email' => 'Account locked due to 3 failed attempts. Try again in 3 minutes.',
            ]);
        }

        Cache::put($key, $attempts, now()->addMinutes(3));

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }
    //logout
    public function logout()
    {
        Auth::logout();
        return back()->with('success', 'Logged out successfully.');
    }

    //send OTP
    private function sendOTP($user){
        // Generate OTP
        $code = random_int(100000, 999999);
        EmailOtp::updateOrCreate(
            ['email' => $user->email],
            [
                'code' => bcrypt($code),
                'expires_at' => now()->addMinutes(10)
            ]
        );
        // Send OTP email
        Mail::to($user->email)->send(new EmailOtpMail($code));

        // Store email in session for verification step
        session(['verify_email' => $user->email]);
    }
}

