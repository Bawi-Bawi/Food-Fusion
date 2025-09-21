<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
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
    public function logout()
    {
        Auth::logout();
        return back()->with('success', 'Logged out successfully.');
    }

    public function dashboard()
    {

        if (Auth::check() && Auth::user()->role === 'admin') {
             $users = User::when(request('table_search'),function($query){
                return $query->orWhere('first_name','LIKE','%'.request('table_search').'%')
                                ->orWhere('last_name','LIKE','%'.request('table_search').'%')
                             ->orWhere('email','LIKE','%'.request('table_search').'%');
            })->paginate(5);
            $users->appends(request()->all());
            return view('admin.dashboard',compact('users'));
        }
        return redirect('/home');
    }
}
