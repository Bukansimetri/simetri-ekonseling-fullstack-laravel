<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomLoginController extends Controller
{
    public function showLoginForm()
    {
        $herosection = HeroSection::where('is_active', 1)
            ->latest()
            ->limit(1)
            ->get();

        $service = Service::where('is_active', 1)
            ->latest()
            ->limit(3)
            ->get();

        return view('auth.login', compact('herosection', 'service'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('web')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            \Log::info('Login Success:', ['user' => Auth::user()]);

            // dd(Auth::user());

            return redirect()->route('homepage');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
