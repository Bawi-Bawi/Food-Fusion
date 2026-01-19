<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmailOtp;
use App\Mail\EmailOtpMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
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
}
